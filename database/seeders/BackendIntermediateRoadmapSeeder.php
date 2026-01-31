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

        $roadmap = Roadmap::create([
            'creator_id' => $admin->id ?? 1,
            'title' => 'Backend Intermediate',
            'description' => 'Advanced backend concepts: database optimization, caching, queues, WebSockets, API design, security, and performance.',
            'slug' => 'backend-intermediate',
            'duration_days' => 10,
            'difficulty_level' => 'advanced',
            'is_published' => true,
            'is_featured' => false,
            'order' => 7,
            'prerequisite_roadmap_id' => null,
        ]);

        $this->createTasks($roadmap);
    }

    protected function createTasks(Roadmap $roadmap): void
    {
        $tasks = [
            [
                'title' => 'Database Optimization & Indexing',
                'description' => 'Master database performance: query optimization, indexing strategies, EXPLAIN queries, and database profiling.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Database',
                'learning_objectives' => [],
                'skills_gained' => ['Database Optimization', 'Indexing', 'Query Performance', 'Database Profiling'],
                'tags' => ['database', 'optimization', 'indexing', 'performance'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=HubezKbFL7E', 'title' => 'Database Indexing - Hussein Nasser', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=BIlFTFrEFOI', 'title' => 'Database Sharding - Hussein Nasser', 'type' => 'video'],
                    ['url' => 'https://use-the-index-luke.com/', 'title' => 'SQL Performance Explained', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Caching Strategies & Redis',
                'description' => 'Implement caching strategies: Redis fundamentals, cache invalidation, cache-aside pattern, and Laravel caching.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Backend',
                'learning_objectives' => [],
                'skills_gained' => ['Caching', 'Redis', 'Performance Optimization', 'Cache Strategies'],
                'tags' => ['caching', 'redis', 'performance', 'optimization'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=jgpVdJB2sKQ', 'title' => 'Redis Crash Course - Web Dev Simplified', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=dGAgxozNWFE', 'title' => 'Caching Explained - ByteByteGo', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/11.x/cache', 'title' => 'Laravel Cache - Laravel Docs', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Message Queues & Background Jobs',
                'description' => 'Master asynchronous processing: Laravel queues, job dispatching, workers, failed jobs, and queue monitoring.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Backend',
                'learning_objectives' => [],
                'skills_gained' => ['Message Queues', 'Background Jobs', 'Async Processing', 'Laravel Queues'],
                'tags' => ['queues', 'jobs', 'async', 'background-processing'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=oUJbuFMyBDk', 'title' => 'Message Queues Explained - IBM Technology', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=rXRVL0FhH6A', 'title' => 'Laravel Queues Tutorial - Code With Dary', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/11.x/queues', 'title' => 'Laravel Queues - Laravel Docs', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'WebSockets & Real-time Communication',
                'description' => 'Implement real-time features: WebSockets, Laravel Broadcasting, Pusher, event broadcasting, and presence channels.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Backend',
                'learning_objectives' => [],
                'skills_gained' => ['WebSockets', 'Real-time Communication', 'Laravel Broadcasting', 'Event Broadcasting'],
                'tags' => ['websockets', 'realtime', 'broadcasting', 'events'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=i50mQiPYV9o', 'title' => 'WebSockets Explained - Fireship', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=VJrK8S8hFxE', 'title' => 'Laravel Broadcasting - Code With Dary', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/11.x/broadcasting', 'title' => 'Laravel Broadcasting - Laravel Docs', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Advanced API Design & Versioning',
                'description' => 'Master API design: versioning strategies, rate limiting, pagination, API resources, and error handling.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Backend',
                'learning_objectives' => [],
                'skills_gained' => ['API Design', 'API Versioning', 'Rate Limiting', 'API Best Practices'],
                'tags' => ['api', 'rest', 'design', 'best-practices'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=lsMQRaeKNDk', 'title' => 'REST API Best Practices - ByteByteGo', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=0oXYLzuucwE', 'title' => 'REST API Design - freeCodeCamp', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/11.x/eloquent-resources', 'title' => 'API Resources - Laravel Docs', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'API Authentication & Security',
                'description' => 'Implement secure API authentication: JWT, Laravel Sanctum, OAuth 2.0, and API token management.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Backend',
                'learning_objectives' => [],
                'skills_gained' => ['API Authentication', 'JWT', 'OAuth', 'API Security'],
                'tags' => ['api', 'authentication', 'security', 'jwt'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=926mknSW9Lo', 'title' => 'JWT in 100 Seconds - Fireship', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=MT3_J2emm1w', 'title' => 'Laravel Sanctum API - Code With Dary', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/11.x/sanctum', 'title' => 'Laravel Sanctum - Laravel Docs', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'File Uploads & Storage',
                'description' => 'Master file handling: file uploads, storage drivers, S3 integration, image processing, and file validation.',
                'estimated_time_minutes' => 90,
                'task_type' => 'video',
                'category' => 'Laravel',
                'learning_objectives' => [],
                'skills_gained' => ['File Uploads', 'Storage', 'S3', 'Image Processing'],
                'tags' => ['laravel', 'files', 'storage', 's3'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=AjSi4c-k1P4', 'title' => 'Laravel File Upload - Code With Dary', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/11.x/filesystem', 'title' => 'File Storage - Laravel Docs', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Email & Notifications',
                'description' => 'Implement email sending, notification channels, mail templates, queued notifications, and SMS notifications.',
                'estimated_time_minutes' => 90,
                'task_type' => 'video',
                'category' => 'Laravel',
                'learning_objectives' => [],
                'skills_gained' => ['Email', 'Notifications', 'Mail Templates', 'SMS'],
                'tags' => ['laravel', 'email', 'notifications', 'mail'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=ccj0C-ICPXo', 'title' => 'Laravel Mail & Notifications - Code With Dary', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/11.x/mail', 'title' => 'Mail - Laravel Docs', 'type' => 'article'],
                    ['url' => 'https://laravel.com/docs/11.x/notifications', 'title' => 'Notifications - Laravel Docs', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Testing & Test-Driven Development',
                'description' => 'Master PHPUnit testing: feature tests, unit tests, database testing, mocking, and TDD principles.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Testing',
                'learning_objectives' => [],
                'skills_gained' => ['Testing', 'PHPUnit', 'TDD', 'Test Automation'],
                'tags' => ['testing', 'phpunit', 'tdd', 'quality'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=iDp5qazTrX8', 'title' => 'Laravel Testing - Code With Dary', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=CZ-_rVbaBN8', 'title' => 'Laravel TDD Tutorial - Coder\'s Tape', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/11.x/testing', 'title' => 'Testing - Laravel Docs', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Logging, Monitoring & Debugging',
                'description' => 'Implement logging, error tracking, application monitoring, performance profiling, and debugging techniques.',
                'estimated_time_minutes' => 0,
                'task_type' => 'video',
                'category' => 'Backend',
                'learning_objectives' => [],
                'skills_gained' => ['Logging', 'Monitoring', 'Debugging', 'Error Tracking'],
                'tags' => ['logging', 'monitoring', 'debugging', 'errors'],
                'success_criteria' => [],
                'has_code_submission' => false,
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=l4mkEqvGWRE', 'title' => 'Laravel Telescope Tutorial - Laravel Daily', 'type' => 'video'],
                    ['url' => 'https://www.youtube.com/watch?v=SR3RzIfeozI', 'title' => 'Laravel Debugging Tutorial - Traversy Media', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/11.x/logging', 'title' => 'Logging - Laravel Docs', 'type' => 'article'],
                    ['url' => 'https://laravel.com/docs/11.x/telescope', 'title' => 'Laravel Telescope - Laravel Docs', 'type' => 'article'],
                ],
            ],
        ];

        $dayNumber = 1;
        foreach ($tasks as $taskData) {
            Task::create(array_merge($taskData, [
                'roadmap_id' => $roadmap->id,
                'day_number' => $dayNumber++,
                'order' => 1,
                'difficulty_level' => 'advanced',
                'has_quality_rating' => true,
            ]));
        }
    }
}
