<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompanyProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $company = $user->company()->with([
            'locations.province',
            'locations.regency',
            'locations.district',
            'locations.village',
            'representatives',
            'kblis'
        ])->first();

        if (!$company) {
            return redirect()->route('verify');
        }

        return view('company.profile', compact('company'));
    }
}
