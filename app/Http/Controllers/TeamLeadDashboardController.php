<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamLeadDashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the team lead dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $teamLead = Auth::user();
        
        // Ensure user is a team lead with a team
        if (!$teamLead->isTeamLead() || !$teamLead->team_id) {
            abort(403, 'Access denied. Team lead access required.');
        }
        
        // Get team
        $team = Team::find($teamLead->team_id);
        if (!$team) {
            abort(404, 'Team not found.');
        }
        
        // Get all team member IDs (including the team lead)
        $teamMemberIds = User::where('team_id', $teamLead->team_id)->pluck('id');
        
        // Get team members excluding the team lead
        $totalEmployees = User::where('team_id', $teamLead->team_id)
            ->where('id', '!=', $teamLead->id)
            ->count();
        
        // Get interns count in team (excluding team lead)
        $internsCount = User::where('team_id', $teamLead->team_id)
            ->where('role', 'Intern')
            ->where('id', '!=', $teamLead->id)
            ->count();
        
        // Get permanent employees count in team (Employee role, excluding team lead)
        $permanentCount = User::where('team_id', $teamLead->team_id)
            ->where('role', 'Employee')
            ->where('id', '!=', $teamLead->id)
            ->count();
        
        // Calculate percentages
        $totalForPercentage = $internsCount + $permanentCount;
        $internPercentage = $totalForPercentage > 0 ? round(($internsCount / $totalForPercentage) * 100) : 0;
        $permanentPercentage = $totalForPercentage > 0 ? round(($permanentCount / $totalForPercentage) * 100) : 0;
        
        // Tasks statistics - only tasks from team members
        $teamTasksQuery = Task::where(function($q) use ($teamMemberIds, $teamLead) {
            $q->whereIn('assignee_id', $teamMemberIds)
              ->orWhereIn('creator_id', $teamMemberIds)
              ->orWhere('creator_id', $teamLead->id);
        });
        
        $totalTasks = $teamTasksQuery->count();
        $completedTasks = (clone $teamTasksQuery)->where('status', 'Completed')->count();
        $inProgressTasks = (clone $teamTasksQuery)->where('status', 'In_Progress')->count();
        $pendingTasks = (clone $teamTasksQuery)->where('status', 'Pending')->count();
        $highPriorityTasks = (clone $teamTasksQuery)->where('priority', 'High')->where('status', '!=', 'Completed')->count();
        $taskCompletionPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
        
        // Calculate productivity level based on completion rate
        $productivityLevel = $this->calculateProductivityLevel($taskCompletionPercentage);
        
        // Active employees in team (excluding team lead)
        $activeEmployees = User::where('team_id', $teamLead->team_id)
            ->where('id', '!=', $teamLead->id)
            ->where(function($query) {
                $query->where('status', 'active')
                    ->orWhereNull('status');
            })
            ->count();
        
        // Questions statistics - team questions and global questions
        $totalQuestions = Question::where(function($q) use ($teamLead) {
            $q->where('team_id', $teamLead->team_id)
              ->orWhereNull('team_id'); // Global questions
        })->count();
        
        $recentQuestions = Question::with(['creator', 'team'])
            ->where(function($q) use ($teamLead) {
                $q->where('team_id', $teamLead->team_id)
                  ->orWhereNull('team_id'); // Global questions
            })
            ->latest()
            ->take(5)
            ->get();
        
        // Recent tasks from team
        $recentTasks = Task::with(['creator', 'assignee'])
            ->where(function($q) use ($teamMemberIds, $teamLead) {
                $q->whereIn('assignee_id', $teamMemberIds)
                  ->orWhereIn('creator_id', $teamMemberIds)
                  ->orWhere('creator_id', $teamLead->id);
            })
            ->latest()
            ->take(5)
            ->get();
        
        return view('teamlead.dashboard', [
            'team' => $team,
            'totalEmployees' => $totalEmployees,
            'internsCount' => $internsCount,
            'permanentCount' => $permanentCount,
            'internPercentage' => $internPercentage,
            'permanentPercentage' => $permanentPercentage,
            'totalTasks' => $totalTasks,
            'completedTasks' => $completedTasks,
            'inProgressTasks' => $inProgressTasks,
            'pendingTasks' => $pendingTasks,
            'highPriorityTasks' => $highPriorityTasks,
            'taskCompletionPercentage' => $taskCompletionPercentage,
            'productivityLevel' => $productivityLevel,
            'activeEmployees' => $activeEmployees,
            'totalQuestions' => $totalQuestions,
            'recentQuestions' => $recentQuestions,
            'recentTasks' => $recentTasks,
        ]);
    }
    
    /**
     * Calculate productivity level based on completion percentage.
     *
     * @param int $completionPercentage
     * @return array
     */
    private function calculateProductivityLevel($completionPercentage)
    {
        if ($completionPercentage >= 90) {
            return [
                'label' => 'Excellent',
                'color' => 'success',
                'icon' => 'ti-trophy',
                'percentage' => $completionPercentage
            ];
        } elseif ($completionPercentage >= 75) {
            return [
                'label' => 'Very Good',
                'color' => 'info',
                'icon' => 'ti-star',
                'percentage' => $completionPercentage
            ];
        } elseif ($completionPercentage >= 60) {
            return [
                'label' => 'Good',
                'color' => 'primary',
                'icon' => 'ti-thumb-up',
                'percentage' => $completionPercentage
            ];
        } elseif ($completionPercentage >= 40) {
            return [
                'label' => 'Average',
                'color' => 'warning',
                'icon' => 'ti-alert-circle',
                'percentage' => $completionPercentage
            ];
        } else {
            return [
                'label' => 'Needs Improvement',
                'color' => 'danger',
                'icon' => 'ti-alert-triangle',
                'percentage' => $completionPercentage
            ];
        }
    }
}


