<?php

namespace App\Http\Controllers;

use App\Models\Proposal;

class DashboardController extends Controller
{
    public function index()
    {
        $company = auth()->user()->company;
        $publishedProjects = collect();
        $draftProjects = collect();
        $closedProjects = collect();
        $sentProposals = collect();
        $receivedProposals = collect();
        $receivedInvitations = collect();
        $sentInvitations = collect();

        if ($company) {
            $publishedProjects = $company->projects()
                ->withCount('proposals')
                ->withCount(['proposals as accepted_proposals_count' => function($q) {
                    $q->where('status', 'accepted');
                }])
                ->where('status', 'published')->latest()->get();
                
            $draftProjects = $company->projects()->where('status', 'draft')->latest()->get();
            
            $closedProjects = $company->projects()
                ->withCount('proposals')
                ->withCount(['proposals as accepted_proposals_count' => function($q) {
                    $q->where('status', 'accepted');
                }])
                ->where('status', 'closed')->latest()->get();
                
            $sentProposals = $company->proposals()->with('project.company')->latest()->get();
            
            $receivedProposals = Proposal::whereHas('project', function($q) use ($company) {
                $q->where('company_id', $company->id);
            })->with(['project', 'company'])->latest()->get();
            
            $receivedInvitations = $company->receivedInvitations()->with(['project', 'invitingCompany'])->latest()->get();
            $sentInvitations = $company->sentInvitations()->with(['project', 'invitedCompany'])->latest()->get();
        }

        return view('company.dashboard', compact(
            'publishedProjects', 
            'draftProjects', 
            'closedProjects', 
            'sentProposals', 
            'receivedProposals', 
            'receivedInvitations', 
            'sentInvitations'
        ));
    }
}
