<?php

namespace Database\Seeders;

use App\Models\Roadmap;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class BackendProjectsSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@roadmap.camp')->first();
        $backendIntermediate = Roadmap::where('slug', 'phase-5-backend-intermediate')->first();

        $roadmap = Roadmap::create([
            'creator_id' => $admin->id ?? 1,
            'title' => 'Backend Projects Portfolio',
            'description' => 'Build real-world backend projects using PHP, Laravel, and MySQL to master server-side development. Create APIs, work with databases, implement authentication, and deploy production-ready applications.',
            'slug' => 'backend-projects',
            'duration_days' => 10,
            'difficulty_level' => 'intermediate',
            'is_published' => true,
            'is_featured' => false,
            'order' => 7,
            'prerequisite_roadmap_id' => $backendIntermediate->id ?? null,
        ]);

        $this->createTasks($roadmap);
    }

    protected function createTasks(Roadmap $roadmap): void
    {
        $tasks = [
            [
                'title' => 'Project 1: REST API for Todo App (Laravel)',
                'description' => 'Build a complete REST API for a todo application using Laravel with CRUD operations, validation, MySQL database, and proper error handling.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Backend Projects',
                'learning_objectives' => [],
                'skills_gained' => ['Laravel REST API', 'Eloquent ORM', 'MySQL', 'API Resources'],
                'tags' => ['laravel', 'api', 'rest', 'crud', 'mysql'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=qJLiXD4RPug', 'title' => 'Laravel REST API Tutorial', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/eloquent-resources', 'title' => 'Laravel API Resources', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Project 2: Authentication System (Laravel Sanctum)',
                'description' => 'Implement a complete authentication system using Laravel Sanctum with user registration, login, API tokens, password hashing, and protected routes.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Backend Projects',
                'learning_objectives' => [],
                'skills_gained' => ['Laravel Sanctum', 'API Authentication', 'Security', 'Middleware'],
                'tags' => ['laravel', 'auth', 'sanctum', 'security', 'api'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=TzAJfjCn7Ks', 'title' => 'Laravel Sanctum Authentication', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/sanctum', 'title' => 'Laravel Sanctum Documentation', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Project 3: Blog API with Relationships (Laravel + MySQL)',
                'description' => 'Create a blog API with posts, comments, categories using Eloquent relationships. Implement pagination, eager loading, and search functionality.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Backend Projects',
                'learning_objectives' => [],
                'skills_gained' => ['Eloquent Relationships', 'Pagination', 'Query Optimization', 'MySQL'],
                'tags' => ['laravel', 'eloquent', 'relations', 'mysql', 'pagination'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=ImtZ5yENzgE', 'title' => 'Laravel Relationships Tutorial', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/eloquent-relationships', 'title' => 'Eloquent Relationships', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Project 4: File Upload Service (Laravel + Cloud Storage)',
                'description' => 'Build a file upload service using Laravel that handles image uploads, validation, storage in filesystem/cloud (S3), and image manipulation.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Backend Projects',
                'learning_objectives' => [],
                'skills_gained' => ['File Handling', 'Laravel Storage', 'Image Manipulation', 'Validation'],
                'tags' => ['laravel', 'upload', 'files', 'storage', 's3'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=LZw_E19-Bos', 'title' => 'Laravel File Upload Tutorial', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/filesystem', 'title' => 'Laravel File Storage', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Project 5: E-commerce API (Laravel + MySQL)',
                'description' => 'Create an e-commerce API with products, shopping cart, orders using Laravel and MySQL. Implement cart logic and order management.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Backend Projects',
                'learning_objectives' => [],
                'skills_gained' => ['E-commerce', 'Cart Logic', 'Order Management', 'MySQL Transactions'],
                'tags' => ['laravel', 'e-commerce', 'cart', 'orders', 'mysql'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=4gKkR3mZQeM', 'title' => 'Laravel E-commerce API', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/database', 'title' => 'Laravel Database', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Project 6: Email Service with Queues (Laravel)',
                'description' => 'Implement an email service using Laravel Mailtrap/SMTP with job queues for sending emails asynchronously in background.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Backend Projects',
                'learning_objectives' => [],
                'skills_gained' => ['Laravel Mail', 'Job Queues', 'Async Processing', 'Queue Workers'],
                'tags' => ['laravel', 'email', 'queue', 'jobs', 'mailtrap'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=rJTb5zF6mDg', 'title' => 'Laravel Queues Tutorial', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/queues', 'title' => 'Laravel Queues Documentation', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Project 7: User Roles & Permissions (Laravel)',
                'description' => 'Build a role-based access control (RBAC) system with user roles, permissions, and authorization using Laravel policies and gates.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Backend Projects',
                'learning_objectives' => [],
                'skills_gained' => ['Authorization', 'Laravel Policies', 'RBAC', 'Security'],
                'tags' => ['laravel', 'roles', 'permissions', 'authorization', 'rbac'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=kZOgH3-0Bko', 'title' => 'Laravel Roles & Permissions', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/authorization', 'title' => 'Laravel Authorization', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Project 8: API Rate Limiting & Caching (Laravel)',
                'description' => 'Implement API rate limiting and caching strategies using Laravel throttle middleware and cache facade for performance optimization.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Backend Projects',
                'learning_objectives' => [],
                'skills_gained' => ['Rate Limiting', 'Caching', 'Performance', 'Laravel Cache'],
                'tags' => ['laravel', 'rate-limiting', 'cache', 'performance', 'optimization'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=6pNvPV9a3Xc', 'title' => 'Laravel Caching Tutorial', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/cache', 'title' => 'Laravel Cache Documentation', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Project 9: Database Seeding & Factories (Laravel)',
                'description' => 'Create comprehensive database seeders and factories for testing. Generate fake data using Faker and implement testing best practices.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Backend Projects',
                'learning_objectives' => [],
                'skills_gained' => ['Database Seeding', 'Factories', 'Faker', 'Testing Data'],
                'tags' => ['laravel', 'seeders', 'factories', 'faker', 'testing'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=MHBDUJ51Pqs', 'title' => 'Laravel Seeders & Factories', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/seeding', 'title' => 'Database Seeding', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Project 10: API Testing with PHPUnit (Laravel)',
                'description' => 'Write comprehensive API tests using PHPUnit and Laravel testing helpers. Test endpoints, authentication, and database interactions.',
                'estimated_time_minutes' => 120,
                'task_type' => 'project',
                'category' => 'Backend Projects',
                'learning_objectives' => [],
                'skills_gained' => ['API Testing', 'PHPUnit', 'Laravel Testing', 'Test Coverage'],
                'tags' => ['laravel', 'testing', 'phpunit', 'api-tests', 'coverage'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=I7sLWRhROl0', 'title' => 'Laravel Testing Tutorial', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/testing', 'title' => 'Laravel Testing Documentation', 'type' => 'article'],
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
                'has_code_submission' => $taskData['has_code_submission'] ?? false,
                'has_quality_rating' => true,
            ]));
        }
    }
}
