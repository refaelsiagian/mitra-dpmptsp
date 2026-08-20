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
            if (!auth()->check() || !auth()->user()->company || auth()->user()->company->id !== $company->id) {
                // Public viewers only see published projects, and closed projects that are public
                $query->where('status', 'published')
                      ->orWhere(function ($q) {
                          $q->where('status', 'closed')->where('is_public', 'true');
                      });
            } else {
                // Owner sees everything, but for the profile view we only care about published and closed
                $query->whereIn('status', ['published', 'closed']);
            }
        }, 'projects.proposals' => function ($query) {
            $query->where('status', 'accepted')->with('company');
        }]);

        $myProjects = collect();
        if (auth()->check() && auth()->user()->company) {
            $myProjects = auth()->user()->company->projects()->where('status', 'published')->get();
        }

        return view('company.show', compact('company', 'myProjects'));
    }
}
