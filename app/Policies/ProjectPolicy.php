<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Project $project)
    {
        if ($project->status === 'draft') {
            return $user->company && $user->company->id === $project->company_id;
        }
        return true; // Published projects are public
    }

    public function submitProposal(User $user, Project $project)
    {
        // Only normal users can submit proposals
        if ($user->role !== 'user') {
            return false;
        }

        // Must have a company profile
        if (!$user->company) {
            return false;
        }

        // Cannot submit proposal to own project
        if ($user->company->id === $project->company_id) {
            return false;
        }

        return true;
    }

    public function update(User $user, Project $project)
    {
        return $user->company && $user->company->id === $project->company_id;
    }

    public function delete(User $user, Project $project)
    {
        return $user->company && $user->company->id === $project->company_id;
    }
}
