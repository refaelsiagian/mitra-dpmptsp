<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyStoreRequest;
use App\Models\Company;
use App\Models\CompanyLocation;
use App\Models\CompanyRepresentative;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VerificationController extends Controller
{
    public function index()
    {
        $company = auth()->user()->company;
        
        if ($company) {
            if ($company->status === 'pending') {
                return redirect('/review');
            } elseif ($company->status === 'verified') {
                return redirect('/rfp-saya');
            }
        }
        
        $provinces = \App\Models\Province::orderBy('name')->get();
        $kblis = \App\Models\Kbli::orderBy('code')->get();
        
        // Pass company and feedbacks to view if they are in revision mode
        if ($company && $company->status === 'rejected') {
            $company->load(['locations', 'representatives', 'kblis', 'feedbacks']);
            $feedbacks = $company->feedbacks->keyBy('field_name');
            return view('verify.index', compact('provinces', 'kblis', 'company', 'feedbacks'));
        }
        
        return view('verify.index', compact('provinces', 'kblis', 'company'));
    }

    public function review()
    {
        $company = auth()->user()->company;
        if (!$company) {
            return redirect('/verify');
        }
        if ($company->status === 'rejected') {
            return redirect('/verify');
        }
        if ($company->status === 'verified') {
            return redirect('/rfp-saya');
        }
        return view('review');
    }

    public function store(VerifyStoreRequest $request)

    {
        try {
            $user = Auth::user();
            $existingCompany = $user->company;

            if ($existingCompany && $existingCompany->status !== 'rejected') {
                return redirect('/review')->with('error', 'Anda sudah mengirimkan data verifikasi.');
            }

            DB::beginTransaction();

            // Determine pelaku_usaha_detail
            $pelakuUsaha = $request->input('pelaku_usaha');
            $detail = null;
            if ($pelakuUsaha === 'badan-usaha') {
                $detail = $request->input('jenis_badan_usaha');
            } elseif ($pelakuUsaha === 'kantor-perwakilan') {
                $detail = $request->input('jenis_kantor_perwakilan');
            } elseif ($pelakuUsaha === 'badan-usaha-luar-negeri') {
                $detail = $request->input('jenis_badan_usaha_luar_negeri');
            }
            
            $companyData = [
                'user_id' => $user->id,
                'name' => $request->input('company_name'),
                'pelaku_usaha_type' => $pelakuUsaha,
                'pelaku_usaha_detail' => $detail,
                'perseorangan_nik' => $request->input('nik_perseorangan'),
                'nib_number' => $request->input('nib_number'),
                'nib_link' => $request->input('nib_link'),
                'npwp_number' => $request->input('npwp_number'),
                'npwp_link' => $request->input('npwp_link'),
                'is_pkp' => filter_var($request->input('is_pkp'), FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false',
                'pkp_link' => filter_var($request->input('is_pkp'), FILTER_VALIDATE_BOOLEAN) ? $request->input('pkp_link') : null,
                'is_npwp_same_as_nik' => $request->has('sama_dengan_nik') ? 'true' : 'false',
                'is_usaha_same_as_office' => $request->boolean('same_as_office') ? 'true' : 'false',
                'skala_usaha' => $request->input('skala_usaha'),
                'status' => 'pending'
            ];

            if ($existingCompany && $existingCompany->status === 'rejected') {
                // Update existing
                $existingCompany->update($companyData);
                $company = $existingCompany;
                
                // Clear old relations and feedbacks
                $company->representatives()->delete();
                $company->locations()->delete();
                \App\Models\VerificationFeedback::where('company_id', $company->id)->delete();
            } else {
                // Create new
                $company = Company::create($companyData);
            }

            // Sync KBLIs
            $kblis = $request->input('kblis');
            $company->kblis()->sync($kblis);

            // Create Representative
            CompanyRepresentative::create([
                'company_id' => $company->id,
                'name' => $request->input('nama_pimpinan'),
                'position' => $request->input('pelaku_usaha') === 'orang-perseorangan' ? 'Pemilik' : $request->input('jabatan_pimpinan'),
                'citizenship_type' => $request->input('kewarganegaraan'),
                'identity_type' => $request->input('kewarganegaraan') === 'WNI' ? 'NIK' : 'PASPOR',
                'identity_number' => $request->input('pelaku_usaha') === 'orang-perseorangan' ? $request->input('nik_perseorangan') : $request->input('nik_pimpinan'),
                'nationality' => $request->input('kewarganegaraan') === 'WNI' ? null : $request->input('nationality_pimpinan'),
            ]);

            // Coordinates
            $coords = explode(',', $request->input('coordinate_input'));
            $lat = trim($coords[0]);
            $lng = trim($coords[1]);

            // Main Office Location
            CompanyLocation::create([
                'company_id' => $company->id,
                'type' => 'KANTOR_UTAMA',
                'province_id' => $request->input('provinsi_kantor'),
                'regency_id' => $request->input('kabupaten_kantor'),
                'district_id' => $request->input('kecamatan_kantor'),
                'village_id' => $request->input('desa_kantor'),
                'address' => $request->input('alamat_kantor'),
                'latitude' => $lat,
                'longitude' => $lng,
            ]);

            // Business Location
            $isSame = $request->boolean('same_as_office');
            CompanyLocation::create([
                'company_id' => $company->id,
                'type' => 'LOKASI_USAHA',
                'province_id' => $isSame ? $request->input('provinsi_kantor') : $request->input('provinsi_usaha'),
                'regency_id' => $isSame ? $request->input('kabupaten_kantor') : $request->input('kabupaten_usaha'),
                'district_id' => $isSame ? $request->input('kecamatan_kantor') : $request->input('kecamatan_usaha'),
                'village_id' => $isSame ? $request->input('desa_kantor') : $request->input('desa_usaha'),
                'address' => $isSame ? $request->input('alamat_kantor') : $request->input('alamat_usaha'),
                'latitude' => $lat,
                'longitude' => $lng,
            ]);

            DB::commit();

            return redirect('/review')->with('success', 'Data registrasi berhasil dikirim dan sedang ditinjau.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
