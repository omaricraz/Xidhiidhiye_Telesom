<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LearningGoalController;
use App\Http\Controllers\ManagerDashboardController;
use App\Http\Controllers\NoticeboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QAController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WhoIsWhoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

// Redirect guests to login page, authenticated users to their default route
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        // Redirect based on role (same logic as LoginController)
        if ($user->isManager()) {
            return redirect()->route('manager.dashboard');
        } elseif ($user->isTeamLead()) {
            return redirect()->route('lead.tasks.index');
        } elseif ($user->isIntern()) {
            return redirect()->route('onboarding.index');
        } else {
            return redirect()->route('tasks.index');
        }
    }
    return redirect()->route('login');
});

// Define a group of routes with 'auth' middleware applied
Route::middleware(['auth'])->group(function () {
    // Define a GET route for the home/dashboard
    Route::get('/home', function () {
        // Return a view named 'index' when accessing the home URL
        return view('index');
    })->name('home');

    // Manager Dashboard
    Route::get('manager/dashboard', [ManagerDashboardController::class, 'index'])->name('manager.dashboard');

    // Admin routes (Manager only)
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class);
    });

    // Lead routes
    Route::prefix('lead')->name('lead.')->group(function () {
        Route::get('tasks', [TaskController::class, 'index'])->name('tasks.index');
    });

    // Tasks routes
    Route::resource('tasks', TaskController::class);
    Route::post('tasks/{task}/accept', [TaskController::class, 'accept'])->name('tasks.accept');
    Route::post('tasks/{task}/completed', [TaskController::class, 'completed'])->name('tasks.completed');

    // Onboarding routes
    Route::prefix('onboarding')->name('onboarding.')->group(function () {
        Route::get('/', [LearningGoalController::class, 'index'])->name('index');
        Route::get('create', [LearningGoalController::class, 'create'])->name('create');
        Route::post('/', [LearningGoalController::class, 'store'])->name('store');
        Route::get('{learningGoal}/edit', [LearningGoalController::class, 'edit'])->name('edit');
        Route::put('{learningGoal}', [LearningGoalController::class, 'update'])->name('update');
        Route::delete('{learningGoal}', [LearningGoalController::class, 'destroy'])->name('destroy');
        Route::post('{learningGoal}/mark-completed', [LearningGoalController::class, 'markCompleted'])->name('mark-completed');
    });

    // Who's Who route
    Route::get('whoswho', [WhoIsWhoController::class, 'index'])->name('whoswho.index');

    // Profile route
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');

    // Noticeboard routes
    Route::get('noticeboard', [NoticeboardController::class, 'index'])->name('noticeboard.index');
    Route::get('noticeboard/create', [NoticeboardController::class, 'create'])->name('noticeboard.create');
    Route::post('noticeboard', [NoticeboardController::class, 'store'])->name('noticeboard.store');
    Route::get('noticeboard/{notice}/edit', [NoticeboardController::class, 'edit'])->name('noticeboard.edit');
    Route::put('noticeboard/{notice}', [NoticeboardController::class, 'update'])->name('noticeboard.update');
    Route::delete('noticeboard/{notice}', [NoticeboardController::class, 'destroy'])->name('noticeboard.destroy');

    // Q&A routes
    Route::prefix('qa')->name('qa.')->group(function () {
        Route::get('/', [QAController::class, 'index'])->name('index');
        Route::get('create', [QAController::class, 'create'])->name('create');
        Route::post('/', [QAController::class, 'store'])->name('store');
        Route::get('{question}', [QAController::class, 'show'])->name('show');
        Route::get('{question}/edit', [QAController::class, 'edit'])->name('edit');
        Route::put('{question}', [QAController::class, 'update'])->name('update');
        Route::delete('{question}', [QAController::class, 'destroy'])->name('destroy');
    });

    // Template pages route disabled - uncomment below to enable template demo pages
    // Route::get('{routeName}/{name?}', [HomeController::class, 'pageView']);
});