<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $query = Task::with(['creator', 'assignee']);

        // Apply scoped queries based on role
        if ($user->isManager()) {
            // Manager sees all tasks
            $tasks = $query->latest()->paginate(15);
            // Get statistics for managers/leads widget
            $totalTasks = Task::count();
            $completedTasks = Task::where('status', 'Completed')->count();
            $completionPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
            $recentTasks = Task::with(['creator', 'assignee'])->latest()->take(5)->get();
        } elseif ($user->isTeamLead() && $user->team_id) {
            // Team Lead sees tasks from their team
            $teamMemberIds = User::where('team_id', $user->team_id)->pluck('id');
            $tasks = $query->where(function($q) use ($teamMemberIds, $user) {
                $q->whereIn('assignee_id', $teamMemberIds)
                  ->orWhereIn('creator_id', $teamMemberIds)
                  ->orWhere('creator_id', $user->id);
            })->latest()->paginate(15);
            // Get statistics for managers/leads widget
            $teamTaskQuery = Task::where(function($q) use ($teamMemberIds, $user) {
                $q->whereIn('assignee_id', $teamMemberIds)
                  ->orWhereIn('creator_id', $teamMemberIds)
                  ->orWhere('creator_id', $user->id);
            });
            $totalTasks = $teamTaskQuery->count();
            $completedTasks = Task::where(function($q) use ($teamMemberIds, $user) {
                $q->whereIn('assignee_id', $teamMemberIds)
                  ->orWhereIn('creator_id', $teamMemberIds)
                  ->orWhere('creator_id', $user->id);
            })->where('status', 'Completed')->count();
            $completionPercentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
            $recentTasks = Task::with(['creator', 'assignee'])->where(function($q) use ($teamMemberIds, $user) {
                $q->whereIn('assignee_id', $teamMemberIds)
                  ->orWhereIn('creator_id', $teamMemberIds)
                  ->orWhere('creator_id', $user->id);
            })->latest()->take(5)->get();
        } elseif ($user->isIntern()) {
            // Intern sees only their own tasks
            $tasks = $query->where(function($q) use ($user) {
                $q->where('assignee_id', $user->id)
                  ->orWhere('creator_id', $user->id);
            })->latest()->paginate(15);
            // For normal users, get their tasks for the "My Task" widget
            // Order by status: Pending first, then In_Progress, then Completed
            // Within each status, order by most recent first
            $userTasks = Task::with(['creator', 'assignee'])->where(function($q) use ($user) {
                $q->where('assignee_id', $user->id)
                  ->orWhere('creator_id', $user->id);
            })->orderByRaw("CASE 
                WHEN status = 'Pending' THEN 1 
                WHEN status = 'In_Progress' THEN 2 
                WHEN status = 'Completed' THEN 3 
                ELSE 4 
            END")
            ->orderBy('created_at', 'desc')
            ->get();
            return view('tasks.index', compact('tasks', 'userTasks'));
        } else {
            // Employee sees their own tasks
            $tasks = $query->where(function($q) use ($user) {
                $q->where('assignee_id', $user->id)
                  ->orWhere('creator_id', $user->id);
            })->latest()->paginate(15);
            // For normal users, get their tasks for the "My Task" widget
            // Order by status: Pending first, then In_Progress, then Completed
            // Within each status, order by most recent first
            $userTasks = Task::with(['creator', 'assignee'])->where(function($q) use ($user) {
                $q->where('assignee_id', $user->id)
                  ->orWhere('creator_id', $user->id);
            })->orderByRaw("CASE 
                WHEN status = 'Pending' THEN 1 
                WHEN status = 'In_Progress' THEN 2 
                WHEN status = 'Completed' THEN 3 
                ELSE 4 
            END")
            ->orderBy('created_at', 'desc')
            ->get();
            return view('tasks.index', compact('tasks', 'userTasks'));
        }

        return view('tasks.index', compact('tasks', 'totalTasks', 'completedTasks', 'completionPercentage', 'recentTasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Task::class);
        $user = Auth::user();
        
        // If user is a team lead, only show their team members
        if ($user->isTeamLead() && $user->team_id) {
            $users = User::where('team_id', $user->team_id)
                ->where('id', '!=', $user->id)
                ->get();
        } else {
            // Managers and others see all users
            $users = User::where('id', '!=', Auth::id())->get();
        }
        
        return view('tasks.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Task::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:High,Medium,Normal',
            'status' => 'required|in:Pending,In_Progress,Completed',
            'assignee_id' => 'nullable|exists:users,id',
        ]);

        // If user is a team lead, ensure assignee is from their team
        $user = Auth::user();
        if ($user->isTeamLead() && $user->team_id && $request->assignee_id) {
            $assignee = User::find($request->assignee_id);
            if (!$assignee || $assignee->team_id !== $user->team_id) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['assignee_id' => 'You can only assign tasks to members of your team.']);
            }
        }

        $validated['creator_id'] = Auth::id();

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        Gate::authorize('view', $task);
        $task->load(['creator', 'assignee']);
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        Gate::authorize('update', $task);
        $user = Auth::user();
        
        // If user is a team lead, only show their team members
        if ($user->isTeamLead() && $user->team_id) {
            $users = User::where('team_id', $user->team_id)
                ->where('id', '!=', $user->id)
                ->get();
        } else {
            // Managers and others see all users
            $users = User::where('id', '!=', Auth::id())->get();
        }
        
        return view('tasks.edit', compact('task', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        Gate::authorize('update', $task);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:High,Medium,Normal',
            'status' => 'required|in:Pending,In_Progress,Completed',
            'assignee_id' => 'nullable|exists:users,id',
        ]);

        // If user is a team lead, ensure assignee is from their team
        $user = Auth::user();
        if ($user->isTeamLead() && $user->team_id && $request->assignee_id) {
            $assignee = User::find($request->assignee_id);
            if (!$assignee || $assignee->team_id !== $user->team_id) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['assignee_id' => 'You can only assign tasks to members of your team.']);
            }
        }

        // Interns can only update status
        if ($user->isIntern()) {
            $validated = ['status' => $validated['status']];
        }

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        Gate::authorize('delete', $task);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    /**
     * Accept a task (change status to In_Progress).
     * Only normal users (Employee and Intern) can accept tasks.
     */
    public function accept(Task $task)
    {
        $user = Auth::user();
        
        // Only normal users (Employee and Intern) can accept tasks
        if (!$user->isEmployee() && !$user->isIntern()) {
            abort(403, 'Only employees and interns can accept tasks.');
        }

        // Only allow accepting tasks assigned to the user
        if ($task->assignee_id !== $user->id) {
            abort(403, 'You can only accept tasks assigned to you.');
        }

        // Only allow accepting if status is Pending
        if ($task->status !== 'Pending') {
            return redirect()->route('tasks.index')->with('error', 'Task can only be accepted when status is Pending.');
        }

        $task->update(['status' => 'In_Progress']);

        return redirect()->route('tasks.index')->with('success', 'Task accepted and marked as In Progress.');
    }

    /**
     * Mark a task as completed.
     * Only normal users (Employee and Intern) can mark tasks as completed.
     */
    public function completed(Task $task)
    {
        $user = Auth::user();
        
        // Only normal users (Employee and Intern) can mark tasks as completed
        if (!$user->isEmployee() && !$user->isIntern()) {
            abort(403, 'Only employees and interns can mark tasks as completed.');
        }

        // Only allow completing tasks assigned to the user
        if ($task->assignee_id !== $user->id) {
            abort(403, 'You can only mark tasks assigned to you as completed.');
        }

        $task->update(['status' => 'Completed']);

        return redirect()->route('tasks.index')->with('success', 'Task marked as completed. Team lead and manager have been notified.');
    }
}

