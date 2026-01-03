<?php

namespace App\Providers;

use App\Models\LearningGoal;
use App\Models\Notice;
use App\Models\Question;
use App\Models\Task;
use App\Models\User;
use App\Policies\LearningGoalPolicy;
use App\Policies\NoticePolicy;
use App\Policies\QAPolicy;
use App\Policies\TaskPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Task::class => TaskPolicy::class,
        User::class => UserPolicy::class,
        LearningGoal::class => LearningGoalPolicy::class,
        Question::class => QAPolicy::class,
        Notice::class => NoticePolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        
        // #region agent log
        $logPath = base_path('.cursor/debug.log');
        $dbConfig = config('database');
        $defaultConn = $dbConfig['default'] ?? 'unknown';
        $mysqlConfig = $dbConfig['connections']['mysql'] ?? [];
        $logData = [
            'sessionId' => 'debug-session',
            'runId' => 'run1',
            'hypothesisId' => 'D',
            'location' => 'app/Providers/AppServiceProvider.php:48',
            'message' => 'Resolved database configuration',
            'data' => [
                'default_connection' => $defaultConn,
                'mysql_host' => $mysqlConfig['host'] ?? 'NOT_SET',
                'mysql_port' => $mysqlConfig['port'] ?? 'NOT_SET',
                'mysql_database' => $mysqlConfig['database'] ?? 'NOT_SET',
                'mysql_username' => $mysqlConfig['username'] ?? 'NOT_SET',
                'mysql_password_set' => !empty($mysqlConfig['password']),
            ],
            'timestamp' => time() * 1000,
        ];
        file_put_contents($logPath, json_encode($logData) . "\n", FILE_APPEND);
        // #endregion
    }
}
