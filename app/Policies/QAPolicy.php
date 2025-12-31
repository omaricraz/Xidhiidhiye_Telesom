<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\User;

class QAPolicy
{
    /**
     * Determine if the user can view any questions.
     */
    public function viewAny(User $user): bool
    {
        return true; // All authenticated users can view questions (scoped in controller)
    }

    /**
     * Determine if the user can view the question.
     */
    public function view(User $user, Question $question): bool
    {
        return true; // All authenticated users can view questions
    }

    /**
     * Determine if the user can create questions.
     */
    public function create(User $user): bool
    {
        // Manager and Team Lead can create questions
        return $user->isManager() || $user->isTeamLead();
    }

    /**
     * Determine if the user can update the question.
     */
    public function update(User $user, Question $question): bool
    {
        // Manager can update all
        if ($user->isManager()) {
            return true;
        }

        // Team Lead can update questions from their team or questions they created
        if ($user->isTeamLead()) {
            // If question has a team_id, check if it matches the user's team
            if ($question->team_id) {
                return $question->team_id === $user->team_id;
            }
            // If no team_id, check if the user created it
            return $question->created_by === $user->id;
        }

        return false;
    }

    /**
     * Determine if the user can delete the question.
     */
    public function delete(User $user, Question $question): bool
    {
        // Manager can delete all
        if ($user->isManager()) {
            return true;
        }

        // Team Lead can delete questions from their team or questions they created
        if ($user->isTeamLead()) {
            // If question has a team_id, check if it matches the user's team
            if ($question->team_id) {
                return $question->team_id === $user->team_id;
            }
            // If no team_id, check if the user created it
            return $question->created_by === $user->id;
        }

        return false;
    }
}


