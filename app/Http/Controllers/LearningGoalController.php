<?php

namespace App\Http\Controllers;

use App\Models\LearningGoal;
use App\Models\User;
use App\Models\UserLearningProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class LearningGoalController extends Controller
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
        $query = LearningGoal::with(['team', 'userProgress']);

        // Manager sees all learning goals (including old team-specific ones)
        if ($user->isManager()) {
            $goals = $query->latest()->get();
        } else {
            // Other users see only learning goals for all teams
            $goals = $query->whereNull('team_id')->latest()->get();
        }

        // Get user progress for each goal with completion dates
        $userProgressData = UserLearningProgress::where('user_id', $user->id)
            ->get()
            ->keyBy('goal_id')
            ->map(function($progress) {
                return [
                    'is_completed' => $progress->is_completed,
                    'completed_at' => $progress->completed_at,
                ];
            })
            ->toArray();

        return view('onboarding.index', compact('goals', 'userProgressData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', LearningGoal::class);
        return view('onboarding.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', LearningGoal::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'resource_url' => 'nullable|url',
        ]);

        // Create learning goal for all teams (team_id is null)
        $validated['team_id'] = null;
        $goal = LearningGoal::create($validated);

        // Automatically create user_learning_progress entries for ALL users
        $allUsers = User::all();
        foreach ($allUsers as $user) {
            UserLearningProgress::create([
                'user_id' => $user->id,
                'goal_id' => $goal->id,
                'is_completed' => false,
            ]);
        }

        return redirect()->route('onboarding.index')->with('success', 'Learning goal created successfully for all teams.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LearningGoal $learningGoal)
    {
        Gate::authorize('view', $learningGoal);
        $learningGoal->load(['team', 'userProgress.user']);
        return view('onboarding.show', compact('learningGoal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LearningGoal $learningGoal)
    {
        Gate::authorize('update', $learningGoal);
        return view('onboarding.edit', compact('learningGoal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LearningGoal $learningGoal)
    {
        Gate::authorize('update', $learningGoal);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'resource_url' => 'nullable|url',
        ]);

        // Ensure team_id remains null (for all teams)
        $validated['team_id'] = null;
        $learningGoal->update($validated);

        return redirect()->route('onboarding.index')->with('success', 'Learning goal updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LearningGoal $learningGoal)
    {
        Gate::authorize('delete', $learningGoal);
        $learningGoal->delete();

        return redirect()->route('onboarding.index')->with('success', 'Learning goal deleted successfully.');
    }

    /**
     * Mark a learning goal as completed for the current user.
     */
    public function markCompleted(Request $request, LearningGoal $learningGoal)
    {
        $user = Auth::user();
        
        // Only employees and interns can mark goals as completed
        if (!$user->isEmployee() && !$user->isIntern()) {
            abort(403, 'Only employees and interns can mark learning goals as completed.');
        }
        
        $progress = UserLearningProgress::firstOrCreate(
            [
                'user_id' => $user->id,
                'goal_id' => $learningGoal->id,
            ],
            [
                'is_completed' => false,
            ]
        );

        $progress->update([
            'is_completed' => true,
            'completed_at' => now(),
        ]);

        return redirect()->route('onboarding.index')->with('success', 'Learning goal marked as completed.');
    }
}

