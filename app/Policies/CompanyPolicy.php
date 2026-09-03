<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can invite the company to a project.
     */
    public function invite(User $user, Company $targetCompany): bool
    {
        // Only normal users can invite
        if ($user->role !== 'user') {
            return false;
        }

        // Must have a company profile
        if (!$user->company) {
            return false;
        }

        // Only Usaha Besar can invite
        if (strtolower($user->company->skala_usaha ?? '') !== 'besar') {
            return false;
        }

        // Cannot invite oneself
        if ($user->company->id === $targetCompany->id) {
            return false;
        }

        return true;
    }
}
