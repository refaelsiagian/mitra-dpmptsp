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

    public function store(Request $request)
    {
        $company = auth()->user()->company;

        $validated = $request->validate([
            'status' => 'nullable|in:draft,published,closed',
            'type' => 'required|in:subkontrak,rantai_pasok,outsourcing,konstruksi,kso,perdagangan,distribusi',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'ruang_lingkup' => 'required|string',
            'estimated_value' => 'nullable|numeric',
            'is_budget_negotiable' => 'nullable|boolean',
            'image' => 'nullable|image|max:5120',
            'province_id' => 'nullable|required_with:regency_id,district_id,village_id,address|string|max:255',
            'regency_id' => 'nullable|required_with:province_id,district_id,village_id,address|string|max:255',
            'district_id' => 'nullable|required_with:province_id,regency_id,village_id,address|string|max:255',
            'village_id' => 'nullable|required_with:province_id,regency_id,district_id,address|string|max:255',
            'address' => 'nullable|required_with:province_id,regency_id,district_id,village_id|string',
            'offer_end_date' => 'nullable|date|after_or_equal:today',
            'project_start_date' => 'nullable|date|after:offer_end_date',
            'project_end_date' => 'nullable|date|after:project_start_date',
            'metrics' => 'nullable|array',
            'requirements' => 'required|array',
            'offerings' => 'required|array',
        ], [
            'province_id.required_with' => 'Provinsi wajib diisi jika lokasi proyek lainnya diisi.',
            'regency_id.required_with' => 'Kabupaten/Kota wajib diisi jika lokasi proyek lainnya diisi.',
            'district_id.required_with' => 'Kecamatan wajib diisi jika lokasi proyek lainnya diisi.',
            'village_id.required_with' => 'Desa/Kelurahan wajib diisi jika lokasi proyek lainnya diisi.',
            'address.required_with' => 'Alamat lengkap wajib diisi jika lokasi proyek lainnya diisi.',
            'offer_end_date.after_or_equal' => 'Batas penawaran tidak boleh lebih awal dari tanggal proyek diterbitkan (hari ini).',
            'project_start_date.after' => 'Mulai pelaksanaan tidak boleh lebih awal dari batas penawaran.',
            'project_end_date.after' => 'Selesai pelaksanaan tidak boleh lebih awal dari mulai pelaksanaan.',
        ]);
        
        $requirements = $request->input('requirements', []);
        $offerings = $request->input('offerings', []);

        // Default to false if not checked
        $validated['is_budget_negotiable'] = $request->has('is_budget_negotiable') ? 'true' : 'false';

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $content = file_get_contents($file->getPathname());
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = 'projects/images/' . $filename;
            
            \Illuminate\Support\Facades\Storage::disk('public')->put($path, $content);
            $validated['image'] = $path;
        }

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
        // Protect draft from being viewed by non-owners
        if ($project->status === 'draft') {
            if (!auth()->check() || !auth()->user()->company || auth()->user()->company->id !== $project->company_id) {
                abort(404);
            }
        }

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
        // Ensure user owns the project
        if ($project->company_id !== auth()->user()->company->id) {
            abort(403);
        }
        
        $company = auth()->user()->company;
        $provinces = \App\Models\Province::orderBy('name')->get();
        return view('company.project.edit', compact('project', 'company', 'provinces'));
    }

    public function update(Request $request, \App\Models\Project $project)
    {
        // Ensure user owns the project
        if ($project->company_id !== auth()->user()->company->id) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'nullable|in:draft,published,closed',
            'type' => 'required|in:subkontrak,rantai_pasok,outsourcing,konstruksi,kso,perdagangan,distribusi',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'ruang_lingkup' => 'required|string',
            'estimated_value' => 'nullable|numeric',
            'is_budget_negotiable' => 'nullable|boolean',
            'image' => 'nullable|image|max:5120',
            'province_id' => 'nullable|required_with:regency_id,district_id,village_id,address|string|max:255',
            'regency_id' => 'nullable|required_with:province_id,district_id,village_id,address|string|max:255',
            'district_id' => 'nullable|required_with:province_id,regency_id,village_id,address|string|max:255',
            'village_id' => 'nullable|required_with:province_id,regency_id,district_id,address|string|max:255',
            'address' => 'nullable|required_with:province_id,regency_id,district_id,village_id|string',
            'offer_end_date' => [
                'nullable',
                'date',
                function ($attribute, $value, $fail) use ($project) {
                    $newDate = \Carbon\Carbon::parse($value)->startOfDay();
                    $oldDate = $project->offer_end_date ? \Carbon\Carbon::parse($project->offer_end_date)->startOfDay() : null;
                    $today = \Carbon\Carbon::now()->startOfDay();
                    
                    if (!$oldDate || $newDate->notEqualTo($oldDate)) {
                        if ($newDate->isBefore($today)) {
                            $fail('Batas penawaran yang baru tidak boleh diatur ke masa lalu.');
                        }
                    }
                }
            ],
            'project_start_date' => 'nullable|date|after:offer_end_date',
            'project_end_date' => 'nullable|date|after:project_start_date',
            'metrics' => 'nullable|array',
            'requirements' => 'required|array',
            'offerings' => 'required|array',
        ], [
            'province_id.required_with' => 'Provinsi wajib diisi jika lokasi proyek lainnya diisi.',
            'regency_id.required_with' => 'Kabupaten/Kota wajib diisi jika lokasi proyek lainnya diisi.',
            'district_id.required_with' => 'Kecamatan wajib diisi jika lokasi proyek lainnya diisi.',
            'village_id.required_with' => 'Desa/Kelurahan wajib diisi jika lokasi proyek lainnya diisi.',
            'address.required_with' => 'Alamat lengkap wajib diisi jika lokasi proyek lainnya diisi.',
            'project_start_date.after' => 'Mulai pelaksanaan tidak boleh lebih awal dari batas penawaran.',
            'project_end_date.after' => 'Selesai pelaksanaan tidak boleh lebih awal dari mulai pelaksanaan.',
        ]);
        
        $requirements = $request->input('requirements', []);
        $offerings = $request->input('offerings', []);

        $validated['is_budget_negotiable'] = $request->has('is_budget_negotiable') ? 'true' : 'false';

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $content = file_get_contents($file->getPathname());
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = 'projects/images/' . $filename;
            
            \Illuminate\Support\Facades\Storage::disk('public')->put($path, $content);
            
            if ($project->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($project->image);
            }
            $validated['image'] = $path;
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
        $project->delete();
        
        $redirectTo = $request->input('redirect_to', route('dashboard'));
        
        // If it's trying to redirect back to the project page itself, force dashboard
        if (str_contains($redirectTo, route('projects.show', $project->id))) {
            $redirectTo = route('dashboard');
        }
        
        return redirect($redirectTo)->with('success', 'Proyek berhasil dihapus.');
    }
}
