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

        $company->load(['portfolios', 'kblis']);

        // Only load published projects unless the viewer is the owner
        $company->load(['projects' => function ($query) use ($company) {
            if (!auth()->check() || !auth()->user()->company || auth()->user()->company->id !== $company->id) {
                $query->where('status', 'published');
            }
        }]);

        $myProjects = collect();
        if (auth()->check() && auth()->user()->company) {
            $myProjects = auth()->user()->company->projects()->where('status', 'published')->get();
        }

        return view('company.show', compact('company', 'myProjects'));
    }
}
