<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Project;
use App\Models\Province;
use App\Models\Kbli;

class ExploreController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $kbli = $request->query('kbli');
        $scheme = $request->query('scheme');
        
        $provinceId = $request->query('province_id');
        $regencyId = $request->query('regency_id');
        $districtId = $request->query('district_id');
        $villageId = $request->query('village_id');

        $userScale = auth()->check() && auth()->user()->company ? auth()->user()->company->skala_usaha : null;

        // Fetch Vendors
        $vendorsQuery = Company::with(['kblis', 'locations.regency'])->where('status', 'verified');

        if ($userScale === 'besar') {
            $vendorsQuery->whereIn('skala_usaha', ['mikro', 'kecil', 'menengah']);
        } elseif (in_array($userScale, ['mikro', 'kecil', 'menengah'])) {
            $vendorsQuery->where('skala_usaha', 'besar');
        }

        if ($search) {
            $vendorsQuery->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('badan_usaha', 'like', "%{$search}%")
                  ->orWhereHas('kblis', function($kbliQ) use ($search) {
                      $kbliQ->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($kbli) {
            $vendorsQuery->whereHas('kblis', function($q) use ($kbli) {
                $q->where('code', $kbli);
            });
        }

        if ($provinceId) {
            $vendorsQuery->whereHas('locations', function($q) use ($provinceId, $regencyId, $districtId, $villageId) {
                $q->where('province_id', $provinceId);
                if ($regencyId) $q->where('regency_id', $regencyId);
                if ($districtId) $q->where('district_id', $districtId);
                if ($villageId) $q->where('village_id', $villageId);
            });
        }

        $vendors = $vendorsQuery->paginate(10, ['*'], 'vendor_page');

        // Fetch Projects
        $projectsQuery = Project::with(['company.locations.regency'])
            ->where('status', 'published')
            ->where(function($q) {
                $q->whereNull('offer_end_date')
                  ->orWhere('offer_end_date', '>=', now()->startOfDay());
            });

        if ($userScale === 'besar') {
            $projectsQuery->whereHas('company', function($q) {
                $q->whereIn('skala_usaha', ['mikro', 'kecil', 'menengah']);
            });
        } elseif (in_array($userScale, ['mikro', 'kecil', 'menengah'])) {
            $projectsQuery->whereHas('company', function($q) {
                $q->where('skala_usaha', 'besar');
            });
        }

        if ($search) {
            $projectsQuery->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('company', function($cQ) use ($search) {
                      $cQ->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($scheme) {
            $projectsQuery->where('type', $scheme);
        }

        if ($provinceId) {
            $projectsQuery->where(function($q) use ($provinceId, $regencyId, $districtId, $villageId) {
                // Check project's direct location fields
                $q->where(function($pQ) use ($provinceId, $regencyId, $districtId, $villageId) {
                    $pQ->where('province_id', $provinceId);
                    if ($regencyId) $pQ->where('regency_id', $regencyId);
                    if ($districtId) $pQ->where('district_id', $districtId);
                    if ($villageId) $pQ->where('village_id', $villageId);
                })
                // Fallback to company location if project doesn't have one set (or in general as an OR)
                ->orWhereHas('company.locations', function($cQ) use ($provinceId, $regencyId, $districtId, $villageId) {
                    $cQ->where('province_id', $provinceId);
                    if ($regencyId) $cQ->where('regency_id', $regencyId);
                    if ($districtId) $cQ->where('district_id', $districtId);
                    if ($villageId) $cQ->where('village_id', $villageId);
                });
            });
        }

        $projects = $projectsQuery->paginate(10, ['*'], 'project_page');
        
        $provinces = Province::orderBy('name')->get();
        $kblis = Kbli::orderBy('code')->get();

        return view('company.explore', compact('vendors', 'projects', 'search', 'kbli', 'scheme', 'provinceId', 'regencyId', 'districtId', 'villageId', 'provinces', 'kblis'));
    }
}