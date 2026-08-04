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
            'skala_usaha' => [
                'required',
                'in:mikro,kecil,menengah,besar',
                function ($attribute, $value, $fail) {
                    $pelaku = $this->input('pelaku_usaha');
                    if ($pelaku === 'orang-perseorangan' && !in_array($value, ['mikro', 'kecil'])) {
                        $fail('Skala usaha untuk perseorangan harus Mikro atau Kecil.');
                    }
                    if (in_array($pelaku, ['kantor-perwakilan', 'badan-usaha-luar-negeri']) && $value !== 'besar') {
                        $fail('Skala usaha untuk entitas luar negeri / perwakilan harus Besar.');
                    }
                }
            ],
            
            'nik_perseorangan' => ['required_if:pelaku_usaha,orang-perseorangan', 'nullable', 'digits:16'],
            'jenis_badan_usaha' => ['required_if:pelaku_usaha,badan-usaha', 'nullable', 'string'],
            'jenis_kantor_perwakilan' => ['required_if:pelaku_usaha,kantor-perwakilan', 'nullable', 'string'],
            'jenis_badan_usaha_luar_negeri' => ['required_if:pelaku_usaha,badan-usaha-luar-negeri', 'nullable', 'string'],
            
            'kblis' => ['required', 'array', 'min:1'],
            'kblis.*' => ['exists:kblis,code'],
            
            'kewarganegaraan' => ['required', 'in:WNI,WNA'],
            'nama_pimpinan' => ['required', 'string', 'max:255'],
            'jabatan_pimpinan' => ['required_unless:pelaku_usaha,orang-perseorangan', 'nullable', 'string', 'max:255'],
            
            'nik_pimpinan' => [
                'required_unless:pelaku_usaha,orang-perseorangan',
                'nullable',
                function ($attribute, $value, $fail) {
                    if ($this->input('pelaku_usaha') === 'orang-perseorangan' || is_null($value)) {
                        return;
                    }
                    if ($this->input('kewarganegaraan') === 'WNI') {
                        if (!preg_match('/^\d{16}$/', (string)$value)) {
                            $fail('The '.$attribute.' must be exactly 16 digits for WNI.');
                        }
                    } else {
                        if (strlen((string)$value) < 5) {
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
            
            'is_pkp' => [
                'required', 
                'boolean', 
                function ($attribute, $value, $fail) {
                    $skala = $this->input('skala_usaha');
                    // Boolean value from request might be "1" or "0" or boolean true/false
                    $isPkp = filter_var($value, FILTER_VALIDATE_BOOLEAN);
                    if (in_array($skala, ['menengah', 'besar']) && !$isPkp) {
                        $fail('Status PKP wajib Ya (True) untuk skala usaha Menengah dan Besar.');
                    }
                }
            ],
            'pkp_link' => ['required_if:is_pkp,1,true', 'nullable', 'url'],
            
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
