<?php

namespace Database\Seeders;

use App\Models\Roadmap;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TechnicalTermsTranslationSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@roadmap.camp')->first();

        $roadmap = Roadmap::create([
            'creator_id' => $admin->id ?? 1,
            'title' => 'Technical Terms: English ⟷ Arabic',
            'description' => 'Master essential English technical terms with Arabic translations. Download PDF files containing term-translation pairs for each topic.',
            'slug' => 'technical-terms-translation',
            'duration_days' => 35,
            'difficulty_level' => 'beginner',
            'is_published' => true,
            'is_featured' => false,
            'order' => 1,
            'prerequisite_roadmap_id' => null,
        ]);

        $this->createTasks($roadmap);
    }

    protected function createTasks(Roadmap $roadmap): void
    {
        $tasks = [
            [
                'title' => 'Day 1: Programming Basics - المفاهيم البرمجية الأساسية',
                'description' => 'Download and study the PDF containing essential programming terms: variables, functions, loops, conditions, arrays, objects, and basic operators with Arabic translations.',
                'estimated_time_minutes' => 60,
            ],
            [
                'title' => 'Day 2: Data Types & Structures - أنواع البيانات والهياكل',
                'description' => 'Download and study the PDF covering data types and structures: integers, floats, strings, lists, dictionaries, sets, tuples, and stack operations.',
                'estimated_time_minutes' => 60,
            ],
            [
                'title' => 'Day 3: Control Flow - تحكم في التدفق',
                'description' => 'Download and study the PDF about control flow terminology: if/else, switch, loops (for/while), break, continue, and nested structures.',
                'estimated_time_minutes' => 60,
            ],
            [
                'title' => 'Day 4: Functions & Methods - الدوال والأساليب',
                'description' => 'Download and study the PDF covering functions and methods: parameters, arguments, return values, scope, callbacks, and arrow functions.',
                'estimated_time_minutes' => 60,
            ],
            [
                'title' => 'Day 5: OOP Concepts - البرمجة الكائنية',
                'description' => 'Download and study the PDF about Object-Oriented Programming: class, object, inheritance, polymorphism, encapsulation, and abstraction.',
                'estimated_time_minutes' => 60,
            ],
            [
                'title' => 'Day 6: Web Development - تطوير الويب',
                'description' => 'Download and study the PDF covering web development terms: HTML, CSS, JavaScript, DOM, selector, event, responsive design, and frameworks.',
                'estimated_time_minutes' => 60,
            ],
            [
                'title' => 'Day 7: Database & SQL - قواعد البيانات',
                'description' => 'Download and study the PDF about database terminology: table, query, join, index, primary key, foreign key, transaction, and normalization.',
                'estimated_time_minutes' => 60,
            ],
            [
                'title' => 'Day 8: Git & Version Control - إدارة النسخ',
                'description' => 'Download and study the PDF covering Git terminology: commit, branch, merge, pull request, repository, clone, fork, and conflict resolution.',
                'estimated_time_minutes' => 60,
            ],
            [
                'title' => 'Day 9: Testing & Debugging - الاختبار وإصلاح الأخطاء',
                'description' => 'Download and study the PDF about testing terminology: unit test, integration test, mock, assertion, debugging, breakpoint, and test coverage.',
                'estimated_time_minutes' => 60,
            ],
            [
                'title' => 'Day 10: Algorithms & Data Structures - الخوارزميات وهياكل البيانات',
                'description' => 'Download and study the PDF covering algorithms: sorting, searching, recursion, tree, graph, linked list, and time complexity.',
                'estimated_time_minutes' => 60,
            ],
            [
                'title' => 'Day 11: Software Engineering - هندسة البرمجيات',
                'description' => 'Download and study the PDF about software engineering: architecture, design pattern, refactoring, code review, technical debt, and best practices.',
                'estimated_time_minutes' => 60,
            ],
            [
                'title' => 'Day 12: DevOps & Deployment - عمليات التطوير والنشر',
                'description' => 'Download and study the PDF covering DevOps terms: CI/CD, container, Docker, cloud, server, deployment, environment, and infrastructure.',
                'estimated_time_minutes' => 60,
            ],
            [
                'title' => 'Day 13: Security - الأمن السيبراني',
                'description' => 'Download and study the PDF about security terminology: authentication, authorization, encryption, vulnerability, XSS, SQL injection, and HTTPS.',
                'estimated_time_minutes' => 60,
            ],
            [
                'title' => 'Day 14: Professional Communication - التواصل المهني',
                'description' => 'Download and study the PDF covering professional terms: code review, documentation, Agile, sprint, standup, retrospective, and technical writing.',
                'estimated_time_minutes' => 60,
            ],
            [
                'title' => 'Day 15: APIs & HTTP - واجهات برمجة التطبيقات',
                'description' => 'Learn API terminology: REST, endpoint, HTTP methods (GET, POST, PUT, DELETE), status codes, headers, JSON, GraphQL, and webhooks.',
                'estimated_time_minutes' => 60,
            ],
            [
                'title' => 'Day 16: Frontend Frameworks - أطر العمل الأمامية',
                'description' => 'Study frontend framework terms: React, Vue, Angular, components, props, state, hooks, lifecycle, virtual DOM, and SSR/CSR concepts.',
                'estimated_time_minutes' => 60,
            ],
            [
                'title' => 'Day 17: Backend Development - تطوير الخادم الخلفي',
                'description' => 'Master backend terms: Laravel, Node.js, Express, Django, middleware, routes, controllers, MVC, queues, and validation.',
                'estimated_time_minutes' => 60,
            ],
            [
                'title' => 'Day 18: Mobile Development - تطوير تطبيقات الجوال',
                'description' => 'Learn mobile development terminology: React Native, Flutter, Swift, Kotlin, native apps, cross-platform, widgets, and app stores.',
                'estimated_time_minutes' => 60,
            ],
            [
                'title' => 'Day 19: Performance & Optimization - الأداء والتحسين',
                'description' => 'Study performance terms: caching, lazy loading, code splitting, minification, compression, web vitals, profiling, and bottlenecks.',
                'estimated_time_minutes' => 60,
            ],
            [
                'title' => 'Day 20: Cloud & Infrastructure - الحوسبة السحابية والبنية التحتية',
                'description' => 'Master cloud terminology: AWS, Azure, GCP, serverless, containers, load balancers, auto-scaling, and infrastructure as code.',
                'estimated_time_minutes' => 60,
            ],
            [
                'title' => 'Day 21: TypeScript & Modern JavaScript - تايب سكريبت وجافا سكريبت الحديث',
                'description' => 'Learn TypeScript terms: type annotations, interfaces, generics, union types, decorators, and modern JavaScript features.',
                'estimated_time_minutes' => 60,
            ],
            [
                'title' => 'Day 22: CSS & Styling - التنسيق والأنماط',
                'description' => 'Study CSS terminology: Flexbox, Grid, responsive design, media queries, transitions, animations, box model, and transforms.',
                'estimated_time_minutes' => 60,
            ],
            [
                'title' => 'Day 23: HTML & Semantic Web - HTML والويب الدلالي',
                'description' => 'Master HTML terms: semantic elements, accessibility, ARIA, forms, meta tags, SEO, and document structure.',
                'estimated_time_minutes' => 60,
            ],
            [
                'title' => 'Day 24: Laravel Specific - لارافيل المتقدم',
                'description' => 'Learn Laravel-specific terms: Blade templates, Eloquent ORM, migrations, seeders, Artisan, middleware, and service providers.',
                'estimated_time_minutes' => 60,
            ],
            [
                'title' => 'Day 25: Linux & Command Line - لينكس وسطر الأوامر',
                'description' => 'Study Linux terminology: terminal, shell, commands, permissions, processes, SSH, pipes, environment variables, and cron jobs.',
                'estimated_time_minutes' => 60,
            ],
            [
                'title' => 'Day 26: Networking & Web Concepts - الشبكات ومفاهيم الويب',
                'description' => 'Master networking terms: IP address, DNS, URL, protocols, client-server, proxy, SSL, VPN, cookies, and sessions.',
                'estimated_time_minutes' => 60,
            ],
            [
                'title' => 'Day 27: Project Management & Workflow - إدارة المشاريع وسير العمل',
                'description' => 'Learn project management terms: repository, version control, README, documentation, releases, MVP, POC, and production.',
                'estimated_time_minutes' => 60,
            ],
            [
                'title' => 'Day 28: Common Dev Tools & Packages - أدوات وحزم شائعة',
                'description' => 'Study development tools: NPM, Composer, Webpack, Vite, ESLint, Prettier, VS Code, Postman, and other essential tools.',
                'estimated_time_minutes' => 60,
            ],
            [
                'title' => 'Day 29: Advanced JavaScript Concepts - مفاهيم جافا سكريبت المتقدمة',
                'description' => 'Master advanced JS concepts: hoisting, event loop, closures, prototypes, currying, event delegation, and pure functions.',
                'estimated_time_minutes' => 60,
            ],
            [
                'title' => 'Day 30: Error Handling & Debugging - معالجة الأخطاء وإصلاحها',
                'description' => 'Learn error handling terms: try-catch, exceptions, stack trace, breakpoints, debugging tools, and error types.',
                'estimated_time_minutes' => 60,
            ],
            [
                'title' => 'Day 31: Design Patterns - أنماط التصميم',
                'description' => 'Study design patterns: Singleton, Factory, Observer, Strategy, MVC, MVVM, Repository, and Dependency Injection.',
                'estimated_time_minutes' => 60,
            ],
            [
                'title' => 'Day 32: Authentication & Authorization - المصادقة والتفويض',
                'description' => 'Master security terms: authentication, authorization, JWT, OAuth, sessions, 2FA, roles, permissions, and API keys.',
                'estimated_time_minutes' => 60,
            ],
            [
                'title' => 'Day 33: Data Formats & Serialization - تنسيقات البيانات والتسلسل',
                'description' => 'Learn data format terminology: JSON, XML, YAML, CSV, serialization, encoding, Base64, and character sets.',
                'estimated_time_minutes' => 60,
            ],
            [
                'title' => 'Day 34: Caching & Performance - التخزين المؤقت والأداء',
                'description' => 'Study caching terms: cache hit/miss, Redis, Memcached, TTL, CDN, cache invalidation, and browser caching.',
                'estimated_time_minutes' => 60,
            ],
            [
                'title' => 'Day 35: Async & Concurrency - البرمجة غير المتزامنة والتزامن',
                'description' => 'Master async programming: promises, async/await, event loop, threads, race conditions, and web workers.',
                'estimated_time_minutes' => 60,
            ],
        ];

        $dayNumber = 1;
        foreach ($tasks as $taskData) {
            Task::create(array_merge($taskData, [
                'roadmap_id' => $roadmap->id,
                'day_number' => $dayNumber++,
                'order' => 1,
                'task_type' => 'reading',
                'category' => 'Translation',
                'difficulty_level' => 'beginner',
                'description' => '',
                'learning_objectives' => [],
                'skills_gained' => ['Technical Vocabulary', 'Bilingual Communication'],
                'tags' => ['translation', 'arabic', 'english', 'terminology'],
                'success_criteria' => [],
                'resources' => [],
                'has_code_submission' => false,
                'has_quality_rating' => true,
            ]));
        }
    }
}
