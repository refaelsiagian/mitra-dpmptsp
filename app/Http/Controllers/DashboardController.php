<?php

namespace App\Http\Controllers;

use App\Models\Proposal;

class DashboardController extends Controller
{
    public function index()
    {
        $company = auth()->user()->company;
        $pendingReceivedCount = 0;
        $pendingInvitesCount = 0;
        $quickStats = ['activeCount' => 0, 'incomingCount' => 0, 'sentCount' => 0];

        if ($company) {
            $isUMKM = $company->isUMKM();
            
            // For the badge counts on the tabs, we only query the counts, not the heavy relationships!
            $pendingReceivedCount = \App\Models\Proposal::whereHas('project', function($q) use ($company) {
                $q->where('company_id', $company->id);
            })->where('status', 'pending')->count();
            
            $pendingInvitesCount = $isUMKM ? $company->receivedInvitations()->where('status', 'pending')->count() : 0;
            
            // Quick Stats counts
            if ($isUMKM) {
                $activeOffersCount = $company->projects()->where('status', 'published')->count();
                $totalIncomingInterests = \App\Models\Proposal::whereHas('project', function($q) use ($company) {
                    $q->where('company_id', $company->id);
                })->count();
                $totalSentProposals = $company->proposals()->count();
                
                $quickStats = [
                    'activeCount' => $activeOffersCount,
                    'incomingCount' => $totalIncomingInterests,
                    'sentCount' => $totalSentProposals,
                ];
            } else {
                $activeProcurementsCount = $company->projects()->where('status', 'published')->count();
                $totalIncomingProposals = \App\Models\Proposal::whereHas('project', function($q) use ($company) {
                    $q->where('company_id', $company->id);
                })->count();
                $totalSentInterests = $company->proposals()->count();
                
                $quickStats = [
                    'activeCount' => $activeProcurementsCount,
                    'incomingCount' => $totalIncomingProposals,
                    'sentCount' => $totalSentInterests,
                ];
            }
        }

        return view('company.dashboard', compact(
            'pendingReceivedCount',
            'pendingInvitesCount',
            'quickStats'
        ));
    }
}
