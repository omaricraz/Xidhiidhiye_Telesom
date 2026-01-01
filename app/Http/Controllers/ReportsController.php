<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use App\Models\Question;
use App\Models\LearningGoal;
use App\Models\UserLearningProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
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
     * Display the reports dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('reports.index');
    }

    /**
     * Display the Task Management report.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function taskManagement(Request $request)
    {
        $user = Auth::user();
        
        // Get filter parameters
        $dateFrom = $request->input('date_from', now()->subDays(30)->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->format('Y-m-d'));
        $teamId = $request->input('team_id');
        $status = $request->input('status');
        $priority = $request->input('priority');
        
        // Build query
        $query = Task::with(['creator', 'assignee', 'assignee.team'])
            ->whereBetween('created_at', [
                $dateFrom . ' 00:00:00',
                $dateTo . ' 23:59:59'
            ]);
        
        // Apply role-based filtering
        if ($user->isManager()) {
            // Manager sees all tasks
        } elseif ($user->isTeamLead() && $user->team_id) {
            // Team Lead sees tasks from their team
            $teamMemberIds = User::where('team_id', $user->team_id)->pluck('id');
            $query->where(function($q) use ($teamMemberIds, $user) {
                $q->whereIn('assignee_id', $teamMemberIds)
                  ->orWhereIn('creator_id', $teamMemberIds)
                  ->orWhere('creator_id', $user->id);
            });
        } else {
            // Regular employees see only their tasks
            $query->where(function($q) use ($user) {
                $q->where('assignee_id', $user->id)
                  ->orWhere('creator_id', $user->id);
            });
        }
        
        // Apply filters
        if ($teamId) {
            $teamMemberIds = User::where('team_id', $teamId)->pluck('id');
            $query->where(function($q) use ($teamMemberIds) {
                $q->whereIn('assignee_id', $teamMemberIds)
                  ->orWhereIn('creator_id', $teamMemberIds);
            });
        }
        
        if ($status) {
            $query->where('status', $status);
        }
        
        if ($priority) {
            $query->where('priority', $priority);
        }
        
        // Get all tasks for display
        $tasks = $query->orderBy('created_at', 'desc')->get();
        
        // Calculate statistics
        $totalTasks = $tasks->count();
        $completedTasks = $tasks->where('status', 'Completed')->count();
        $inProgressTasks = $tasks->where('status', 'In_Progress')->count();
        $pendingTasks = $tasks->where('status', 'Pending')->count();
        $highPriorityTasks = $tasks->where('priority', 'High')->where('status', '!=', 'Completed')->count();
        $completionPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
        
        // Status distribution for chart
        $statusDistribution = [
            'Completed' => $completedTasks,
            'In Progress' => $inProgressTasks,
            'Pending' => $pendingTasks,
        ];
        
        // Priority distribution
        $priorityDistribution = [
            'High' => $tasks->where('priority', 'High')->count(),
            'Medium' => $tasks->where('priority', 'Medium')->count(),
            'Normal' => $tasks->where('priority', 'Normal')->count(),
        ];
        
        // Tasks by team (if manager)
        $tasksByTeam = [];
        if ($user->isManager()) {
            $tasksByTeam = Task::with('assignee.team')
                ->whereBetween('created_at', [
                    $dateFrom . ' 00:00:00',
                    $dateTo . ' 23:59:59'
                ])
                ->get()
                ->groupBy(function($task) {
                    return $task->assignee && $task->assignee->team 
                        ? $task->assignee->team->name 
                        : 'Unassigned';
                })
                ->map->count()
                ->toArray();
        }
        
        // Get teams for filter dropdown
        $teams = Team::orderBy('name')->get();
        
        return view('reports.task-management', [
            'tasks' => $tasks,
            'totalTasks' => $totalTasks,
            'completedTasks' => $completedTasks,
            'inProgressTasks' => $inProgressTasks,
            'pendingTasks' => $pendingTasks,
            'highPriorityTasks' => $highPriorityTasks,
            'completionPercentage' => $completionPercentage,
            'statusDistribution' => $statusDistribution,
            'priorityDistribution' => $priorityDistribution,
            'tasksByTeam' => $tasksByTeam,
            'teams' => $teams,
            'filters' => [
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'team_id' => $teamId,
                'status' => $status,
                'priority' => $priority,
            ],
        ]);
    }

    /**
     * Display the User Activity report.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function userActivity(Request $request)
    {
        $user = Auth::user();
        
        // Get filter parameters
        $dateFrom = $request->input('date_from', now()->subDays(30)->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->format('Y-m-d'));
        $teamId = $request->input('team_id');
        $role = $request->input('role');
        
        // Build user query
        $query = User::query();
        
        // Apply role-based filtering
        if (!$user->isManager()) {
            if ($user->isTeamLead() && $user->team_id) {
                $query->where('team_id', $user->team_id);
            } else {
                $query->where('id', $user->id);
            }
        }
        
        // Apply filters
        if ($teamId) {
            $query->where('team_id', $teamId);
        }
        
        if ($role) {
            $query->where('role', $role);
        }
        
        $users = $query->with(['team', 'createdTasks', 'assignedTasks', 'learningProgress'])->get();
        
        // Calculate statistics
        $totalUsers = $users->count();
        $activeUsers = $users->where('status', 'active')->count();
        $usersByRole = $users->groupBy('role')->map->count()->toArray();
        $usersByTeam = $users->whereNotNull('team_id')->groupBy('team.name')->map->count()->toArray();
        
        // User activity metrics
        $userActivityData = [];
        foreach ($users as $u) {
            $tasksCreated = $u->createdTasks()->whereBetween('created_at', [
                $dateFrom . ' 00:00:00',
                $dateTo . ' 23:59:59'
            ])->count();
            
            $tasksCompleted = $u->assignedTasks()->where('status', 'Completed')
                ->whereBetween('updated_at', [
                    $dateFrom . ' 00:00:00',
                    $dateTo . ' 23:59:59'
                ])->count();
            
            $questionsAsked = $u->createdQuestions()->whereBetween('created_at', [
                $dateFrom . ' 00:00:00',
                $dateTo . ' 23:59:59'
            ])->count();
            
            $userActivityData[] = [
                'user' => $u,
                'tasks_created' => $tasksCreated,
                'tasks_completed' => $tasksCompleted,
                'questions_asked' => $questionsAsked,
                'total_activity' => $tasksCreated + $tasksCompleted + $questionsAsked,
            ];
        }
        
        // Sort by activity
        usort($userActivityData, function($a, $b) {
            return $b['total_activity'] <=> $a['total_activity'];
        });
        
        $teams = Team::orderBy('name')->get();
        
        return view('reports.user-activity', [
            'users' => $users,
            'userActivityData' => $userActivityData,
            'totalUsers' => $totalUsers,
            'activeUsers' => $activeUsers,
            'usersByRole' => $usersByRole,
            'usersByTeam' => $usersByTeam,
            'teams' => $teams,
            'filters' => [
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'team_id' => $teamId,
                'role' => $role,
            ],
        ]);
    }

    /**
     * Display the Learning Progress report.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function learningProgress(Request $request)
    {
        $user = Auth::user();
        
        // Get filter parameters
        $dateFrom = $request->input('date_from', now()->subDays(90)->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->format('Y-m-d'));
        $teamId = $request->input('team_id');
        
        // Build learning goals query
        $query = LearningGoal::with(['team', 'userProgress.user']);
        
        // Apply role-based filtering
        if (!$user->isManager()) {
            if ($user->isTeamLead() && $user->team_id) {
                $query->where('team_id', $user->team_id);
            } else {
                // Regular users see goals from their team
                if ($user->team_id) {
                    $query->where('team_id', $user->team_id);
                } else {
                    $query->whereNull('team_id');
                }
            }
        }
        
        // Apply filters
        if ($teamId) {
            $query->where('team_id', $teamId);
        }
        
        $learningGoals = $query->get();
        
        // Calculate statistics
        $totalGoals = $learningGoals->count();
        $goalsByTeam = $learningGoals->groupBy(function($goal) {
            return $goal->team ? $goal->team->name : 'Global';
        })->map->count()->toArray();
        
        // Progress statistics
        $progressStats = [];
        foreach ($learningGoals as $goal) {
            $totalUsers = UserLearningProgress::where('goal_id', $goal->id)->count();
            $completedUsers = UserLearningProgress::where('goal_id', $goal->id)
                ->where('is_completed', true)->count();
            $completionRate = $totalUsers > 0 ? round(($completedUsers / $totalUsers) * 100) : 0;
            
            $progressStats[] = [
                'goal' => $goal,
                'total_users' => $totalUsers,
                'completed_users' => $completedUsers,
                'completion_rate' => $completionRate,
            ];
        }
        
        // Overall completion rate
        $allProgress = UserLearningProgress::whereIn('goal_id', $learningGoals->pluck('id'))->get();
        $totalProgress = $allProgress->count();
        $completedProgress = $allProgress->where('is_completed', true)->count();
        $overallCompletionRate = $totalProgress > 0 ? round(($completedProgress / $totalProgress) * 100) : 0;
        
        // User progress data
        $userProgressData = [];
        $userIds = $learningGoals->flatMap(function($goal) {
            return $goal->userProgress->pluck('user_id');
        })->unique();
        
        foreach ($userIds as $userId) {
            $user = User::find($userId);
            if ($user) {
                $userGoals = UserLearningProgress::where('user_id', $userId)
                    ->whereIn('goal_id', $learningGoals->pluck('id'))
                    ->get();
                $completed = $userGoals->where('is_completed', true)->count();
                $total = $userGoals->count();
                
                $userProgressData[] = [
                    'user' => $user,
                    'total_goals' => $total,
                    'completed_goals' => $completed,
                    'completion_rate' => $total > 0 ? round(($completed / $total) * 100) : 0,
                ];
            }
        }
        
        usort($userProgressData, function($a, $b) {
            return $b['completion_rate'] <=> $a['completion_rate'];
        });
        
        $teams = Team::orderBy('name')->get();
        
        return view('reports.learning-progress', [
            'learningGoals' => $learningGoals,
            'progressStats' => $progressStats,
            'userProgressData' => $userProgressData,
            'totalGoals' => $totalGoals,
            'goalsByTeam' => $goalsByTeam,
            'overallCompletionRate' => $overallCompletionRate,
            'totalProgress' => $totalProgress,
            'completedProgress' => $completedProgress,
            'teams' => $teams,
            'filters' => [
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'team_id' => $teamId,
            ],
        ]);
    }

    /**
     * Display the Team Performance report.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function teamPerformance(Request $request)
    {
        $user = Auth::user();
        
        // Get filter parameters
        $dateFrom = $request->input('date_from', now()->subDays(30)->format('Y-m-d'));
        $dateTo = $request->input('date_to', now()->format('Y-m-d'));
        $teamId = $request->input('team_id');
        
        // Build teams query
        $query = Team::with(['members', 'lead', 'learningGoals']);
        
        // Apply role-based filtering
        if (!$user->isManager()) {
            if ($user->isTeamLead() && $user->team_id) {
                $query->where('id', $user->team_id);
            } else {
                // Regular users see only their team
                if ($user->team_id) {
                    $query->where('id', $user->team_id);
                } else {
                    $query->whereRaw('1 = 0'); // No teams
                }
            }
        }
        
        // Apply filters
        if ($teamId) {
            $query->where('id', $teamId);
        }
        
        $teams = $query->get();
        
        // Calculate team performance metrics
        $teamPerformanceData = [];
        foreach ($teams as $team) {
            $teamMemberIds = $team->members->pluck('id');
            
            // Task metrics
            $totalTasks = Task::whereBetween('created_at', [
                $dateFrom . ' 00:00:00',
                $dateTo . ' 23:59:59'
            ])->where(function($q) use ($teamMemberIds) {
                $q->whereIn('assignee_id', $teamMemberIds)
                  ->orWhereIn('creator_id', $teamMemberIds);
            })->count();
            
            $completedTasks = Task::where('status', 'Completed')
                ->whereBetween('updated_at', [
                    $dateFrom . ' 00:00:00',
                    $dateTo . ' 23:59:59'
                ])->where(function($q) use ($teamMemberIds) {
                    $q->whereIn('assignee_id', $teamMemberIds)
                      ->orWhereIn('creator_id', $teamMemberIds);
                })->count();
            
            $completionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
            
            // Learning goals metrics
            $totalGoals = $team->learningGoals->count();
            $completedGoals = UserLearningProgress::whereIn('user_id', $teamMemberIds)
                ->where('is_completed', true)
                ->whereIn('goal_id', $team->learningGoals->pluck('id'))
                ->count();
            
            // Questions metrics
            $questionsAsked = Question::where('team_id', $team->id)
                ->whereBetween('created_at', [
                    $dateFrom . ' 00:00:00',
                    $dateTo . ' 23:59:59'
                ])->count();
            
            $teamPerformanceData[] = [
                'team' => $team,
                'member_count' => $team->members->count(),
                'total_tasks' => $totalTasks,
                'completed_tasks' => $completedTasks,
                'completion_rate' => $completionRate,
                'total_goals' => $totalGoals,
                'completed_goals' => $completedGoals,
                'questions_asked' => $questionsAsked,
                'productivity_score' => ($completionRate * 0.5) + (($completedGoals / max($totalGoals, 1)) * 50),
            ];
        }
        
        // Sort by productivity score
        usort($teamPerformanceData, function($a, $b) {
            return $b['productivity_score'] <=> $a['productivity_score'];
        });
        
        $allTeams = Team::orderBy('name')->get();
        
        return view('reports.team-performance', [
            'teams' => $teams,
            'teamPerformanceData' => $teamPerformanceData,
            'allTeams' => $allTeams,
            'filters' => [
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'team_id' => $teamId,
            ],
        ]);
    }

}

