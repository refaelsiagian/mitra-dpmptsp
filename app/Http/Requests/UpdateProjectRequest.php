<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    public function authorize()
    {
        $project = $this->route('project');
        return auth()->check() && auth()->user()->company && $project->company_id === auth()->user()->company->id;
    }

    public function rules()
    {
        return [
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
                function ($attribute, $value, $fail) {
                    $project = $this->route('project');
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
        ];
    }

    public function messages()
    {
        return [
            'province_id.required_with' => 'Provinsi wajib diisi jika lokasi proyek lainnya diisi.',
            'regency_id.required_with' => 'Kabupaten/Kota wajib diisi jika lokasi proyek lainnya diisi.',
            'district_id.required_with' => 'Kecamatan wajib diisi jika lokasi proyek lainnya diisi.',
            'village_id.required_with' => 'Desa/Kelurahan wajib diisi jika lokasi proyek lainnya diisi.',
            'address.required_with' => 'Alamat lengkap wajib diisi jika lokasi proyek lainnya diisi.',
            'project_start_date.after' => 'Mulai pelaksanaan tidak boleh lebih awal dari batas penawaran.',
            'project_end_date.after' => 'Selesai pelaksanaan tidak boleh lebih awal dari mulai pelaksanaan.',
        ];
    }
}
