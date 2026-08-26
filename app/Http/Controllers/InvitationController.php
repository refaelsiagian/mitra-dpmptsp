<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ProjectInvitation;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class InvitationController extends Controller
{
    public function index()
    {
        $company = Auth::user()->company;
        if (!$company) {
            return redirect()->route('verify');
        }

        // Mark all received as read
        $company->receivedInvitations()->whereNull('read_at')->update(['read_at' => now()]);

        // Mark all sent updates as read
        $company->sentInvitations()->whereIn('status', ['accepted', 'rejected'])->whereNull('sender_read_at')->update(['sender_read_at' => now()]);

        $invitations = ProjectInvitation::where(function($q) use ($company) {
                // Received invitations
                $q->where('invited_company_id', $company->id);
            })
            ->orWhere(function($q) use ($company) {
                // Sent invitations that have a response
                $q->where('inviting_company_id', $company->id)
                  ->whereIn('status', ['accepted', 'rejected']);
            })
            ->with(['project', 'invitingCompany', 'invitedCompany'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('company.notifications', compact('invitations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'invited_company_id' => 'required|exists:companies,id',
            'message' => 'nullable|string'
        ]);

        $invitingCompany = Auth::user()->company;
        if (!$invitingCompany) {
            return response()->json(['success' => false, 'message' => 'Anda harus memiliki perusahaan untuk mengundang.'], 403);
        }

        $project = Project::find($request->project_id);
        if ($project->company_id !== $invitingCompany->id) {
            return response()->json(['success' => false, 'message' => 'Anda bukan pemilik proyek ini.'], 403);
        }

        // Check if already sent a proposal
        $existingProposal = \App\Models\Proposal::where('project_id', $project->id)
            ->where('company_id', $request->invited_company_id)
            ->first();

        if ($existingProposal) {
            return response()->json(['success' => false, 'type' => 'info', 'message' => 'Usaha ini sudah mengirimkan proposal ke proyek Anda.'], 422);
        }

        // Check if already invited
        $existing = ProjectInvitation::where('project_id', $project->id)
            ->where('invited_company_id', $request->invited_company_id)
            ->first();

        if ($existing) {
            $msg = 'Vendor sudah diundang ke proyek ini.';
            if ($existing->status === 'accepted') {
                $msg = 'Usaha ini telah mengirimkan proposalnya atas undangan Anda di proyek ini.';
            } elseif ($existing->status === 'rejected') {
                $msg = 'Usaha ini sebelumnya telah menolak undangan untuk proyek ini.';
            } elseif ($existing->status === 'pending') {
                $msg = 'Menunggu respon dari usaha terkait undangan sebelumnya.';
            }
            return response()->json(['success' => false, 'type' => 'info', 'message' => $msg], 422);
        }

        ProjectInvitation::create([
            'project_id' => $project->id,
            'inviting_company_id' => $invitingCompany->id,
            'invited_company_id' => $request->invited_company_id,
            'message' => $request->message,
            'status' => 'pending'
        ]);

        return response()->json(['success' => true, 'message' => 'Undangan berhasil dikirim!']);
    }

    public function update(Request $request, ProjectInvitation $invitation)
    {
        $request->validate([
            'action' => 'required|in:accept,reject'
        ]);

        $company = Auth::user()->company;
        if (!$company || $invitation->invited_company_id !== $company->id) {
            return back()->with('error', 'Akses ditolak.');
        }

        $invitation->update([
            'status' => $request->action === 'accept' ? 'accepted' : 'rejected'
        ]);

        $statusText = $request->action === 'accept' ? 'diterima' : 'ditolak';
        return back()->with('success', "Undangan proyek berhasil $statusText.");
    }
}
