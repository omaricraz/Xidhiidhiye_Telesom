<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'full_name',
        'email',
        'password',
        'role',
        'team_id',
        'tech_stack',
        'status_emoji',
        'profile_image',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the team the user belongs to.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    /**
     * Get all tasks created by this user.
     */
    public function createdTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'creator_id');
    }

    /**
     * Get all tasks assigned to this user.
     */
    public function assignedTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'assignee_id');
    }

    /**
     * Get all learning progress records for this user.
     */
    public function learningProgress(): HasMany
    {
        return $this->hasMany(UserLearningProgress::class, 'user_id');
    }

    /**
     * Get all questions created by this user.
     */
    public function createdQuestions(): HasMany
    {
        return $this->hasMany(Question::class, 'created_by');
    }

    /**
     * Get all notices created by this user.
     */
    public function createdNotices(): HasMany
    {
        return $this->hasMany(Notice::class, 'created_by');
    }

    /**
     * Check if user is a Manager.
     */
    public function isManager(): bool
    {
        return $this->role === 'Manager';
    }

    /**
     * Check if user is a Team Lead.
     */
    public function isTeamLead(): bool
    {
        return $this->role === 'Team_Lead';
    }

    /**
     * Check if user is an Intern.
     */
    public function isIntern(): bool
    {
        return $this->role === 'Intern';
    }

    /**
     * Check if user is an Employee.
     */
    public function isEmployee(): bool
    {
        return $this->role === 'Employee';
    }

    /**
     * Get status icon class based on user status.
     */
    public function getStatusIcon(): string
    {
        return match($this->status ?? 'active') {
            'active' => 'ti-circle-check',
            'holiday' => 'ti-plane',
            'sick_leave' => 'ti-heart',
            'remote' => 'ti-home',
            'offline' => 'ti-circle-off',
            default => 'ti-circle-check',
        };
    }

    /**
     * Get status badge color based on user status.
     */
    public function getStatusBadgeColor(): string
    {
        return match($this->status ?? 'active') {
            'active' => 'success',
            'holiday' => 'info',
            'sick_leave' => 'warning',
            'remote' => 'primary',
            'offline' => 'secondary',
            default => 'success',
        };
    }

    /**
     * Get status label for display.
     */
    public function getStatusLabel(): string
    {
        return match($this->status ?? 'active') {
            'active' => 'Active',
            'holiday' => 'On Holiday',
            'sick_leave' => 'Sick Leave',
            'remote' => 'Remote',
            'offline' => 'Offline',
            default => 'Active',
        };
    }

    /**
     * Get profile image URL or fallback to default avatar.
     */
    public function getProfileImageUrl(): string
    {
        if ($this->profile_image) {
            return $this->profile_image;
        }
        
        // Fallback to default avatar based on user ID
        $avatarNumber = (($this->id - 1) % 10) + 1;
        return "/build/images/user/avatar-{$avatarNumber}.jpg";
    }
}
