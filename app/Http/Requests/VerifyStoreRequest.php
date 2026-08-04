<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    protected function prepareForValidation()
    {
        if ($this->has('kblis')) {
            $kblisStr = $this->input('kblis');
            $decoded = json_decode($kblisStr, true);
            if (is_array($decoded)) {
                $this->merge([
                    'kblis' => $decoded
                ]);
            }
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'company_name' => ['required', 'string', 'max:255'],
            'pelaku_usaha' => ['required', 'in:orang-perseorangan,badan-usaha,kantor-perwakilan,badan-usaha-luar-negeri'],
            
            'nik_perseorangan' => ['required_if:pelaku_usaha,orang-perseorangan', 'nullable', 'digits:16'],
            'jenis_badan_usaha' => ['required_if:pelaku_usaha,badan-usaha', 'nullable', 'string'],
            'jenis_kantor_perwakilan' => ['required_if:pelaku_usaha,kantor-perwakilan', 'nullable', 'string'],
            'jenis_badan_usaha_luar_negeri' => ['required_if:pelaku_usaha,badan-usaha-luar-negeri', 'nullable', 'string'],
            
            'kblis' => ['required', 'array', 'min:1'],
            'kblis.*' => ['exists:kblis,code'],
            
            'kewarganegaraan' => ['required', 'in:WNI,WNA'],
            'nama_pimpinan' => ['required', 'string', 'max:255'],
            'jabatan_pimpinan' => ['required', 'string', 'max:255'],
            
            'nik_pimpinan' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($this->input('kewarganegaraan') === 'WNI') {
                        if (!preg_match('/^\d{16}$/', $value)) {
                            $fail('The '.$attribute.' must be exactly 16 digits for WNI.');
                        }
                    } else {
                        if (strlen($value) < 5) {
                            $fail('The '.$attribute.' must be at least 5 characters for WNA Passport.');
                        }
                    }
                },
            ],
            'nationality_pimpinan' => ['required_if:kewarganegaraan,WNA', 'nullable', 'string'],
            
            'nib_number' => ['required', 'digits:13'],
            'nib_link' => ['required', 'url'],
            'npwp_number' => ['required', 'numeric'], 
            
            'npwp_link' => ['required', 'url'],
            
            'provinsi_kantor' => ['required', 'exists:provinces,id'],
            'kabupaten_kantor' => ['required', 'exists:regencies,id'],
            'kecamatan_kantor' => ['required', 'exists:districts,id'],
            'desa_kantor' => ['required', 'exists:villages,id'],
            'alamat_kantor' => ['required', 'string'],
            
            'same_as_office' => ['boolean'],
            
            'provinsi_usaha' => ['required_if:same_as_office,0', 'nullable', 'exists:provinces,id'],
            'kabupaten_usaha' => ['required_if:same_as_office,0', 'nullable', 'exists:regencies,id'],
            'kecamatan_usaha' => ['required_if:same_as_office,0', 'nullable', 'exists:districts,id'],
            'desa_usaha' => ['required_if:same_as_office,0', 'nullable', 'exists:villages,id'],
            'alamat_usaha' => ['required_if:same_as_office,0', 'nullable', 'string'],
            
            'coordinate_input' => ['required', 'regex:/^-?\d+(\.\d+)?\s*,\s*-?\d+(\.\d+)?$/'],
        ];
    }
}
