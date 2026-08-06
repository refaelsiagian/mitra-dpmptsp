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

        return view('company.project.create', compact('company'));
    }

    public function store(Request $request)
    {
        $company = auth()->user()->company;

        $validated = $request->validate([
            'type' => 'required|in:subkontrak,rantai_pasok,outsourcing,konstruksi,kso,perdagangan,distribusi',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ruang_lingkup' => 'nullable|string',
            'estimated_value' => 'nullable|numeric',
            'is_budget_negotiable' => 'nullable|boolean',
            'location' => 'nullable|string|max:255',
            'offer_end_date' => 'nullable|date',
            'project_start_date' => 'nullable|date',
            'project_end_date' => 'nullable|date',
            'metrics' => 'nullable|array',
            'requirements' => 'nullable|array',
            'offerings' => 'nullable|array',
        ]);
        
        $requirements = $request->input('requirements', []);
        $offerings = $request->input('offerings', []);

        // Default to false if not checked
        $validated['is_budget_negotiable'] = $request->has('is_budget_negotiable');

        // Handle file uploads (attachments)
        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                // Read from getPathname() to avoid Windows/Laragon tmp issues
                $content = file_get_contents($file->getPathname());
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = 'projects/' . $filename;
                
                \Illuminate\Support\Facades\Storage::disk('public')->put($path, $content);
                
                $attachments[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                ];
            }
        }

        $metrics = $request->input('metrics', []);

        $project = $company->projects()->create(array_merge($validated, [
            'attachments' => $attachments,
            'metrics' => $metrics,
            // Filter out null/empty strings from arrays
            'requirements' => array_values(array_filter($requirements)),
            'offerings' => array_values(array_filter($offerings)),
        ]));

        return redirect()->route('rfp-saya')->with('success', 'Proyek berhasil diterbitkan!');
    }

    public function show(\App\Models\Project $project)
    {
        return view('company.project.show', compact('project'));
    }

    public function edit(\App\Models\Project $project)
    {
        // Ensure user owns the project
        if ($project->company_id !== auth()->user()->company->id) {
            abort(403);
        }
        
        $company = auth()->user()->company;
        return view('company.project.edit', compact('project', 'company'));
    }

    public function update(Request $request, \App\Models\Project $project)
    {
        // Ensure user owns the project
        if ($project->company_id !== auth()->user()->company->id) {
            abort(403);
        }

        $validated = $request->validate([
            'type' => 'required|in:subkontrak,rantai_pasok,outsourcing,konstruksi,kso,perdagangan,distribusi',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ruang_lingkup' => 'nullable|string',
            'estimated_value' => 'nullable|numeric',
            'is_budget_negotiable' => 'nullable|boolean',
            'location' => 'nullable|string|max:255',
            'offer_end_date' => 'nullable|date',
            'project_start_date' => 'nullable|date',
            'project_end_date' => 'nullable|date',
            'metrics' => 'nullable|array',
            'requirements' => 'nullable|array',
            'offerings' => 'nullable|array',
        ]);
        
        $requirements = $request->input('requirements', []);
        $offerings = $request->input('offerings', []);

        $validated['is_budget_negotiable'] = $request->has('is_budget_negotiable');

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

        $project->update(array_merge($validated, [
            'attachments' => $attachments,
            'metrics' => $metrics,
            'requirements' => array_values(array_filter($requirements)),
            'offerings' => array_values(array_filter($offerings)),
        ]));

        return redirect()->route('rfp-saya')->with('success', 'Proyek berhasil diperbarui!');
    }

    public function destroy(\App\Models\Project $project)
    {
        $project->delete();
        return redirect()->back()->with('success', 'Proyek berhasil dihapus.');
    }
}
