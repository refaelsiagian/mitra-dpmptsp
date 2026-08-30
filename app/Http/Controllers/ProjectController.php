<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function create()
    {
        $company = auth()->user()->company;
        if (!$company) {
            return redirect()->back()->with('error', 'Lengkapi profil perusahaan terlebih dahulu.');
        }

        $provinces = \App\Models\Province::orderBy('name')->get();
        return view('company.project.create', compact('company', 'provinces'));
    }

    public function store(\App\Http\Requests\StoreProjectRequest $request)
    {
        $company = auth()->user()->company;

        $validated = $request->validated();
        
        $requirements = $request->input('requirements', []);
        $offerings = $request->input('offerings', []);

        // Default to false if not checked
        $validated['is_budget_negotiable'] = $request->has('is_budget_negotiable') ? 'true' : 'false';

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('projects/images', 'public');
        }

        // Handle file uploads (attachments)
        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('projects', 'public');
                $attachments[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'type' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                ];
            }
        }

        $metrics = $request->input('metrics', []);

        $validated['status'] = $validated['status'] ?? 'published';

        $project = $company->projects()->create(array_merge($validated, [
            'attachments' => $attachments,
            'metrics' => $metrics,
            // Filter out null/empty strings from arrays
            'requirements' => array_values(array_filter($requirements)),
            'offerings' => array_values(array_filter($offerings)),
        ]));

        $message = $validated['status'] === 'draft' ? 'Proyek berhasil disimpan sebagai draf!' : 'Proyek berhasil diterbitkan!';
        return redirect()->route('projects.show', $project->id)->with('success', $message);
    }

    public function show(\App\Models\Project $project)
    {
        $this->authorize('view', $project);

        $invitation = null;
        if (auth()->check() && auth()->user()->company) {
            $invitation = \App\Models\ProjectInvitation::where('project_id', $project->id)
                ->where('invited_company_id', auth()->user()->company->id)
                ->where('status', 'pending')
                ->first();
        }

        return view('company.project.show', compact('project', 'invitation'));
    }

    public function edit(\App\Models\Project $project)
    {
        $this->authorize('update', $project);
        
        $company = auth()->user()->company;
        $provinces = \App\Models\Province::orderBy('name')->get();
        return view('company.project.edit', compact('project', 'company', 'provinces'));
    }

    public function update(\App\Http\Requests\UpdateProjectRequest $request, \App\Models\Project $project)
    {
        $this->authorize('update', $project);

        $validated = $request->validated();
        
        $requirements = $request->input('requirements', []);
        $offerings = $request->input('offerings', []);

        $validated['is_budget_negotiable'] = $request->has('is_budget_negotiable') ? 'true' : 'false';

        if ($request->hasFile('image')) {
            if ($project->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($project->image);
            }
            $validated['image'] = $request->file('image')->store('projects/images', 'public');
        }

        // Handle file uploads (attachments)
        $attachments = $project->attachments ?? [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('projects', 'public');
                $attachments[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'type' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                ];
            }
        }

        $metrics = $request->input('metrics', []);

        // Prevent reverting a published project back to a draft
        $oldStatus = $project->status;
        if ($oldStatus === 'published' && ($validated['status'] ?? '') === 'draft') {
            $validated['status'] = 'published';
        } else {
            $validated['status'] = $validated['status'] ?? 'published';
        }

        $project->update(array_merge($validated, [
            'attachments' => $attachments,
            'metrics' => $metrics,
            'requirements' => array_values(array_filter($requirements)),
            'offerings' => array_values(array_filter($offerings)),
        ]));

        if ($oldStatus === 'draft' && $validated['status'] === 'published') {
            $message = 'Proyek berhasil diterbitkan!';
        } else {
            $message = $validated['status'] === 'draft' ? 'Draf berhasil diperbarui!' : 'Proyek berhasil diperbarui!';
        }
        
        return redirect()->route('projects.show', $project->id)->with('success', $message);
    }

    public function destroy(Request $request, \App\Models\Project $project)
    {
        $this->authorize('delete', $project);
        
        $project->delete();
        
        $redirectTo = $request->input('redirect_to', route('dashboard'));
        
        // If it's trying to redirect back to the project page itself, force dashboard
        if (str_contains($redirectTo, route('projects.show', $project->id))) {
            $redirectTo = route('dashboard');
        }
        
        return redirect($redirectTo)->with('success', 'Proyek berhasil dihapus.');
    }

    public function close(\App\Models\Project $project)
    {
        $this->authorize('update', $project);
        $project->update(['status' => 'closed']);
        return back()->with('success', 'Proyek berhasil ditutup dan dipindahkan ke Riwayat Anda.');
    }

    public function toggleVisibility(\App\Models\Project $project)
    {
        $this->authorize('update', $project);
        
        $newVisibility = !$project->is_public;
        
        \Illuminate\Support\Facades\DB::table('projects')
            ->where('id', $project->id)
            ->update([
                'is_public' => \Illuminate\Support\Facades\DB::raw($newVisibility ? 'true' : 'false'),
                'updated_at' => now()
            ]);
            
        $status = $newVisibility ? 'publik' : 'tersembunyi';
        return back()->with('success', "Proyek berhasil diubah menjadi {$status}.");
    }

    public function togglePin(\App\Models\Project $project)
    {
        $this->authorize('update', $project);

        $newPinStatus = !$project->is_pinned;

        // If pinning, unpin all other projects for this company
        if ($newPinStatus) {
            \Illuminate\Support\Facades\DB::table('projects')
                ->where('company_id', $project->company_id)
                ->where('id', '!=', $project->id)
                ->update(['is_pinned' => \Illuminate\Support\Facades\DB::raw('false')]);
        }

        // Toggle the target project
        \Illuminate\Support\Facades\DB::table('projects')
            ->where('id', $project->id)
            ->update([
                'is_pinned' => \Illuminate\Support\Facades\DB::raw($newPinStatus ? 'true' : 'false'),
                'updated_at' => now()
            ]);

        $status = $newPinStatus ? 'disematkan' : 'dilepaskan dari sematan';
        return back()->with('success', "Proyek berhasil {$status}.");
    }
}
