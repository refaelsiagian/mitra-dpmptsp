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
    public function edit()
    {
        $user = auth()->user();
        $company = $user->company()->with(['portfolios', 'offerings'])->first();

        if (!$company) {
            return redirect()->route('verify');
        }

        return view('company.profile.edit', compact('company'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $company = $user->company;

        if (!$company) {
            return redirect()->route('verify');
        }

        $validated = $request->validate([
            'established_year' => 'nullable|integer|min:1900|max:'.date('Y'),
            'tagline' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'certifications' => 'nullable|array',
            'certifications.*' => 'string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:4096',
        ]);

        // If no certifications were submitted (e.g. all tags deleted), clear them
        if (!$request->has('certifications')) {
            $validated['certifications'] = [];
        }

        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            $file = $request->file('logo');
            try {
                $validated['logo'] = $file->store('company_logos', 'public');
            } catch (\Throwable $e) {
                \Log::error('Logo upload failed (trying fallback): ' . $e->getMessage());
                try {
                    $filename = $file->hashName();
                    $contents = file_get_contents($file->getPathname());
                    \Illuminate\Support\Facades\Storage::disk('public')->put('company_logos/' . $filename, $contents);
                    $validated['logo'] = 'company_logos/' . $filename;
                } catch (\Throwable $e2) {
                    \Log::error('Logo upload fallback also failed: ' . $e2->getMessage());
                    unset($validated['logo']);
                }
            }
        } else {
            unset($validated['logo']);
        }

        if ($request->hasFile('banner') && $request->file('banner')->isValid()) {
            $file = $request->file('banner');
            try {
                $validated['banner'] = $file->store('company_banners', 'public');
            } catch (\Throwable $e) {
                \Log::error('Banner upload failed (trying fallback): ' . $e->getMessage());
                try {
                    $filename = $file->hashName();
                    $contents = file_get_contents($file->getPathname());
                    \Illuminate\Support\Facades\Storage::disk('public')->put('company_banners/' . $filename, $contents);
                    $validated['banner'] = 'company_banners/' . $filename;
                } catch (\Throwable $e2) {
                    \Log::error('Banner upload fallback also failed: ' . $e2->getMessage());
                    unset($validated['banner']);
                }
            }
        } else {
            unset($validated['banner']);
        }

        $company->update($validated);



        return redirect()->route('company.profile')->with('success', 'Profil berhasil diperbarui!');
    }
}
