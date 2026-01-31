<?php

namespace Database\Seeders;

use App\Models\Roadmap;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class BackendBasicsRoadmapSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@roadmap.camp')->first();

        $roadmap = Roadmap::create([
            'creator_id' => $admin->id ?? 1,
            'title' => 'Backend Basics',
            'description' => 'Master backend development fundamentals: PHP, Laravel, databases, APIs, and server concepts.',
            'slug' => 'backend-basics',
            'duration_days' => 14,
            'difficulty_level' => 'intermediate',
            'is_published' => true,
            'is_featured' => false,
            'order' => 6,
            'prerequisite_roadmap_id' => null,
        ]);

        $this->createTasks($roadmap);
    }

    protected function createTasks(Roadmap $roadmap): void
    {
        $tasks = [
            [
                'title' => 'Server Concepts & HTTP Protocol',
                'description' => 'Understand server fundamentals, HTTP request/response cycle, RESTful API principles, and client-server architecture.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Backend',
                'learning_objectives' => [],
                'skills_gained' => ['Server Concepts', 'HTTP', 'REST APIs'],
                'tags' => ['backend', 'http', 'api', 'server'],
                'success_criteria' => [],
                'has_code_submission' => false,
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=0OrmKCB0UrQ', 'title' => 'HTTP Crash Course - Hussein Nasser', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=iYM2zFP3Zn0', 'title' => 'REST API Concepts - Telusko', 'type' => 'video'],
                    ['url' => 'https://developer.mozilla.org/en-US/docs/Web/HTTP', 'title' => 'HTTP Overview - MDN', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'PHP Fundamentals',
                'description' => 'Master PHP basics: syntax, variables, data types, operators, control structures, functions, and arrays.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'PHP',
                'learning_objectives' => [],
                'skills_gained' => ['PHP', 'Server-Side Programming', 'Web Development'],
                'tags' => ['php', 'backend', 'programming'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=BUCiSSyIGGU', 'title' => 'PHP Crash Course - Traversy Media', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=a7_WFUlFS94', 'title' => 'PHP for Beginners - Program With Gio', 'type' => 'video'],
                    ['url' => 'https://php.net/manual/en/', 'title' => 'PHP Documentation', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'PHP OOP & Modern PHP',
                'description' => 'Master object-oriented programming in PHP: classes, objects, inheritance, polymorphism, and modern PHP features.',
                'estimated_time_minutes' => 90,
                'task_type' => 'video',
                'category' => 'PHP',
                'learning_objectives' => [],
                'skills_gained' => ['PHP OOP', 'Object-Oriented Programming', 'Design Patterns'],
                'tags' => ['php', 'oop', 'classes', 'objects'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=Anz0ArcQ5kI', 'title' => 'PHP OOP - Traversy Media', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=ET4k1KYadFw', 'title' => 'PHP OOP Full Course - Dani Krossing', 'type' => 'video'],
                    ['url' => 'https://php.net/manual/en/language.oop5.php', 'title' => 'PHP OOP Documentation', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Composer & Dependency Management',
                'description' => 'Learn Composer for PHP dependency management, autoloading, package installation, and creating composer.json files.',
                'estimated_time_minutes' => 0,
                'task_type' => 'video',
                'category' => 'PHP',
                'learning_objectives' => [],
                'skills_gained' => ['Composer', 'Dependency Management', 'Autoloading', 'Packages'],
                'tags' => ['php', 'composer', 'packages', 'dependencies'],
                'success_criteria' => [],
                'has_code_submission' => false,
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=R_nEccSu_sI', 'title' => 'PHP Composer Tutorial - The Net Ninja', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=vLW2C8oC0I0', 'title' => 'Composer Crash Course - Traversy Media', 'type' => 'video'],
                    ['url' => 'https://getcomposer.org/doc/', 'title' => 'Composer Documentation', 'type' => 'article'],
                    ['url' => 'https://packagist.org/', 'title' => 'Packagist - PHP Package Repository', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Laravel Fundamentals & MVC',
                'description' => 'Learn Laravel framework basics: installation, MVC architecture, Artisan, routing, and application structure.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Laravel',
                'learning_objectives' => [],
                'skills_gained' => ['Laravel', 'MVC', 'Framework', 'Artisan'],
                'tags' => ['laravel', 'php', 'framework', 'mvc'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=MFh0Fd7BsjE', 'title' => 'Laravel Crash Course - Traversy Media', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=MYyJ4PuL4pY', 'title' => 'Laravel for Beginners - freeCodeCamp', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/11.x', 'title' => 'Laravel Documentation', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Laravel Blade Templating',
                'description' => 'Master Blade templating engine: layouts, components, directives, template inheritance, and dynamic content rendering.',
                'estimated_time_minutes' => 90,
                'task_type' => 'video',
                'category' => 'Laravel',
                'learning_objectives' => [],
                'skills_gained' => ['Blade Templates', 'Template Engine', 'Views', 'Components'],
                'tags' => ['laravel', 'blade', 'templates', 'views'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=jG_xUeQ0Xo8', 'title' => 'Laravel Blade Components - Laravel Daily', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=z50jPelc3xw', 'title' => 'Blade Templating in Laravel - The Codeholic', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/11.x/blade', 'title' => 'Blade Templates - Laravel Docs', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Database Basics & SQL',
                'description' => 'Learn database fundamentals, SQL queries, CRUD operations, joins, and database design principles.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Database',
                'learning_objectives' => [],
                'skills_gained' => ['SQL', 'Database Design', 'MySQL', 'CRUD'],
                'tags' => ['database', 'sql', 'mysql', 'backend'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=HXV3zeQKqGY', 'title' => 'SQL Tutorial - freeCodeCamp', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=zsjvFFKOm3c', 'title' => 'Database Design - freeCodeCamp', 'type' => 'video'],
                    ['url' => 'https://dev.mysql.com/doc/', 'title' => 'MySQL Documentation', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Laravel Migrations & Schema Builder',
                'description' => 'Master database migrations: creating tables, modifying schema, rolling back changes, and version control for databases.',
                'estimated_time_minutes' => 90,
                'task_type' => 'video',
                'category' => 'Laravel',
                'learning_objectives' => [],
                'skills_gained' => ['Migrations', 'Schema Builder', 'Database Version Control'],
                'tags' => ['laravel', 'migrations', 'database', 'schema'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=JhKngeE0XJA', 'title' => 'Laravel Migrations - Code With Dary', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/11.x/migrations', 'title' => 'Migrations - Laravel Docs', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Laravel Eloquent ORM Basics',
                'description' => 'Master Laravel Eloquent ORM: models, basic queries, mass assignment, and database interactions.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Laravel',
                'learning_objectives' => [],
                'skills_gained' => ['Eloquent ORM', 'Database Models', 'Active Record'],
                'tags' => ['laravel', 'eloquent', 'orm', 'database'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=ImtZ5yENzgE', 'title' => 'Laravel Eloquent - Traversy Media', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/11.x/eloquent', 'title' => 'Eloquent ORM - Laravel Docs', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Eloquent Relationships',
                'description' => 'Master Eloquent relationships: one-to-one, one-to-many, many-to-many, polymorphic relationships, and eager loading.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Laravel',
                'learning_objectives' => [],
                'skills_gained' => ['Eloquent Relationships', 'Database Relations', 'Eager Loading'],
                'tags' => ['laravel', 'eloquent', 'relationships', 'database'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=1aXZrY15chg', 'title' => 'Laravel Relationships - Code With Dary', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/11.x/eloquent-relationships', 'title' => 'Eloquent Relationships - Laravel Docs', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Laravel Seeders & Factories',
                'description' => 'Learn database seeding, factories for test data generation, and populating databases with sample data.',
                'estimated_time_minutes' => 90,
                'task_type' => 'video',
                'category' => 'Laravel',
                'learning_objectives' => [],
                'skills_gained' => ['Database Seeding', 'Factories', 'Test Data'],
                'tags' => ['laravel', 'seeders', 'factories', 'database'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=MHBDUJ51Pqs', 'title' => 'Laravel Seeders & Factories - Code With Dary', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/11.x/seeding', 'title' => 'Database Seeding - Laravel Docs', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Laravel Form Validation',
                'description' => 'Master form validation: validation rules, custom rules, error messages, and form request validation.',
                'estimated_time_minutes' => 90,
                'task_type' => 'video',
                'category' => 'Laravel',
                'learning_objectives' => [],
                'skills_gained' => ['Form Validation', 'Validation Rules', 'Error Handling'],
                'tags' => ['laravel', 'validation', 'forms', 'security'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=rHFVGIH1djo', 'title' => 'Laravel Form Validation - Laravel Daily', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=RJy8kJR1Qjw', 'title' => 'Laravel Validation Tutorial - The Codeholic', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/11.x/validation', 'title' => 'Validation - Laravel Docs', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'RESTful APIs with Laravel',
                'description' => 'Build RESTful APIs with Laravel: API routes, controllers, JSON responses, and API resource transformers.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Laravel',
                'learning_objectives' => [],
                'skills_gained' => ['REST API', 'Laravel API', 'JSON', 'API Resources'],
                'tags' => ['laravel', 'api', 'rest', 'backend'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=YGqCZjdgJJk', 'title' => 'Laravel REST API - Traversy Media', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=xvqPEEpRBJ4', 'title' => 'Laravel API - freeCodeCamp', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/11.x/eloquent-resources', 'title' => 'API Resources - Laravel Docs', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Authentication & Authorization',
                'description' => 'Implement user authentication, registration, login, password reset, and basic authorization in Laravel.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Laravel',
                'learning_objectives' => [],
                'skills_gained' => ['Authentication', 'Authorization', 'Security', 'User Management'],
                'tags' => ['laravel', 'auth', 'security', 'users'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=rQkp9wISMyE', 'title' => 'Laravel Authentication - The Codeholic', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=L0kHCpRLDfI', 'title' => 'Laravel Auth Tutorial - Andrew Schmelyun', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/11.x/authentication', 'title' => 'Authentication - Laravel Docs', 'type' => 'article'],
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
                'has_quality_rating' => true,
            ]));
        }
    }
}
