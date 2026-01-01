<?php

namespace Database\Seeders;

use App\Models\LearningGoal;
use App\Models\Question;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use App\Models\UserLearningProgress;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Get all profile images from local storage
     * First checks public/images/profiles/, then falls back to public/build/images/user/
     */
    private function getProfileImages(): array
    {
        $profilesDir = public_path('images/profiles');
        $userDir = public_path('build/images/user');
        
        $images = [];
        
        // First, try to get images from profiles directory
        if (File::exists($profilesDir)) {
            $files = File::files($profilesDir);
            foreach ($files as $file) {
                $ext = strtolower($file->getExtension());
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    $images[] = '/images/profiles/' . $file->getFilename();
                }
            }
        }
        
        // If no images in profiles, fall back to existing user avatars
        if (empty($images) && File::exists($userDir)) {
            $files = File::files($userDir);
            foreach ($files as $file) {
                $ext = strtolower($file->getExtension());
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    $images[] = '/build/images/user/' . $file->getFilename();
                }
            }
        }
        
        return $images;
    }

    /**
     * Get a profile image by index (cycles through available images)
     */
    private function getProfileImageByIndex(int $index): ?string
    {
        $images = $this->getProfileImages();
        if (empty($images)) {
            return null;
        }
        return $images[$index % count($images)];
    }

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Teams (use firstOrCreate to avoid duplicates)
        $devTeam = Team::firstOrCreate(
            ['name' => 'Dev'],
            ['name' => 'Dev']
        );

        $devOpsTeam = Team::firstOrCreate(
            ['name' => 'DevOps'],
            ['name' => 'DevOps']
        );

        // Create Manager (User #1) leading both teams
        $manager = User::firstOrCreate(
            ['email' => 'manager@xidhiidhiye.com'],
            [
                'name' => 'John Manager',
                'email' => 'manager@xidhiidhiye.com',
                'password' => Hash::make('password'),
                'role' => 'Manager',
                'team_id' => null,
                'tech_stack' => 'Laravel, PHP, MySQL, JavaScript, Vue.js',
                'status_emoji' => '👔',
                'profile_image' => $this->getProfileImageByIndex(0),
                'status' => 'active',
            ]
        );
        // Update profile image and status if they don't exist
        if (!$manager->profile_image || !$manager->status) {
            $manager->update([
                'profile_image' => $this->getProfileImageByIndex(0) ?? $manager->profile_image,
                'status' => 'active',
            ]);
        }

        // Update teams with lead_id
        $devTeam->update(['lead_id' => $manager->id]);
        $devOpsTeam->update(['lead_id' => $manager->id]);

        // Create Team Leads
        $devLead = User::firstOrCreate(
            ['email' => 'devlead@xidhiidhiye.com'],
            [
                'name' => 'Sarah Dev Lead',
                'email' => 'devlead@xidhiidhiye.com',
                'password' => Hash::make('password'),
                'role' => 'Team_Lead',
                'team_id' => $devTeam->id,
                'tech_stack' => 'Laravel, PHP, React, TypeScript',
                'status_emoji' => '🚀',
                'profile_image' => $this->getProfileImageByIndex(1),
                'status' => 'remote',
            ]
        );
        // Update profile image and status if they don't exist
        if (!$devLead->profile_image || !$devLead->status) {
            $devLead->update([
                'profile_image' => $this->getProfileImageByIndex(1) ?? $devLead->profile_image,
                'status' => 'remote',
            ]);
        }

        $devOpsLead = User::firstOrCreate(
            ['email' => 'devopslead@xidhiidhiye.com'],
            [
                'name' => 'Mike DevOps Lead',
                'email' => 'devopslead@xidhiidhiye.com',
                'password' => Hash::make('password'),
                'role' => 'Team_Lead',
                'team_id' => $devOpsTeam->id,
                'tech_stack' => 'Docker, Kubernetes, AWS, Terraform',
                'status_emoji' => '⚙️',
                'profile_image' => $this->getProfileImageByIndex(2),
                'status' => 'active',
            ]
        );
        // Update profile image and status if they don't exist
        if (!$devOpsLead->profile_image || !$devOpsLead->status) {
            $devOpsLead->update([
                'profile_image' => $this->getProfileImageByIndex(2) ?? $devOpsLead->profile_image,
                'status' => 'active',
            ]);
        }

        // Create 2 Interns per team
        $devIntern1 = User::firstOrCreate(
            ['email' => 'devintern1@xidhiidhiye.com'],
            [
                'name' => 'Alice Developer',
                'email' => 'devintern1@xidhiidhiye.com',
                'password' => Hash::make('password'),
                'role' => 'Intern',
                'team_id' => $devTeam->id,
                'tech_stack' => 'PHP, JavaScript',
                'status_emoji' => '🌱',
                'profile_image' => $this->getProfileImageByIndex(3),
                'status' => 'active',
            ]
        );
        // Update profile image and status if they don't exist
        if (!$devIntern1->profile_image || !$devIntern1->status) {
            $devIntern1->update([
                'profile_image' => $this->getProfileImageByIndex(3) ?? $devIntern1->profile_image,
                'status' => 'active',
            ]);
        }

        $devIntern2 = User::firstOrCreate(
            ['email' => 'devintern2@xidhiidhiye.com'],
            [
                'name' => 'Bob Developer',
                'email' => 'devintern2@xidhiidhiye.com',
                'password' => Hash::make('password'),
                'role' => 'Intern',
                'team_id' => $devTeam->id,
                'tech_stack' => 'HTML, CSS, JavaScript',
                'status_emoji' => '🌱',
                'profile_image' => $this->getProfileImageByIndex(4),
                'status' => 'holiday',
            ]
        );
        // Update profile image and status if they don't exist
        if (!$devIntern2->profile_image || !$devIntern2->status) {
            $devIntern2->update([
                'profile_image' => $this->getProfileImageByIndex(4) ?? $devIntern2->profile_image,
                'status' => 'holiday',
            ]);
        }

        $devOpsIntern1 = User::firstOrCreate(
            ['email' => 'devopsintern1@xidhiidhiye.com'],
            [
                'name' => 'Charlie DevOps',
                'email' => 'devopsintern1@xidhiidhiye.com',
                'password' => Hash::make('password'),
                'role' => 'Intern',
                'team_id' => $devOpsTeam->id,
                'tech_stack' => 'Linux, Bash, Docker',
                'status_emoji' => '🌱',
                'profile_image' => $this->getProfileImageByIndex(5),
                'status' => 'sick_leave',
            ]
        );
        // Update profile image and status if they don't exist
        if (!$devOpsIntern1->profile_image || !$devOpsIntern1->status) {
            $devOpsIntern1->update([
                'profile_image' => $this->getProfileImageByIndex(5) ?? $devOpsIntern1->profile_image,
                'status' => 'sick_leave',
            ]);
        }

        $devOpsIntern2 = User::firstOrCreate(
            ['email' => 'devopsintern2@xidhiidhiye.com'],
            [
                'name' => 'Diana DevOps',
                'email' => 'devopsintern2@xidhiidhiye.com',
                'password' => Hash::make('password'),
                'role' => 'Intern',
                'team_id' => $devOpsTeam->id,
                'tech_stack' => 'Python, Docker, Git',
                'status_emoji' => '🌱',
                'profile_image' => $this->getProfileImageByIndex(0), // Cycle back if more users than images
                'status' => 'remote',
            ]
        );
        // Update profile image and status if they don't exist
        if (!$devOpsIntern2->profile_image || !$devOpsIntern2->status) {
            $devOpsIntern2->update([
                'profile_image' => $this->getProfileImageByIndex(0) ?? $devOpsIntern2->profile_image,
                'status' => 'remote',
            ]);
        }

        // Create 3 Learning Goals per team
        $devGoals = [
            [
                'team_id' => $devTeam->id,
                'title' => 'Laravel Fundamentals',
                'description' => 'Learn the basics of Laravel framework including routing, controllers, and models.',
                'resource_url' => 'https://laravel.com/docs',
            ],
            [
                'team_id' => $devTeam->id,
                'title' => 'Vue.js Basics',
                'description' => 'Understand Vue.js components, directives, and state management.',
                'resource_url' => 'https://vuejs.org/guide/',
            ],
            [
                'team_id' => $devTeam->id,
                'title' => 'Database Design',
                'description' => 'Learn database normalization, relationships, and query optimization.',
                'resource_url' => 'https://www.postgresql.org/docs/',
            ],
        ];

        $devOpsGoals = [
            [
                'team_id' => $devOpsTeam->id,
                'title' => 'Docker Essentials',
                'description' => 'Master Docker containers, images, and Docker Compose.',
                'resource_url' => 'https://docs.docker.com/',
            ],
            [
                'team_id' => $devOpsTeam->id,
                'title' => 'Kubernetes Basics',
                'description' => 'Learn Kubernetes pods, services, and deployments.',
                'resource_url' => 'https://kubernetes.io/docs/',
            ],
            [
                'team_id' => $devOpsTeam->id,
                'title' => 'CI/CD Pipeline',
                'description' => 'Understand continuous integration and deployment workflows.',
                'resource_url' => 'https://www.jenkins.io/doc/',
            ],
        ];

        foreach ($devGoals as $goalData) {
            $goal = LearningGoal::firstOrCreate(
                ['team_id' => $goalData['team_id'], 'title' => $goalData['title']],
                $goalData
            );
            // Create progress entries for all team members
            foreach ([$devLead, $devIntern1, $devIntern2] as $member) {
                UserLearningProgress::firstOrCreate(
                    [
                        'user_id' => $member->id,
                        'goal_id' => $goal->id,
                    ],
                    [
                        'user_id' => $member->id,
                        'goal_id' => $goal->id,
                        'is_completed' => false,
                    ]
                );
            }
        }

        foreach ($devOpsGoals as $goalData) {
            $goal = LearningGoal::firstOrCreate(
                ['team_id' => $goalData['team_id'], 'title' => $goalData['title']],
                $goalData
            );
            // Create progress entries for all team members
            foreach ([$devOpsLead, $devOpsIntern1, $devOpsIntern2] as $member) {
                UserLearningProgress::firstOrCreate(
                    [
                        'user_id' => $member->id,
                        'goal_id' => $goal->id,
                    ],
                    [
                        'user_id' => $member->id,
                        'goal_id' => $goal->id,
                        'is_completed' => false,
                    ]
                );
            }
        }

        // Create sample tasks for interns (use firstOrCreate to avoid duplicates)
        Task::firstOrCreate(
            [
                'title' => 'Setup Development Environment',
                'creator_id' => $devLead->id,
            ],
            [
                'title' => 'Setup Development Environment',
                'description' => 'Install and configure Laravel, PHP, and required tools.',
                'priority' => 'High',
                'status' => 'Pending',
                'is_private' => false,
                'creator_id' => $devLead->id,
                'assignee_id' => $devIntern1->id,
            ]
        );

        Task::firstOrCreate(
            [
                'title' => 'Learn Laravel Routing',
                'creator_id' => $devLead->id,
            ],
            [
                'title' => 'Learn Laravel Routing',
                'description' => 'Complete the Laravel routing tutorial and create sample routes.',
                'priority' => 'Medium',
                'status' => 'In_Progress',
                'is_private' => false,
                'creator_id' => $devLead->id,
                'assignee_id' => $devIntern2->id,
            ]
        );

        Task::firstOrCreate(
            [
                'title' => 'Docker Container Setup',
                'creator_id' => $devOpsLead->id,
            ],
            [
                'title' => 'Docker Container Setup',
                'description' => 'Create Docker containers for development environment.',
                'priority' => 'High',
                'status' => 'Pending',
                'is_private' => false,
                'creator_id' => $devOpsLead->id,
                'assignee_id' => $devOpsIntern1->id,
            ]
        );

        Task::firstOrCreate(
            [
                'title' => 'Kubernetes Cluster Configuration',
                'creator_id' => $devOpsLead->id,
            ],
            [
                'title' => 'Kubernetes Cluster Configuration',
                'description' => 'Set up a local Kubernetes cluster and deploy sample applications.',
                'priority' => 'Medium',
                'status' => 'Pending',
                'is_private' => false,
                'creator_id' => $devOpsLead->id,
                'assignee_id' => $devOpsIntern2->id,
            ]
        );

        // Create Questions/FAQ demo data - Global Questions
        $globalQuestions = [
            [
                'question' => 'How do I submit a task for review?',
                'answer' => 'You can submit a task for review by updating its status to "Completed" in the Tasks section. Your team lead will be notified and can review your work.',
                'created_by' => $manager->id,
                'team_id' => null,
            ],
            [
                'question' => 'What is the process for onboarding new team members?',
                'answer' => 'New team members should complete the learning goals assigned to their team in the Onboarding section. Each goal includes resources and can be marked as completed once finished.',
                'created_by' => $manager->id,
                'team_id' => null,
            ],
            [
                'question' => 'Where can I find project documentation?',
                'answer' => 'Project documentation is available in the Noticeboard section. Team leads regularly update important information there. You can also check the onboarding resources for learning materials.',
                'created_by' => $manager->id,
                'team_id' => null,
            ],
            [
                'question' => 'What is the difference between a Manager and Team Lead?',
                'answer' => 'Managers have access to all teams and can manage users, while Team Leads manage their specific team members and tasks. Both can create and manage Q&A questions for their teams.',
                'created_by' => $manager->id,
                'team_id' => null,
            ],
            [
                'question' => 'How do I report a bug or issue?',
                'answer' => 'Report bugs or issues to your team lead. They will assess the issue and either assign it as a task or escalate it to the manager if needed. Include as much detail as possible: steps to reproduce, expected vs actual behavior, and screenshots if applicable.',
                'created_by' => $manager->id,
                'team_id' => null,
            ],
            [
                'question' => 'What are the working hours and remote work policies?',
                'answer' => 'Standard working hours are 9 AM to 5 PM, but we offer flexible schedules. Remote work is allowed based on your role and team lead approval. Check with your team lead for specific team policies.',
                'created_by' => $manager->id,
                'team_id' => null,
            ],
            [
                'question' => 'How do I request time off?',
                'answer' => 'Submit your time off request to your team lead at least one week in advance. Include the dates and reason. Your team lead will review and approve based on team workload and coverage.',
                'created_by' => $manager->id,
                'team_id' => null,
            ],
        ];

        // Dev Team Questions
        $devTeamQuestions = [
            [
                'question' => 'How do I access the development environment?',
                'answer' => 'Contact your team lead for access credentials. The development environment setup is typically done during your first week. Check the onboarding goals for detailed instructions.',
                'created_by' => $devLead->id,
                'team_id' => $devTeam->id,
            ],
            [
                'question' => 'What tools do I need for Laravel development?',
                'answer' => 'You will need PHP 8.1+, Composer, Node.js, and a code editor like VS Code. Your team lead can provide the complete setup guide in the onboarding section.',
                'created_by' => $devLead->id,
                'team_id' => $devTeam->id,
            ],
            [
                'question' => 'How do I mark a learning goal as completed?',
                'answer' => 'Navigate to the Onboarding section, find the learning goal you want to complete, and click the "Mark as Completed" button. This will update your progress and help track your onboarding journey.',
                'created_by' => $devLead->id,
                'team_id' => $devTeam->id,
            ],
            [
                'question' => 'What is the Git workflow for this project?',
                'answer' => 'We use Git Flow with main, develop, and feature branches. Always create a feature branch from develop for new work. Submit pull requests for code review before merging. Never push directly to main or develop branches.',
                'created_by' => $devLead->id,
                'team_id' => $devTeam->id,
            ],
            [
                'question' => 'How do I run database migrations?',
                'answer' => 'Use `php artisan migrate` to run pending migrations. Always test migrations in your local environment first. For production, coordinate with your team lead. Never run migrations directly on production without approval.',
                'created_by' => $devLead->id,
                'team_id' => $devTeam->id,
            ],
            [
                'question' => 'What coding standards should I follow?',
                'answer' => 'Follow PSR-12 coding standards for PHP. Use Laravel conventions for naming and structure. Run `php artisan pint` before committing code. Review the team\'s style guide in the onboarding section for more details.',
                'created_by' => $devLead->id,
                'team_id' => $devTeam->id,
            ],
            [
                'question' => 'How do I set up the local development environment?',
                'answer' => '1. Clone the repository, 2. Copy .env.example to .env and configure, 3. Run `composer install`, 4. Run `npm install`, 5. Run `php artisan key:generate`, 6. Set up your database, 7. Run `php artisan migrate --seed`, 8. Run `npm run dev` for assets. Contact your team lead if you encounter issues.',
                'created_by' => $devLead->id,
                'team_id' => $devTeam->id,
            ],
            [
                'question' => 'How do I write unit tests?',
                'answer' => 'Use PHPUnit for testing. Write tests in the tests/ directory. Follow the Arrange-Act-Assert pattern. Aim for at least 80% code coverage for new features. Run tests with `php artisan test`.',
                'created_by' => $devLead->id,
                'team_id' => $devTeam->id,
            ],
            [
                'question' => 'What is the process for code reviews?',
                'answer' => '1. Create a feature branch, 2. Make your changes and commit, 3. Push to remote and create a pull request, 4. Request review from your team lead, 5. Address any feedback, 6. Once approved, merge to develop. All code must be reviewed before merging.',
                'created_by' => $devLead->id,
                'team_id' => $devTeam->id,
            ],
        ];

        // DevOps Team Questions
        $devOpsTeamQuestions = [
            [
                'question' => 'How do I deploy using Docker?',
                'answer' => 'Use Docker Compose to build and run containers. Check the DevOps onboarding goals for detailed Docker tutorials and best practices. Make sure you have Docker Desktop installed and configured properly.',
                'created_by' => $devOpsLead->id,
                'team_id' => $devOpsTeam->id,
            ],
            [
                'question' => 'How do I set up a Kubernetes cluster locally?',
                'answer' => 'Use Minikube or Docker Desktop Kubernetes for local development. Install kubectl and configure it. Run `minikube start` or enable Kubernetes in Docker Desktop. Check the onboarding goals for step-by-step instructions.',
                'created_by' => $devOpsLead->id,
                'team_id' => $devOpsTeam->id,
            ],
            [
                'question' => 'What is our CI/CD pipeline setup?',
                'answer' => 'We use GitHub Actions for CI/CD. The pipeline runs tests, builds Docker images, and deploys to staging automatically. Production deployments require manual approval. Check the .github/workflows directory for pipeline configurations.',
                'created_by' => $devOpsLead->id,
                'team_id' => $devOpsTeam->id,
            ],
            [
                'question' => 'How do I monitor application performance?',
                'answer' => 'We use monitoring tools like Prometheus and Grafana. Access dashboards through the team portal. Set up alerts for critical metrics. Contact your team lead for access credentials and training on using these tools.',
                'created_by' => $devOpsLead->id,
                'team_id' => $devOpsTeam->id,
            ],
            [
                'question' => 'How do I manage secrets and environment variables?',
                'answer' => 'Never commit secrets to Git. Use environment variables in .env files for local development. For production, use our secret management system. Contact your team lead to add or update secrets. Follow the principle of least privilege.',
                'created_by' => $devOpsLead->id,
                'team_id' => $devOpsTeam->id,
            ],
            [
                'question' => 'What backup and disaster recovery procedures do we have?',
                'answer' => 'We perform daily automated backups of databases and critical files. Backups are retained for 30 days. Disaster recovery procedures are documented in the team wiki. In case of an incident, contact your team lead immediately.',
                'created_by' => $devOpsLead->id,
                'team_id' => $devOpsTeam->id,
            ],
            [
                'question' => 'How do I troubleshoot deployment issues?',
                'answer' => '1. Check deployment logs in the CI/CD dashboard, 2. Verify environment variables are set correctly, 3. Check container health and resource usage, 4. Review recent changes in the deployment, 5. Contact your team lead if issues persist. Always document the issue and solution.',
                'created_by' => $devOpsLead->id,
                'team_id' => $devOpsTeam->id,
            ],
            [
                'question' => 'What infrastructure as code tools do we use?',
                'answer' => 'We use Terraform for infrastructure provisioning and Ansible for configuration management. Infrastructure definitions are version-controlled in Git. Never make manual changes to production infrastructure - always use IaC.',
                'created_by' => $devOpsLead->id,
                'team_id' => $devOpsTeam->id,
            ],
        ];

        // Combine all questions
        $allQuestions = array_merge($globalQuestions, $devTeamQuestions, $devOpsTeamQuestions);

        foreach ($allQuestions as $questionData) {
            Question::firstOrCreate(
                [
                    'question' => $questionData['question'],
                    'created_by' => $questionData['created_by'],
                ],
                $questionData
            );
        }
    }
}
