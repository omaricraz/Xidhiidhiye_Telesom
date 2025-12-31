<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'lead_id',
    ];

    /**
     * Get the team lead (user).
     */
    public function lead(): BelongsTo
    {
        return $this->belongsTo(User::class, 'lead_id');
    }

    /**
     * Get all members of the team.
     */
    public function members(): HasMany
    {
        return $this->hasMany(User::class, 'team_id');
    }

    /**
     * Get all learning goals for the team.
     */
    public function learningGoals(): HasMany
    {
        return $this->hasMany(LearningGoal::class, 'team_id');
    }
}


