<?php

namespace Database\Seeders;

use App\Models\Roadmap;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DevOpsBasicsRoadmapSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@roadmap.camp')->first();
        $phase5 = Roadmap::where('slug', 'phase-5-backend-intermediate')->first();

        $roadmap = Roadmap::create([
            'creator_id' => $admin->id ?? null,
            'title' => 'DevOps Basics',
            'description' => 'Learn essential DevOps tools and practices: Git, Linux, servers, and deployment fundamentals.',
            'slug' => 'phase-6-devops-basics',
            'duration_days' => 6,
            'difficulty_level' => 'intermediate',
            'is_published' => true,
            'is_featured' => false,
            'order' => 8,
            'prerequisite_roadmap_id' => $phase5->id ?? null,
        ]);

        $this->createTasks($roadmap);
    }

    protected function createTasks(Roadmap $roadmap): void
    {
        $tasks = [
            [
                'title' => 'Git Fundamentals',
                'description' => 'Master Git fundamentals: commits, branches, merging, rebasing, stashing, and resolving conflicts.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'DevOps',
                'learning_objectives' => [],
                'skills_gained' => ['Git Version Control', 'Branch Management', 'Conflict Resolution'],
                'tags' => ['git', 'version-control', 'devops'],
                'success_criteria' => [],
                'has_code_submission' => false,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=SWYqp7iY_Tc', 'title' => 'Traversy Media - Git & GitHub Crash Course', 'type' => 'video'],
                    ['url' => 'https://git-scm.com/doc', 'title' => 'Git Documentation', 'type' => 'article'],
                    ['url' => 'https://atlassian.com/git/tutorials', 'title' => 'Git Tutorial - Atlassian', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Pro Git by Scott Chacon (Free Online)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Version Control with Git O\'Reilly', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'Git Branching Strategies',
                'description' => 'Learn professional Git workflows: Git Flow, GitHub Flow, trunk-based development, and team collaboration.',
                'estimated_time_minutes' => 90,
                'task_type' => 'video',
                'category' => 'DevOps',
                'learning_objectives' => [],
                'skills_gained' => ['Git Workflows', 'Team Collaboration', 'Pull Requests'],
                'tags' => ['git', 'workflow', 'collaboration', 'pr'],
                'success_criteria' => [],
                'has_code_submission' => false,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=1SXpE08hvGs', 'title' => 'Git Flow Tutorial', 'type' => 'video'],
                    ['url' => 'https://atlassian.com/git/tutorials/comparing-workflows/gitflow-workflow', 'title' => 'Git Flow - Atlassian', 'type' => 'article'],
                    ['url' => 'https://trunkbaseddevelopment.com/', 'title' => 'Trunk Based Development', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Pro Git (Chapter 3)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Git Essentials', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'Linux Basics for Developers',
                'description' => 'Master Linux terminal: navigation, file operations, permissions, process management, and shell scripting basics.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'DevOps',
                'learning_objectives' => [],
                'skills_gained' => ['Linux CLI', 'Shell Scripting', 'System Administration'],
                'tags' => ['linux', 'cli', 'terminal', 'bash'],
                'success_criteria' => [],
                'has_code_submission' => false,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=sWbUDq4S6Y8', 'title' => 'freeCodeCamp - Linux for Beginners', 'type' => 'video'],
                    ['url' => 'https://linuxjourney.com/', 'title' => 'Linux Journey', 'type' => 'article'],
                    ['url' => 'https://tutorialspoint.com/unix/index.htm', 'title' => 'Linux Tutorial - Tutorialspoint', 'type' => 'article'],
                    ['url' => '#', 'title' => 'The Linux Command Line by William Shotts', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Linux Basics for Hackers', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'SSH & Server Access',
                'description' => 'Learn secure shell (SSH): connecting to remote servers, SSH keys, SCP/SFTP, and secure server management.',
                'estimated_time_minutes' => 88,
                'task_type' => 'video',
                'category' => 'DevOps',
                'learning_objectives' => [],
                'skills_gained' => ['SSH Protocol', 'Remote Server Management', 'Server Security'],
                'tags' => ['ssh', 'security', 'remote-access', 'devops'],
                'success_criteria' => [],
                'has_code_submission' => false,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=YS5Zh7KExvE', 'title' => 'LearnLinuxTV - SSH Tutorial', 'type' => 'video'],
                    ['url' => 'https://digitalocean.com/community/tutorials/ssh-essentials-working-with-ssh-servers-clients-and-keys', 'title' => 'SSH Guide - DigitalOcean', 'type' => 'article'],
                    ['url' => 'https://openssh.com/manual.html', 'title' => 'OpenSSH Manual', 'type' => 'article'],
                    ['url' => '#', 'title' => 'SSH Mastery by Michael Lucas', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Linux Server Security (SSH Chapter)', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'Web Servers (Nginx/Apache)',
                'description' => 'Set up and configure web servers: Nginx and Apache installation, virtual hosts, SSL/TLS, and performance tuning.',
                'estimated_time_minutes' => 31,
                'task_type' => 'video',
                'category' => 'DevOps',
                'learning_objectives' => [],
                'skills_gained' => ['Web Server Configuration', 'SSL/TLS Setup', 'Server Optimization'],
                'tags' => ['nginx', 'apache', 'web-server', 'ssl'],
                'success_criteria' => [],
                'has_code_submission' => false,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=7VAI73roXaY', 'title' => 'Traversy Media - Nginx Crash Course', 'type' => 'video'],
                    ['url' => 'https://nginx.org/en/docs/', 'title' => 'Nginx Documentation', 'type' => 'article'],
                    ['url' => 'https://digitalocean.com/community/tutorial-series/apache-basics', 'title' => 'Apache Guide - DigitalOcean', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Nginx HTTP Server by Clement Nedelcu', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Apache Cookbook O\'Reilly', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'Environment Configuration',
                'description' => 'Learn deployment basics: environment variables, .env files, server provisioning, and basic deployment workflows.',
                'estimated_time_minutes' => 29,
                'task_type' => 'video',
                'category' => 'DevOps',
                'learning_objectives' => [],
                'skills_gained' => ['Deployment', 'Environment Management', 'Server Provisioning'],
                'tags' => ['deployment', 'environment', 'devops', 'production'],
                'success_criteria' => [],
                'has_code_submission' => false,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=5iWhQWVXosU', 'title' => 'TechWorld with Nana - Environment Variables', 'type' => 'video'],
                    ['url' => 'https://12factor.net/config', 'title' => '12 Factor App - Config', 'type' => 'article'],
                    ['url' => 'https://laravel.com/docs/configuration', 'title' => 'Laravel Configuration - Docs', 'type' => 'article'],
                    ['url' => '#', 'title' => 'The Twelve-Factor App (Free Online)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Continuous Delivery (Chapter 2)', 'type' => 'book'],
                ],
            ],
        ];

        $dayNumber = 1;
        foreach ($tasks as $taskData) {
            Task::create(array_merge($taskData, [
                'roadmap_id' => $roadmap->id,
                'day_number' => $dayNumber++,
                'order' => 1,
                'difficulty_level' => 'intermediate',
                'has_quality_rating' => false,
            ]));
        }
    }
}
