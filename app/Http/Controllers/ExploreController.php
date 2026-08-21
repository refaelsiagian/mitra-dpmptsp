<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Project;

class ExploreController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $kbli = $request->query('kbli');
        $location = $request->query('location');
        $scheme = $request->query('scheme');

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
                $q->where('name', 'like', "%{$kbli}%");
            });
        }

        if ($location) {
            $vendorsQuery->whereHas('locations.regency', function($q) use ($location) {
                $q->where('name', 'like', "%{$location}%");
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

        if ($location) {
            $projectsQuery->where(function($q) use ($location) {
                $q->where('location', 'like', "%{$location}%")
                  ->orWhereHas('company.locations.regency', function($cQ) use ($location) {
                      $cQ->where('name', 'like', "%{$location}%");
                  });
            });
        }

        $projects = $projectsQuery->paginate(10, ['*'], 'project_page');

        return view('company.explore', compact('vendors', 'projects', 'search', 'kbli', 'location', 'scheme'));
    }
}