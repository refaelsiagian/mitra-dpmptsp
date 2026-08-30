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

        // Load published and closed projects, along with accepted proposals for closed projects
        $company->load(['projects' => function ($query) use ($company) {
            // Everyone (including owner) only sees published projects, and closed projects that are public
            $query->where('status', 'published')
                  ->orWhere(function ($q) {
                      $q->where('status', 'closed')->where('is_public', 'true');
                  });
        }, 'projects.proposals' => function ($query) {
            $query->where('status', 'accepted')->with('company');
        }]);

        $myProjects = auth()->check() && auth()->user()->company ? 
                      auth()->user()->company->projects()->where('status', 'published')->get() : 
                      collect();
                      
        return view('company.show', compact('company', 'myProjects'));
    }
}
