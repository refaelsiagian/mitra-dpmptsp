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

        $isUB = in_array(strtolower($user->company->skala_usaha ?? ''), ['menengah', 'besar']);
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
}
