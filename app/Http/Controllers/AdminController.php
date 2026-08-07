<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\VerificationFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $companies = Company::with('user')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin.dashboard', compact('companies'));
    }

    public function review(Company $company)
    {
        $company->load([
            'locations.province', 'locations.regency', 'locations.district', 'locations.village',
            'representatives', 'kblis', 'feedbacks' => function($q) {
                $q->where('is_resolved', 'false');
            }
        ]);

        return view('admin.review', compact('company'));
    }

    public function storeFeedback(Request $request, Company $company)
    {
        $request->validate([
            'field_name' => 'required|string',
            'message' => 'required|string'
        ]);

        $feedback = VerificationFeedback::updateOrCreate(
            [
                'company_id' => $company->id,
                'field_name' => $request->field_name,
                'is_resolved' => 'false'
            ],
            [
                'message' => $request->message
            ]
        );

        return response()->json([
            'success' => true,
            'feedback' => $feedback
        ]);
    }

    public function removeFeedback(Request $request, Company $company)
    {
        $request->validate([
            'field_name' => 'required|string'
        ]);

        VerificationFeedback::where('company_id', $company->id)
            ->where('field_name', $request->field_name)
            ->where('is_resolved', 'false')
            ->delete();

        return response()->json(['success' => true]);
    }

    public function approve(Company $company)
    {
        DB::transaction(function () use ($company) {
            $company->update(['status' => 'verified']);
            
            // Mark any pending feedbacks as resolved automatically
            $company->feedbacks()->update(['is_resolved' => 'true']);
        });

        return redirect()->route('admin.dashboard')->with('success', 'Perusahaan berhasil diverifikasi.');
    }

    public function reject(Company $company)
    {
        // Change status to rejected so user can revise
        $company->update(['status' => 'rejected']);

        return redirect()->route('admin.dashboard')->with('success', 'Perusahaan dikembalikan ke pengguna untuk revisi.');
    }
}
