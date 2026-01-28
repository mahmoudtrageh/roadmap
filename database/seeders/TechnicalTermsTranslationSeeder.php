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
            'duration_days' => 14,
            'difficulty_level' => 'beginner',
            'is_published' => true,
            'is_featured' => true,
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
                'learning_objectives' => ['Master technical vocabulary', 'Understand Arabic translations', 'Build bilingual fluency'],
                'skills_gained' => ['Technical Vocabulary', 'Bilingual Communication'],
                'tags' => ['translation', 'arabic', 'english', 'terminology'],
                'success_criteria' => ['Downloaded and studied PDF', 'Can translate key terms'],
                'resources' => [],
                'has_code_submission' => false,
                'has_quality_rating' => false,
            ]));
        }
    }
}
