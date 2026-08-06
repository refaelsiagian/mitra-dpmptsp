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
            'type' => 'required|in:tender,kso,offering',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'estimated_value' => 'nullable|numeric',
            'location' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'metrics' => 'nullable|array',
            'requirements' => 'nullable|array',
            'offerings' => 'nullable|array',
        ]);
        
        $requirements = $request->input('requirements', []);
        $offerings = $request->input('offerings', []);

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

        $project = $company->projects()->create(array_merge($validated, [
            'attachments' => $attachments,
            // Filter out null/empty strings from arrays
            'requirements' => array_values(array_filter($requirements)),
            'offerings' => array_values(array_filter($offerings)),
        ]));

        return redirect()->route('projects.show', $project->id)->with('success', 'Proyek berhasil diterbitkan!');
    }

    public function show(\App\Models\Project $project)
    {
        return view('company.project.show', compact('project'));
    }

    public function edit(\App\Models\Project $project)
    {
        // TODO
    }

    public function update(Request $request, \App\Models\Project $project)
    {
        // TODO
    }

    public function destroy(\App\Models\Project $project)
    {
        $project->delete();
        return redirect()->back()->with('success', 'Proyek berhasil dihapus.');
    }
}
