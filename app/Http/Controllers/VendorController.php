<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Company;

class VendorController extends Controller
{
    public function show(Company $company)
    {
        // Must be verified to be shown publicly
        if ($company->status !== 'verified') {
            abort(404);
        }

        $company->load(['portfolios', 'projects', 'kblis']);

        $myProjects = collect();
        if (auth()->check() && auth()->user()->company) {
            $myProjects = auth()->user()->company->projects()->where('status', 'published')->get();
        }

        return view('vendor-profile', compact('company', 'myProjects'));
    }
}
