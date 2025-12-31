<?php

namespace App\Policies;

use App\Models\LearningGoal;
use App\Models\User;

class LearningGoalPolicy
{
    /**
     * Determine if the user can view any learning goals.
     */
    public function viewAny(User $user): bool
    {
        return true; // All authenticated users can view learning goals (scoped in controller)
    }

    /**
     * Determine if the user can view the learning goal.
     */
    public function view(User $user, LearningGoal $learningGoal): bool
    {
        // All users can view learning goals that apply to all teams (team_id is null)
        if ($learningGoal->team_id === null) {
            return true;
        }

        // Manager can view all
        if ($user->isManager()) {
            return true;
        }

        // Team Lead can view goals from their team
        if ($user->isTeamLead() && $user->team_id) {
            return $learningGoal->team_id === $user->team_id;
        }

        // Intern can view goals from their team
        if ($user->isIntern() && $user->team_id) {
            return $learningGoal->team_id === $user->team_id;
        }

        // Employee can view goals from their team
        if ($user->isEmployee() && $user->team_id) {
            return $learningGoal->team_id === $user->team_id;
        }

        return false;
    }

    /**
     * Determine if the user can create learning goals.
     */
    public function create(User $user): bool
    {
        // Manager and Team Lead can create learning goals
        return $user->isManager() || $user->isTeamLead();
    }

    /**
     * Determine if the user can update the learning goal.
     */
    public function update(User $user, LearningGoal $learningGoal): bool
    {
        // Manager and Team Lead can update learning goals for all teams
        if ($learningGoal->team_id === null) {
            return $user->isManager() || $user->isTeamLead();
        }

        // Manager can update all
        if ($user->isManager()) {
            return true;
        }

        // Team Lead can update goals from their team
        if ($user->isTeamLead() && $user->team_id) {
            return $learningGoal->team_id === $user->team_id;
        }

        return false;
    }

    /**
     * Determine if the user can delete the learning goal.
     */
    public function delete(User $user, LearningGoal $learningGoal): bool
    {
        // Manager and Team Lead can delete learning goals for all teams
        if ($learningGoal->team_id === null) {
            return $user->isManager() || $user->isTeamLead();
        }

        // Manager can delete all
        if ($user->isManager()) {
            return true;
        }

        // Team Lead can delete goals from their team
        if ($user->isTeamLead() && $user->team_id) {
            return $learningGoal->team_id === $user->team_id;
        }

        return false;
    }
}

