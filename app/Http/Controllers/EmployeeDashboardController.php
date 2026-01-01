<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeDashboardController extends Controller
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
     * Show the employee dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $employee = Auth::user();
        
        // Get all tasks assigned to or created by this employee
        $userTaskQuery = Task::where(function($q) use ($employee) {
            $q->where('assignee_id', $employee->id)
              ->orWhere('creator_id', $employee->id);
        });
        
        // Task statistics
        $totalTasks = $userTaskQuery->count();
        $completedTasks = (clone $userTaskQuery)->where('status', 'Completed')->count();
        $inProgressTasks = (clone $userTaskQuery)->where('status', 'In_Progress')->count();
        $pendingTasks = (clone $userTaskQuery)->where('status', 'Pending')->count();
        $highPriorityTasks = (clone $userTaskQuery)->where('priority', 'High')
            ->where('status', '!=', 'Completed')->count();
        
        // Calculate productivity metrics
        $taskCompletionPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
        
        // Calculate productivity level based on completion rate
        $productivityLevel = $this->calculateProductivityLevel($taskCompletionPercentage);
        
        // Get tasks by priority
        $highPriorityCount = (clone $userTaskQuery)->where('priority', 'High')
            ->where('status', '!=', 'Completed')->count();
        $mediumPriorityCount = (clone $userTaskQuery)->where('priority', 'Medium')
            ->where('status', '!=', 'Completed')->count();
        $lowPriorityCount = (clone $userTaskQuery)->where('priority', 'Low')
            ->where('status', '!=', 'Completed')->count();
        
        // Get recent tasks (last 5)
        $recentTasks = (clone $userTaskQuery)
            ->with(['creator', 'assignee'])
            ->latest()
            ->take(5)
            ->get();
        
        // Get tasks assigned to me (not created by me)
        $assignedToMe = Task::where('assignee_id', $employee->id)
            ->where('creator_id', '!=', $employee->id)
            ->count();
        
        // Get tasks created by me
        $createdByMe = Task::where('creator_id', $employee->id)
            ->where('assignee_id', '!=', $employee->id)
            ->count();
        
        // Get overdue tasks (tasks that are pending or in progress and created more than 7 days ago)
        $overdueTasks = (clone $userTaskQuery)
            ->whereIn('status', ['Pending', 'In_Progress'])
            ->where('created_at', '<', now()->subDays(7))
            ->count();
        
        // Calculate average completion time (for completed tasks)
        $completedTasksWithDates = (clone $userTaskQuery)
            ->where('status', 'Completed')
            ->whereNotNull('updated_at')
            ->get();
        
        $averageCompletionDays = 0;
        if ($completedTasksWithDates->count() > 0) {
            $totalDays = $completedTasksWithDates->sum(function($task) {
                return $task->created_at->diffInDays($task->updated_at);
            });
            $averageCompletionDays = round($totalDays / $completedTasksWithDates->count(), 1);
        }
        
        return view('employee.dashboard', [
            'totalTasks' => $totalTasks,
            'completedTasks' => $completedTasks,
            'inProgressTasks' => $inProgressTasks,
            'pendingTasks' => $pendingTasks,
            'highPriorityTasks' => $highPriorityTasks,
            'taskCompletionPercentage' => $taskCompletionPercentage,
            'productivityLevel' => $productivityLevel,
            'highPriorityCount' => $highPriorityCount,
            'mediumPriorityCount' => $mediumPriorityCount,
            'lowPriorityCount' => $lowPriorityCount,
            'recentTasks' => $recentTasks,
            'assignedToMe' => $assignedToMe,
            'createdByMe' => $createdByMe,
            'overdueTasks' => $overdueTasks,
            'averageCompletionDays' => $averageCompletionDays,
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


