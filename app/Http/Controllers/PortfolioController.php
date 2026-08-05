<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function create()
    {
        return view('company.portfolio.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'image' => 'required|image|max:4096',
            'description' => 'nullable|string|max:2000', // roughly 200 words
        ]);

        $company = auth()->user()->company;
        $imagePath = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'portfolio_' . uniqid() . '.' . $extension;
            
            // Fallback for Windows/Laragon
            $content = file_get_contents($file->getPathname());
            $path = 'companies/' . $company->id . '/portfolios/' . $filename;
            \Illuminate\Support\Facades\Storage::disk('public')->put($path, $content);
            $imagePath = $path;
        }

        $company->portfolios()->create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('vendor.show', ['company' => $company->id, 'tab' => 'portfolios'])->with('success', 'Portofolio berhasil ditambahkan.');
    }

    public function edit(\App\Models\CompanyPortfolio $portfolio)
    {
        $company = auth()->user()->company;
        
        if ($portfolio->company_id !== $company->id) {
            abort(403);
        }

        return view('company.portfolio.edit', compact('portfolio'));
    }

    public function update(Request $request, \App\Models\CompanyPortfolio $portfolio)
    {
        $company = auth()->user()->company;
        
        if ($portfolio->company_id !== $company->id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:100',
            'image' => 'nullable|image|max:4096',
            'description' => 'nullable|string|max:2000',
        ]);

        $imagePath = $portfolio->image_path;

        if ($request->hasFile('image')) {
            // Delete old image
            if ($imagePath) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($imagePath);
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = 'portfolio_' . uniqid() . '.' . $extension;
            
            // Fallback for Windows/Laragon
            $content = file_get_contents($file->getPathname());
            $path = 'companies/' . $company->id . '/portfolios/' . $filename;
            \Illuminate\Support\Facades\Storage::disk('public')->put($path, $content);
            $imagePath = $path;
        }

        $portfolio->update([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('vendor.show', ['company' => $company->id, 'tab' => 'portfolios'])->with('success', 'Portofolio berhasil diperbarui.');
    }

    public function destroy(\App\Models\CompanyPortfolio $portfolio)
    {
        $company = auth()->user()->company;
        
        if ($portfolio->company_id !== $company->id) {
            abort(403);
        }

        if ($portfolio->image_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($portfolio->image_path);
        }

        $portfolio->delete();

        return redirect()->route('vendor.show', ['company' => $company->id, 'tab' => 'portfolios'])->with('success', 'Portofolio berhasil dihapus.');
    }
}
