<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Proposal;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    public function create(Project $project)
    {
        // Don't allow company to apply to their own project
        if (auth()->check() && auth()->user()->company && auth()->user()->company->id === $project->company_id) {
            return redirect()->route('projects.show', $project->id)->with('error', 'Anda tidak dapat mengirim proposal ke proyek Anda sendiri.');
        }

        $user = auth()->user();
        $portfolios = $user->company ? $user->company->portfolios : collect();

        return view('proposals.create', compact('project', 'portfolios'));
    }

    public function store(Request $request, Project $project)
    {
        $user = auth()->user();
        
        if ($user->company->id === $project->company_id) {
            return back()->with('error', 'Anda tidak dapat mengirim proposal ke proyek Anda sendiri.');
        }

        $validated = $request->validate([
            'cover_letter' => 'required|string',
            'estimated_value' => 'nullable|numeric',
            'attachment' => 'nullable|file|mimes:pdf,zip,doc,docx|max:10240', // max 10MB
            'pinned_portfolios' => 'nullable|array|max:3',
            'pinned_portfolios.*' => 'exists:company_portfolios,id',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment') && $request->file('attachment')->isValid()) {
            $file = $request->file('attachment');
            $filename = $file->hashName();
            \Illuminate\Support\Facades\Storage::disk('public')->put('proposals/' . $filename, file_get_contents($file->getPathname()));
            $attachmentPath = 'proposals/' . $filename;
        }

        $proposal = Proposal::create([
            'project_id' => $project->id,
            'company_id' => $user->company->id,
            'cover_letter' => $validated['cover_letter'],
            'estimated_value' => $validated['estimated_value'] ?? null,
            'attachment' => $attachmentPath,
            'pinned_portfolios' => $validated['pinned_portfolios'] ?? [],
            'status' => 'pending',
        ]);

        $rabMode = $request->input('rab_mode', 'none');
        $rabData = json_decode($request->input('rab_data'), true) ?? [];
        
        if ($rabMode === 'use_project' && $project->rab) {
            $newRab = $proposal->rab()->create([
                'title' => $project->rab->title,
                'total_amount' => $project->rab->total_amount
            ]);
            
            foreach ($project->rab->categories as $cat) {
                $newCat = $newRab->categories()->create([
                    'name' => $cat->name,
                    'total_amount' => $cat->total_amount
                ]);
                
                foreach ($cat->items as $item) {
                    $newCat->items()->create([
                        'name' => $item->name,
                        'volume' => $item->volume,
                        'unit' => $item->unit,
                        'unit_price' => $item->unit_price,
                        'total_price' => $item->total_price
                    ]);
                }
            }
            $proposal->update(['estimated_value' => $project->rab->total_amount]);
        } elseif (($rabMode === 'create_new' || $rabMode === 'edit_project') && !empty($rabData)) {
            $rabTotal = collect($rabData)->reduce(function ($sum, $cat) {
                $catTotal = collect($cat['items'] ?? [])->reduce(function ($itemSum, $item) {
                    return $itemSum + ((float)($item['volume'] ?? 0) * (float)($item['unit_price'] ?? 0));
                }, 0);
                return $sum + $catTotal;
            }, 0);
            
            if ($rabTotal > 0) {
                $proposal->update(['estimated_value' => $rabTotal]);
                
                $rab = $proposal->rab()->create([
                    'title' => 'Rencana Anggaran Biaya (RAB)',
                    'total_amount' => $rabTotal
                ]);
                
                foreach ($rabData as $cat) {
                    if (empty($cat['name'])) continue;
                    $catTotal = collect($cat['items'] ?? [])->reduce(function ($itemSum, $item) {
                        return $itemSum + ((float)($item['volume'] ?? 0) * (float)($item['unit_price'] ?? 0));
                    }, 0);
                    
                    $category = $rab->categories()->create([
                        'name' => $cat['name'],
                        'total_amount' => $catTotal
                    ]);
                    
                    foreach ($cat['items'] ?? [] as $item) {
                        if (empty($item['name'])) continue;
                        $category->items()->create([
                            'name' => $item['name'],
                            'volume' => $item['volume'] ?? 0,
                            'unit' => $item['unit'] ?? null,
                            'unit_price' => $item['unit_price'] ?? 0,
                            'total_price' => ((float)($item['volume'] ?? 0) * (float)($item['unit_price'] ?? 0))
                        ]);
                    }
                }
            }
        }

        // Auto-accept any pending invitations for this project and company
        \App\Models\ProjectInvitation::where('project_id', $project->id)
            ->where('invited_company_id', $user->company->id)
            ->where('status', 'pending')
            ->update(['status' => 'accepted']);

        $isUB = in_array(strtolower($user->company->skala_usaha ?? ''), ['besar']);
        $message = $isUB ? 'Ketertarikan/Permintaan berhasil dikirim!' : 'Proposal/Penawaran berhasil dikirim!';

        return redirect()->route('projects.show', $project->id)->with('success', $message);
    }

    public function show(Proposal $proposal)
    {
        $user = auth()->user();
        
        // Ensure user is either the one who sent the proposal or the owner of the project
        $isSender = $user->company->id === $proposal->company_id;
        $isProjectOwner = $user->company->id === $proposal->project->company_id;
        
        if (!$isSender && !$isProjectOwner) {
            abort(403);
        }

        // If the project owner opens a pending proposal, automatically mark it as reviewed
        if ($isProjectOwner && $proposal->status === 'pending') {
            $proposal->update(['status' => 'reviewed']);
        }

        return view('proposals.show', compact('proposal', 'isSender', 'isProjectOwner'));
    }

    public function updateStatus(Request $request, Proposal $proposal)
    {
        // Only project owner can update status
        if ($proposal->project->company_id !== auth()->user()->company->id) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,negotiating,accepted,rejected',
        ]);

        $proposal->update(['status' => $validated['status']]);

        return back()->with('success', 'Status proposal berhasil diperbarui.');
    }

    public function editRab(Proposal $proposal)
    {
        $user = auth()->user();
        if ($proposal->company_id !== $user->company->id) {
            abort(403);
        }
        if ($proposal->status !== 'negotiating') {
            return back()->with('error', 'Revisi RAB hanya dapat dilakukan pada tahap negosiasi.');
        }
        return view('proposals.edit-rab', compact('proposal'));
    }

    public function updateRab(Request $request, Proposal $proposal)
    {
        $user = auth()->user();
        if ($proposal->company_id !== $user->company->id) {
            abort(403);
        }
        if ($proposal->status !== 'negotiating') {
            return back()->with('error', 'Revisi RAB hanya dapat dilakukan pada tahap negosiasi.');
        }

        $rabData = json_decode($request->input('rab_data'), true) ?? [];
        $rabTotal = collect($rabData)->reduce(function ($sum, $cat) {
            $catTotal = collect($cat['items'] ?? [])->reduce(function ($itemSum, $item) {
                return $itemSum + ((float)($item['volume'] ?? 0) * (float)($item['unit_price'] ?? 0));
            }, 0);
            return $sum + $catTotal;
        }, 0);

        $proposal->update(['estimated_value' => $rabTotal > 0 ? $rabTotal : ($request->input('estimated_value') ?? 0)]);

        if (!empty($rabData) && $rabTotal > 0) {
            $rab = $proposal->rab()->firstOrCreate([
                'title' => 'Rencana Anggaran Biaya (RAB)'
            ]);
            $rab->update(['total_amount' => $rabTotal]);
            
            $rab->categories()->delete();
            
            foreach ($rabData as $cat) {
                if (empty($cat['name'])) continue;
                $catTotal = collect($cat['items'] ?? [])->reduce(function ($itemSum, $item) {
                    return $itemSum + ((float)($item['volume'] ?? 0) * (float)($item['unit_price'] ?? 0));
                }, 0);
                
                $category = $rab->categories()->create([
                    'name' => $cat['name'],
                    'total_amount' => $catTotal
                ]);
                
                foreach ($cat['items'] ?? [] as $item) {
                    if (empty($item['name'])) continue;
                    $category->items()->create([
                        'name' => $item['name'],
                        'volume' => $item['volume'] ?? 0,
                        'unit' => $item['unit'] ?? null,
                        'unit_price' => $item['unit_price'] ?? 0,
                        'total_price' => ((float)($item['volume'] ?? 0) * (float)($item['unit_price'] ?? 0))
                    ]);
                }
            }
        } else {
            if ($proposal->rab) {
                $proposal->rab->delete();
            }
        }

        // Add system message to the conversation to notify the project owner
        $conversation = \App\Models\Conversation::where('proposal_id', $proposal->id)->first();
        if ($conversation) {
            $conversation->messages()->create([
                'company_id' => $user->company->id,
                'body' => "📢 [SISTEM] RAB/Penawaran telah direvisi oleh " . $user->company->name . ". Silakan periksa detail proposal terbaru.",
            ]);
        }

        return redirect()->route('proposals.show', $proposal->id)->with('success', 'RAB berhasil direvisi.');
    }

    public function compareRab(Proposal $proposal)
    {
        $user = auth()->user();
        
        // Only project owner can compare RAB
        if ($proposal->project->company_id !== $user->company->id) {
            abort(403);
        }

        if (!$proposal->rab || !$proposal->project->rab) {
            return back()->with('error', 'Tidak dapat membandingkan RAB karena salah satu pihak tidak memiliki data RAB.');
        }

        return view('proposals.compare-rab', compact('proposal'));
    }
}
