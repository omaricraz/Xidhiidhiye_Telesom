<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine if the user can view any users.
     */
    public function viewAny(User $user): bool
    {
        // Only Manager can view user list
        return $user->isManager();
    }

    /**
     * Determine if the user can view the user.
     */
    public function view(User $user, User $model): bool
    {
        // Only Manager can view users
        return $user->isManager();
    }

    /**
     * Determine if the user can create users.
     */
    public function create(User $user): bool
    {
        // Only Manager can create users
        return $user->isManager();
    }

    /**
     * Determine if the user can update the user.
     */
    public function update(User $user, User $model): bool
    {
        // Only Manager can update users
        return $user->isManager();
    }

    /**
     * Determine if the user can delete the user.
     */
    public function delete(User $user, User $model): bool
    {
        // Only Manager can delete users
        return $user->isManager();
    }
}








