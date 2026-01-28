<?php

namespace Database\Seeders;

use App\Models\Roadmap;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class BackendIntermediateRoadmapSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@roadmap.camp')->first();
        $phase4 = Roadmap::where('slug', 'phase-4-backend-basics')->first();

        $roadmap = Roadmap::create([
            'creator_id' => $admin->id ?? null,
            'title' => 'Phase 5: Backend Intermediate',
            'description' => 'Master intermediate Laravel concepts: Eloquent ORM, migrations, authentication, API development, and security.',
            'slug' => 'phase-5-backend-intermediate',
            'duration_days' => 5,
            'difficulty_level' => 'intermediate',
            'is_published' => true,
            'is_featured' => false,
            'order' => 7,
            'prerequisite_roadmap_id' => $phase4->id ?? null,
        ]);

        $this->createTasks($roadmap);
    }

    protected function createTasks(Roadmap $roadmap): void
    {
        $tasks = [
            [
                'title' => 'Eloquent ORM',
                'description' => 'Master Laravel Eloquent: models, relationships (one-to-one, one-to-many, many-to-many), eager loading, and query scopes.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Laravel',
                'learning_objectives' => ['Create Eloquent models', 'Define relationships', 'Use eager loading'],
                'skills_gained' => ['Eloquent ORM', 'Database Relationships', 'Query Optimization'],
                'tags' => ['laravel', 'eloquent', 'orm', 'relationships'],
                'success_criteria' => ['Can define relationships', 'Understands eager loading', 'Can create scopes'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=ImtZ5yENzgE', 'title' => 'Traversy Media - Eloquent ORM', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/eloquent', 'title' => 'Eloquent - Laravel Docs', 'type' => 'article'],
                    ['url' => 'https://laravel.com/docs/eloquent-relationships', 'title' => 'Eloquent Relationships', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Laravel: Up & Running (Chapter 5)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Mastering Laravel (Chapters 3-4)', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'Laravel Migrations & Seeders',
                'description' => 'Learn database migrations for version control, seeders for test data, and factories for model generation.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Laravel',
                'learning_objectives' => ['Create migrations', 'Use seeders', 'Build factories'],
                'skills_gained' => ['Database Migrations', 'Data Seeding', 'Schema Management'],
                'tags' => ['laravel', 'migrations', 'seeders', 'factories'],
                'success_criteria' => ['Can create migrations', 'Understands rollback', 'Can seed data'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=MFh0Fd7BsjE&t=5000s', 'title' => 'Traversy Media - Laravel Crash Course (Migrations Section)', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/migrations', 'title' => 'Migrations - Laravel Docs', 'type' => 'article'],
                    ['url' => 'https://laravel.com/docs/seeding', 'title' => 'Seeding - Laravel Docs', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Laravel: Up & Running (Chapter 5)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Beginning Laravel (Chapter 4)', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'Authentication (Sessions, JWT, Sanctum)',
                'description' => 'Implement user authentication, authorization, gates, policies, and role-based access control (RBAC).',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Laravel',
                'learning_objectives' => ['Implement authentication', 'Use gates and policies', 'Create RBAC'],
                'skills_gained' => ['Authentication', 'Authorization', 'RBAC', 'Security'],
                'tags' => ['laravel', 'authentication', 'authorization', 'security'],
                'success_criteria' => ['Can implement auth', 'Understands gates vs policies', 'Can create RBAC'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=MFh0Fd7BsjE&t=2000s', 'title' => 'Traversy Media - Laravel Auth', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/authentication', 'title' => 'Authentication - Laravel Docs', 'type' => 'article'],
                    ['url' => 'https://laravel.com/docs/sanctum', 'title' => 'Laravel Sanctum - Laravel Docs', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Laravel: Up & Running (Chapter 9)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Web Security for Developers (Chapters 6-8)', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'Laravel API Development',
                'description' => 'Build RESTful APIs: API resources, authentication with Sanctum/Passport, versioning, and API documentation.',
                'estimated_time_minutes' => 59,
                'task_type' => 'video',
                'category' => 'Laravel',
                'learning_objectives' => ['Create API endpoints', 'Use API resources', 'Implement token auth'],
                'skills_gained' => ['REST API Development', 'Laravel Sanctum', 'API Resources', 'API Documentation'],
                'tags' => ['laravel', 'api', 'rest', 'sanctum'],
                'success_criteria' => ['Can build CRUD APIs', 'Understands API resources', 'Can implement API auth'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=mgdMeXkviy8', 'title' => 'Traversy Media - Laravel API', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/eloquent-resources', 'title' => 'API Resources - Laravel Docs', 'type' => 'article'],
                    ['url' => 'https://freecodecamp.org/news/rest-api-design-best-practices-build-a-rest-api/', 'title' => 'API Versioning Best Practices', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Build APIs You Won\'t Hate', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Laravel API Development', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'Validation & Security',
                'description' => 'Master form validation, request validation, CSRF protection, XSS prevention, SQL injection prevention, and security headers.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Laravel',
                'learning_objectives' => ['Implement validation', 'Use form requests', 'Prevent CSRF'],
                'skills_gained' => ['Input Validation', 'Web Security', 'CSRF Protection', 'XSS Prevention'],
                'tags' => ['laravel', 'validation', 'security', 'csrf'],
                'success_criteria' => ['Can create validation rules', 'Understands OWASP top 10', 'Can secure apps'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=F-sFp_AvHc8', 'title' => 'freeCodeCamp - Web Security', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/validation', 'title' => 'Validation - Laravel Docs', 'type' => 'article'],
                    ['url' => 'https://owasp.org/www-project-top-ten/', 'title' => 'OWASP Top 10', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Web Application Security by Andrew Hoffman', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Laravel Security', 'type' => 'book'],
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
