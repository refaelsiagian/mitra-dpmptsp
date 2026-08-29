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

        return view('company.legalitas', compact('company'));
    }
    public function edit()
    {
        $user = auth()->user();
        $company = $user->company()->with(['portfolios', 'offerings'])->first();

        if (!$company) {
            return redirect()->route('verify');
        }

        return view('company.profile.edit', compact('company'));
    }

    public function update(\App\Http\Requests\UpdateCompanyProfileRequest $request)
    {
        $user = auth()->user();
        $company = $user->company;

        if (!$company) {
            return redirect()->route('verify');
        }

        $validated = $request->validated();

        // If no certifications were submitted (e.g. all tags deleted), clear them
        if (!$request->has('certifications')) {
            $validated['certifications'] = [];
        }

        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            $validated['logo'] = $request->file('logo')->store('company_logos', 'public');
        } else {
            unset($validated['logo']);
        }

        if ($request->hasFile('banner') && $request->file('banner')->isValid()) {
            $validated['banner'] = $request->file('banner')->store('company_banners', 'public');
        } else {
            unset($validated['banner']);
        }

        $company->update($validated);


        return redirect()->route('vendor.show', ['company' => $company->id])->with('success', 'Profil berhasil diperbarui!');
    }
}
