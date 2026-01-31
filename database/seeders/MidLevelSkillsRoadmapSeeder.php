<?php

namespace Database\Seeders;

use App\Models\Roadmap;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class MidLevelSkillsRoadmapSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@roadmap.camp')->first();
        $phase6 = Roadmap::where('slug', 'phase-6-devops-basics')->first();

        $roadmap = Roadmap::create([
            'creator_id' => $admin->id ?? null,
            'title' => 'Mid-Level Skills',
            'description' => 'Advance your skills with testing, design patterns, performance optimization, and professional development practices.',
            'slug' => 'phase-7-mid-level-skills',
            'duration_days' => 13,
            'difficulty_level' => 'intermediate',
            'is_published' => true,
            'is_featured' => false,
            'order' => 11,
            'prerequisite_roadmap_id' => $phase6->id ?? null,
        ]);

        $this->createTasks($roadmap);
    }

    protected function createTasks(Roadmap $roadmap): void
    {
        $tasks = [
            [
                'title' => 'Unit Testing',
                'description' => 'Learn software testing: unit tests, integration tests, feature tests, and testing best practices.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Testing',
                'learning_objectives' => [],
                'skills_gained' => ['Unit Testing', 'Integration Testing', 'PHPUnit', 'Test Coverage'],
                'tags' => ['testing', 'phpunit', 'unit-tests', 'quality'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=k9ak_rv9X0Y', 'title' => 'Traversy Media - PHPUnit', 'type' => 'video'],
                    ['url' => 'https://phpunit.de/documentation.html', 'title' => 'PHPUnit Documentation', 'type' => 'article'],
                    ['url' => 'https://laravel.com/docs/testing', 'title' => 'Testing - Laravel Docs', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Test-Driven Laravel by Adam Wathan', 'type' => 'book'],
                    ['url' => '#', 'title' => 'The Art of Unit Testing', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'Feature Testing & TDD',
                'description' => 'Master TDD methodology: red-green-refactor cycle, writing tests first, and TDD best practices.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Testing',
                'learning_objectives' => [],
                'skills_gained' => ['Test-Driven Development', 'Refactoring', 'Code Design'],
                'tags' => ['tdd', 'testing', 'refactoring', 'methodology'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=dV_VGx_ZLa4', 'title' => 'Laracasts - TDD The Laravel Way', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/http-tests', 'title' => 'Feature Testing - Laravel Docs', 'type' => 'article'],
                    ['url' => 'https://martinfowler.com/bliki/TestDrivenDevelopment.html', 'title' => 'TDD Guide - Martin Fowler', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Test Driven Development by Kent Beck', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Growing Object-Oriented Software', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'SOLID Principles',
                'description' => 'Master SOLID design principles: Single Responsibility, Open-Closed, Liskov Substitution, Interface Segregation, Dependency Inversion.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Design',
                'learning_objectives' => [],
                'skills_gained' => ['SOLID Principles', 'Object-Oriented Design', 'Code Maintainability'],
                'tags' => ['solid', 'design-principles', 'oop', 'architecture'],
                'success_criteria' => [],
                'has_code_submission' => false,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=rtmFCcjEgEw', 'title' => 'freeCodeCamp - SOLID in PHP', 'type' => 'video'],
                    ['url' => 'https://digitalocean.com/community/conceptual-articles/s-o-l-i-d-the-first-five-principles-of-object-oriented-design', 'title' => 'SOLID Principles - DigitalOcean', 'type' => 'article'],
                    ['url' => 'https://laracasts.com/series/solid-principles-in-php', 'title' => 'SOLID in PHP - Laracasts', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Clean Architecture by Robert Martin (Part III)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Agile Principles, Patterns by Robert Martin', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'Design Patterns',
                'description' => 'Learn common design patterns: Factory, Strategy, Observer, Decorator, Singleton, and Repository patterns.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Design',
                'learning_objectives' => [],
                'skills_gained' => ['Design Patterns', 'Software Architecture', 'Problem Solving'],
                'tags' => ['design-patterns', 'architecture', 'oop'],
                'success_criteria' => [],
                'has_code_submission' => false,
                'resources' => [
                    ['url' => 'https://youtube.com/playlist?list=PLF206E906175C7E07', 'title' => 'Derek Banas - Design Patterns', 'type' => 'video'],
                    ['url' => 'https://refactoring.guru/design-patterns', 'title' => 'Refactoring Guru - Patterns', 'type' => 'article'],
                    ['url' => 'https://designpatternsphp.readthedocs.io/', 'title' => 'PHP Design Patterns', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Head First Design Patterns', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Design Patterns by Gang of Four (Selected Chapters)', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'Service & Repository Patterns',
                'description' => 'Implement service layer architecture and repository pattern for clean, maintainable Laravel applications.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Architecture',
                'learning_objectives' => [],
                'skills_gained' => ['Service Layer Pattern', 'Repository Pattern', 'Clean Architecture'],
                'tags' => ['architecture', 'service-layer', 'repository', 'laravel'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=MF0jFKvS4SI', 'title' => 'Andre Madarang - Service Classes', 'type' => 'video'],
                    ['url' => 'https://deviq.com/design-patterns/repository-pattern', 'title' => 'Repository Pattern - DevIQ', 'type' => 'article'],
                    ['url' => 'https://martinfowler.com/eaaCatalog/serviceLayer.html', 'title' => 'Service Layer - Martin Fowler', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Patterns of Enterprise Application Architecture', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Domain-Driven Design by Eric Evans (Chapters 4-6)', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'Caching (Redis)',
                'description' => 'Master caching techniques: Redis, cache drivers, cache tags, query caching, and cache invalidation strategies.',
                'estimated_time_minutes' => 30,
                'task_type' => 'video',
                'category' => 'Performance',
                'learning_objectives' => [],
                'skills_gained' => ['Caching', 'Redis', 'Performance Optimization'],
                'tags' => ['caching', 'redis', 'performance', 'optimization'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=jgpVdJB2sKQ', 'title' => 'Traversy Media - Redis Crash Course', 'type' => 'video'],
                    ['url' => 'https://redis.io/docs/', 'title' => 'Redis Documentation', 'type' => 'article'],
                    ['url' => 'https://laravel.com/docs/cache', 'title' => 'Laravel Cache - Docs', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Redis in Action by Josiah Carlson', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Redis Essentials', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'Query Optimization & Indexing',
                'description' => 'Optimize database queries: indexing strategies, N+1 problem, query profiling, and database performance tuning.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Performance',
                'learning_objectives' => [],
                'skills_gained' => ['Query Optimization', 'Database Indexing', 'Performance Profiling'],
                'tags' => ['database', 'optimization', 'performance', 'sql'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=-qNSXK7s7_w', 'title' => 'Hussein Nasser - Database Indexing', 'type' => 'video'],
                    ['url' => 'https://dev.mysql.com/doc/refman/8.0/en/optimization.html', 'title' => 'MySQL Optimization - MySQL Docs', 'type' => 'article'],
                    ['url' => 'https://use-the-index-luke.com/', 'title' => 'Indexing Guide - Use The Index Luke', 'type' => 'article'],
                    ['url' => '#', 'title' => 'High Performance MySQL (Chapters 5-7)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'SQL Performance Explained', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'Laravel Queues & Jobs',
                'description' => 'Implement Laravel queues: job creation, queue workers, failed jobs, job batching, and async processing.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Backend',
                'learning_objectives' => [],
                'skills_gained' => ['Queue Systems', 'Background Processing', 'Async Operations'],
                'tags' => ['queues', 'jobs', 'async', 'laravel'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=rVx8xKisbr8', 'title' => 'Codecourse - Laravel Queues', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/queues', 'title' => 'Queues - Laravel Docs', 'type' => 'article'],
                    ['url' => 'https://laravel.com/docs/horizon', 'title' => 'Horizon - Laravel Docs', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Laravel: Up & Running (Chapter 16)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Mastering Laravel (Chapter 7)', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'Events & Listeners',
                'description' => 'Implement event-driven architecture: creating events, listeners, event broadcasting, and decoupling application logic.',
                'estimated_time_minutes' => 90,
                'task_type' => 'video',
                'category' => 'Backend',
                'learning_objectives' => [],
                'skills_gained' => ['Event-Driven Architecture', 'Broadcasting', 'Real-time Features'],
                'tags' => ['events', 'listeners', 'broadcasting', 'laravel'],
                'success_criteria' => [],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=9tbxl_I1EGE', 'title' => 'Andre Madarang - Laravel Events', 'type' => 'video'],
                    ['url' => 'https://laravel.com/docs/events', 'title' => 'Events - Laravel Docs', 'type' => 'article'],
                    ['url' => 'https://laravel.com/docs/eloquent#observers', 'title' => 'Observers - Laravel Docs', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Laravel: Up & Running (Chapter 16)', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Domain-Driven Laravel', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'Docker Basics',
                'description' => 'Learn Docker basics: containers, images, Dockerfile, Docker Compose, and containerizing applications.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'DevOps',
                'learning_objectives' => [],
                'skills_gained' => ['Docker', 'Containerization', 'Docker Compose'],
                'tags' => ['docker', 'containers', 'devops', 'deployment'],
                'success_criteria' => [],
                'has_code_submission' => false,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=3c-iBn73dDE', 'title' => 'TechWorld with Nana - Docker', 'type' => 'video'],
                    ['url' => 'https://docs.docker.com/get-started/', 'title' => 'Docker Documentation', 'type' => 'article'],
                    ['url' => 'https://docs.docker.com/compose/', 'title' => 'Docker Compose - Docs', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Docker Deep Dive by Nigel Poulton', 'type' => 'book'],
                    ['url' => '#', 'title' => 'The Docker Book by James Turnbull', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'CI/CD Basics (GitHub Actions)',
                'description' => 'Learn continuous integration and deployment: GitHub Actions, automated testing, and deployment pipelines.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'DevOps',
                'learning_objectives' => [],
                'skills_gained' => ['CI/CD', 'GitHub Actions', 'Automation', 'DevOps'],
                'tags' => ['ci-cd', 'github-actions', 'automation', 'deployment'],
                'success_criteria' => [],
                'has_code_submission' => false,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=R8_veQiYBjI', 'title' => 'freeCodeCamp - GitHub Actions', 'type' => 'video'],
                    ['url' => 'https://docs.github.com/en/actions', 'title' => 'GitHub Actions Docs', 'type' => 'article'],
                    ['url' => 'https://about.gitlab.com/topics/ci-cd/', 'title' => 'CI/CD Guide - GitLab', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Continuous Delivery by Jez Humble', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Learning GitHub Actions', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'Code Review & Documentation',
                'description' => 'Learn effective code review: reviewing code, giving feedback, handling feedback, and improving code quality through reviews.',
                'estimated_time_minutes' => 90,
                'task_type' => 'video',
                'category' => 'Professional',
                'learning_objectives' => [],
                'skills_gained' => ['Code Review', 'Team Collaboration', 'Code Quality'],
                'tags' => ['code-review', 'collaboration', 'quality', 'team'],
                'success_criteria' => [],
                'has_code_submission' => false,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=s7wmiS2mSXY', 'title' => 'Google - Code Review Best Practices', 'type' => 'video'],
                    ['url' => 'https://google.github.io/eng-practices/review/', 'title' => 'Google Code Review Guide', 'type' => 'article'],
                    ['url' => 'https://writethedocs.org/guide/', 'title' => 'Write the Docs', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Docs for Developers', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Clean Code (Chapter 4)', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'Debugging Strategies',
                'description' => 'Master debugging techniques: using debuggers, profiling tools, logging strategies, and performance analysis.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Development',
                'learning_objectives' => [],
                'skills_gained' => ['Debugging', 'Profiling', 'Performance Analysis', 'Problem Solving'],
                'tags' => ['debugging', 'profiling', 'performance', 'tools'],
                'success_criteria' => [],
                'has_code_submission' => false,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=x4q86IjJFag', 'title' => 'Traversy Media - Chrome DevTools', 'type' => 'video'],
                    ['url' => 'https://php.net/manual/en/debugger.php', 'title' => 'Debugging PHP - PHP.net', 'type' => 'article'],
                    ['url' => 'https://laravel.com/docs/telescope', 'title' => 'Laravel Telescope - Docs', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Debug It! by Paul Butcher', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Effective Debugging by Diomidis Spinellis', 'type' => 'book'],
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
