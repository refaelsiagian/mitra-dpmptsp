<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('proposal.{proposalId}', function ($user, $proposalId) {
    $proposal = \App\Models\Proposal::with('project')->find($proposalId);
    if (!$proposal) return false;

    // Only allow if the user is from the UMKM company or Usaha Besar company
    return $user->company->id === $proposal->company_id || $user->company->id === $proposal->project->company_id;
});
