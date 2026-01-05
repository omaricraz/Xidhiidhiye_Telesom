<?php

namespace App\Policies;

use App\Models\Notice;
use App\Models\User;

class NoticePolicy
{
    /**
     * Determine if the user can view any notices.
     */
    public function viewAny(User $user): bool
    {
        return true; // All authenticated users can view notices
    }

    /**
     * Determine if the user can view the notice.
     */
    public function view(User $user, Notice $notice): bool
    {
        return true; // All authenticated users can view notices
    }

    /**
     * Determine if the user can create notices.
     */
    public function create(User $user): bool
    {
        // Only Manager and Team Lead can create notices
        return $user->isManager() || $user->isTeamLead();
    }

    /**
     * Determine if the user can update the notice.
     */
    public function update(User $user, Notice $notice): bool
    {
        // Only Manager and Team Lead can update notices
        return $user->isManager() || $user->isTeamLead();
    }

    /**
     * Determine if the user can delete the notice.
     */
    public function delete(User $user, Notice $notice): bool
    {
        // Only Manager and Team Lead can delete notices
        return $user->isManager() || $user->isTeamLead();
    }
}









