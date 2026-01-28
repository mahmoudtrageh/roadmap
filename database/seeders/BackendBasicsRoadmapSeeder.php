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
        $phase3 = Roadmap::where('slug', 'phase-3-frontend-intermediate')->first();

        $roadmap = Roadmap::create([
            'creator_id' => $admin->id ?? null,
            'title' => 'Phase 4: Backend Basics',
            'description' => 'Learn server concepts, REST APIs, PHP fundamentals, OOP, Laravel basics, routing, controllers, Blade templates, SQL, and database design.',
            'slug' => 'phase-4-backend-basics',
            'duration_days' => 8,
            'difficulty_level' => 'intermediate',
            'is_published' => true,
            'is_featured' => false,
            'order' => 6,
            'prerequisite_roadmap_id' => $phase3->id ?? null,
        ]);

        $this->createTasks($roadmap);
    }

    protected function createTasks(Roadmap $roadmap): void
    {
        $tasks = [
            [
                'title' => 'Server Concepts (Request/Response, REST)',
                'description' => 'Understand server fundamentals, HTTP request/response cycle, RESTful API principles, and client-server architecture.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Backend',
                'learning_objectives' => ['Understand client-server model', 'Learn REST principles', 'Grasp HTTP request/response'],
                'skills_gained' => ['Server Concepts', 'REST APIs', 'HTTP'],
                'tags' => ['backend', 'rest', 'api', 'server'],
                'success_criteria' => ['Can explain REST principles', 'Understands request/response cycle', 'Can design RESTful APIs'],
                'has_code_submission' => false,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=GZvSYJDk-us', 'title' => 'freeCodeCamp - APIs and REST', 'type' => 'video'],
                    ['url' => 'https://restfulapi.net/', 'title' => 'REST API Tutorial', 'type' => 'article'],
                    ['url' => 'https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods', 'title' => 'HTTP Methods - MDN', 'type' => 'article'],
                    ['url' => '#', 'title' => 'RESTful Web Services by Leonard Richardson', 'type' => 'book'],
                    ['url' => '#', 'title' => 'REST API Design Rulebook', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'PHP Fundamentals',
                'description' => 'Master PHP basics: syntax, variables, data types, operators, control structures, functions, and arrays.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'PHP',
                'learning_objectives' => ['Master PHP syntax', 'Work with PHP data types', 'Build PHP applications'],
                'skills_gained' => ['PHP', 'Server-Side Programming', 'Web Development'],
                'tags' => ['php', 'backend', 'programming'],
                'success_criteria' => ['Can write PHP code', 'Understands PHP fundamentals', 'Can build basic PHP apps'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=BUCiSSyIGGU', 'title' => 'Traversy Media - PHP Crash Course', 'type' => 'video'],
                    ['url' => 'https://php.net/manual/en/', 'title' => 'PHP Documentation', 'type' => 'article'],
                    ['url' => 'https://w3schools.com/php/', 'title' => 'PHP Tutorial - W3Schools', 'type' => 'article'],
                    ['url' => '#', 'title' => 'PHP & MySQL: Novice to Ninja', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Modern PHP by Josh Lockhart', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'PHP OOP',
                'description' => 'Master object-oriented programming in PHP: classes, objects, inheritance, polymorphism, and design patterns.',
                'estimated_time_minutes' => 30,
                'task_type' => 'video',
                'category' => 'PHP',
                'learning_objectives' => ['Master PHP OOP concepts', 'Use classes and objects', 'Implement inheritance'],
                'skills_gained' => ['PHP OOP', 'Object-Oriented Programming', 'Design Patterns'],
                'tags' => ['php', 'oop', 'classes', 'objects'],
                'success_criteria' => ['Can create classes', 'Understands OOP principles', 'Can use inheritance'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=Anz0ArcQ5kI', 'title' => 'Traversy Media - PHP OOP', 'type' => 'video'],
                    ['url' => 'https://php.net/manual/en/language.oop5.php', 'title' => 'PHP OOP - PHP.net', 'type' => 'article'],
                    ['url' => 'https://tutorialspoint.com/php/php_object_oriented.htm', 'title' => 'OOP in PHP - Tutorialspoint', 'type' => 'article'],
                    ['url' => '#', 'title' => 'PHP Objects, Patterns, and Practice', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Object-Oriented PHP by Peter Lavin', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'Laravel Fundamentals',
                'description' => 'Learn Laravel framework basics: installation, MVC architecture, Artisan, and application structure.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Laravel',
                'learning_objectives' => ['Set up Laravel', 'Understand MVC pattern', 'Use Artisan commands'],
                'skills_gained' => ['Laravel', 'MVC', 'Framework', 'Artisan'],
                'tags' => ['laravel', 'php', 'framework', 'mvc'],
                'success_criteria' => ['Can create Laravel apps', 'Understands MVC', 'Can use Artisan'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=MFh0Fd7BsjE', 'title' => 'Traversy Media - Laravel Crash Course', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs', 'title' => 'Laravel Documentation', 'type' => 'article'],
                    ['url' => 'https://tutorialspoint.com/laravel/index.htm', 'title' => 'Laravel Tutorial - Tutorialspoint', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Laravel: Up & Running by Matt Stauffer', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Laravel Design Patterns', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'Laravel Routing & Controllers',
                'description' => 'Master Laravel routing, route parameters, route groups, controllers, and resource controllers.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Laravel',
                'learning_objectives' => ['Define routes', 'Create controllers', 'Use route parameters'],
                'skills_gained' => ['Laravel Routing', 'Controllers', 'RESTful Routes'],
                'tags' => ['laravel', 'routing', 'controllers', 'mvc'],
                'success_criteria' => ['Can define routes', 'Can create controllers', 'Can use resource controllers'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=ImtZ5yENzgE', 'title' => 'Traversy Media - Laravel Controllers', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/routing', 'title' => 'Routing - Laravel Docs', 'type' => 'article'],
                    ['url' => 'https://laravel.com/docs/controllers', 'title' => 'Controllers - Laravel Docs', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Laravel: Up & Running (Chapters 3-4)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Beginning Laravel by Sanjib Sinha', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'Blade Templates',
                'description' => 'Learn Laravel Blade templating engine: syntax, directives, layouts, components, and template inheritance.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Laravel',
                'learning_objectives' => ['Use Blade syntax', 'Create layouts', 'Build components'],
                'skills_gained' => ['Blade', 'Templating', 'Views', 'Components'],
                'tags' => ['laravel', 'blade', 'templates', 'views'],
                'success_criteria' => ['Can use Blade directives', 'Can create layouts', 'Can build components'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=MFh0Fd7BsjE&t=3600s', 'title' => 'Traversy Media - Laravel Crash Course (Blade Section)', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/blade', 'title' => 'Blade Templates - Laravel Docs', 'type' => 'article'],
                    ['url' => 'https://digitalocean.com/community/tutorials/laravel-blade-tutorial', 'title' => 'Blade Tutorial - DigitalOcean', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Laravel: Up & Running (Chapter 4)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Mastering Laravel by Christopher Pitt', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'SQL Fundamentals',
                'description' => 'Master SQL basics: SELECT, INSERT, UPDATE, DELETE, WHERE, JOIN, and basic database queries.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Database',
                'learning_objectives' => ['Write SQL queries', 'Use JOINs', 'Manipulate data'],
                'skills_gained' => ['SQL', 'Database Queries', 'MySQL'],
                'tags' => ['sql', 'database', 'mysql', 'queries'],
                'success_criteria' => ['Can write SQL queries', 'Can use JOINs', 'Can manage data'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=HXV3zeQKqGY', 'title' => 'freeCodeCamp - SQL Full Course', 'type' => 'video'],
                    ['url' => 'https://w3schools.com/sql/', 'title' => 'SQL Tutorial - W3Schools', 'type' => 'article'],
                    ['url' => 'https://dev.mysql.com/doc/', 'title' => 'SQL Documentation - MySQL', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Learning SQL by Alan Beaulieu', 'type' => 'book'],
                    ['url' => '#', 'title' => 'SQL Queries for Mere Mortals', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'Database Design & Normalization',
                'description' => 'Learn database design principles, normalization, relationships, and ERD modeling.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Database',
                'learning_objectives' => ['Design databases', 'Normalize data', 'Create relationships'],
                'skills_gained' => ['Database Design', 'Normalization', 'ERD', 'Relationships'],
                'tags' => ['database', 'design', 'normalization', 'erd'],
                'success_criteria' => ['Can design databases', 'Understands normalization', 'Can create ERDs'],
                'has_code_submission' => false,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=ztHopE5Wnpc', 'title' => 'freeCodeCamp - Database Design', 'type' => 'video'],
                    ['url' => 'https://geeksforgeeks.org/normal-forms-in-dbms/', 'title' => 'Database Normalization - GeeksforGeeks', 'type' => 'article'],
                    ['url' => 'https://lucidchart.com/pages/database-diagram/database-design', 'title' => 'Database Design Guide - Lucidchart', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Database Design for Mere Mortals', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Beginning Database Design by Clare Churcher', 'type' => 'book'],
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
