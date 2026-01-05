<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LearningGoal extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'title',
        'description',
        'resource_url',
    ];

    /**
     * Get the team that owns this learning goal.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    /**
     * Get all user progress records for this goal.
     */
    public function userProgress(): HasMany
    {
        return $this->hasMany(UserLearningProgress::class, 'goal_id');
    }
}









