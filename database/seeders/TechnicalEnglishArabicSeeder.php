<?php

namespace Database\Seeders;

use App\Models\Roadmap;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TechnicalEnglishArabicSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@roadmap.camp')->first();

        $roadmap = Roadmap::create([
            'creator_id' => $admin->id ?? 1,
            'title' => 'Technical English for Arabic Developers',
            'description' => 'Master essential English technical terms used in software engineering. Learn programming vocabulary, development terminology, and professional communication in English.',
            'slug' => 'technical-english-arabic',
            'duration_days' => 10,
            'difficulty_level' => 'beginner',
            'is_published' => true,
            'is_featured' => false,
            'order' => 9,
            'prerequisite_roadmap_id' => null,
        ]);

        $this->createTasks($roadmap);
    }

    protected function createTasks(Roadmap $roadmap): void
    {
        $tasks = [
            [
                'title' => 'Programming Basics Terminology',
                'description' => 'Learn essential programming terms: variables, functions, loops, conditions, data types, operators, and basic syntax terminology in English.',
                'estimated_time_minutes' => 60,
                'task_type' => 'reading',
                'category' => 'Technical English',
                'learning_objectives' => ['Master basic programming vocabulary', 'Understand variable and function terminology', 'Learn control flow terms'],
                'skills_gained' => ['Technical English', 'Programming Vocabulary', 'Communication'],
                'tags' => ['english', 'arabic', 'programming', 'terminology'],
                'success_criteria' => ['Can name basic programming concepts in English', 'Understands common code terminology'],
                'resources' => [
                    ['url' => 'https://developer.mozilla.org/en-US/docs/Glossary', 'title' => 'MDN Web Docs Glossary', 'type' => 'article'],
                    ['url' => 'https://github.com/HackYourFuture/curriculum/tree/main/technical-writing', 'title' => 'Technical Writing Guide', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Frontend Development Terms',
                'description' => 'Master HTML, CSS, JavaScript terminology: DOM, selectors, properties, events, async, components, and UI/UX vocabulary.',
                'estimated_time_minutes' => 90,
                'task_type' => 'reading',
                'category' => 'Technical English',
                'learning_objectives' => ['Learn HTML/CSS terminology', 'Master JavaScript vocabulary', 'Understand UI/UX terms'],
                'skills_gained' => ['Frontend Vocabulary', 'Web Development Terms'],
                'tags' => ['frontend', 'html', 'css', 'javascript', 'terminology'],
                'success_criteria' => ['Can describe frontend concepts in English', 'Understands web development terminology'],
                'resources' => [
                    ['url' => 'https://web.dev/learn/', 'title' => 'web.dev Learn', 'type' => 'article'],
                    ['url' => 'https://css-tricks.com/guides/', 'title' => 'CSS-Tricks Guides', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Backend Development Terms',
                'description' => 'Learn server-side terminology: API, REST, database, authentication, middleware, routing, ORM, and backend architecture vocabulary.',
                'estimated_time_minutes' => 90,
                'task_type' => 'reading',
                'category' => 'Technical English',
                'learning_objectives' => ['Master backend vocabulary', 'Understand API terminology', 'Learn database terms'],
                'skills_gained' => ['Backend Vocabulary', 'API Terms', 'Database Terminology'],
                'tags' => ['backend', 'api', 'database', 'terminology'],
                'success_criteria' => ['Can explain backend concepts in English', 'Understands server terminology'],
                'resources' => [
                    ['url' => 'https://restfulapi.net/', 'title' => 'REST API Tutorial', 'type' => 'article'],
                    ['url' => 'https://nodejs.org/en/docs/', 'title' => 'Node.js Documentation', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Database & SQL Terminology',
                'description' => 'Master database vocabulary: tables, queries, joins, indexes, transactions, normalization, and SQL command terminology.',
                'estimated_time_minutes' => 75,
                'task_type' => 'reading',
                'category' => 'Technical English',
                'learning_objectives' => ['Learn SQL vocabulary', 'Understand database terms', 'Master query terminology'],
                'skills_gained' => ['SQL Vocabulary', 'Database Terms'],
                'tags' => ['database', 'sql', 'terminology'],
                'success_criteria' => ['Can describe database operations in English', 'Understands SQL commands'],
                'resources' => [
                    ['url' => 'https://sqlbolt.com/', 'title' => 'SQLBolt Interactive Tutorial', 'type' => 'article'],
                    ['url' => 'https://use-the-index-luke.com/', 'title' => 'SQL Indexing Guide', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Git & Version Control Terms',
                'description' => 'Learn Git vocabulary: commit, branch, merge, pull request, repository, clone, fork, and version control terminology.',
                'estimated_time_minutes' => 60,
                'task_type' => 'reading',
                'category' => 'Technical English',
                'learning_objectives' => ['Master Git vocabulary', 'Understand version control terms', 'Learn collaboration terminology'],
                'skills_gained' => ['Git Vocabulary', 'Version Control Terms'],
                'tags' => ['git', 'version-control', 'terminology'],
                'success_criteria' => ['Can use Git commands in English', 'Understands collaboration workflow'],
                'resources' => [
                    ['url' => 'https://git-scm.com/docs', 'title' => 'Official Git Documentation', 'type' => 'article'],
                    ['url' => 'https://github.com/git-tips/tips', 'title' => 'Git Tips Collection', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Testing & Debugging Vocabulary',
                'description' => 'Master testing terminology: unit tests, integration tests, mocks, assertions, debugging, breakpoints, and QA vocabulary.',
                'estimated_time_minutes' => 60,
                'task_type' => 'reading',
                'category' => 'Technical English',
                'learning_objectives' => ['Learn testing vocabulary', 'Understand debugging terms', 'Master QA terminology'],
                'skills_gained' => ['Testing Vocabulary', 'Debugging Terms'],
                'tags' => ['testing', 'debugging', 'qa', 'terminology'],
                'success_criteria' => ['Can discuss testing in English', 'Understands debugging terminology'],
                'resources' => [
                    ['url' => 'https://jestjs.io/docs/getting-started', 'title' => 'Jest Testing Guide', 'type' => 'article'],
                    ['url' => 'https://testing-library.com/', 'title' => 'Testing Library Docs', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'DevOps & Deployment Terms',
                'description' => 'Learn deployment vocabulary: CI/CD, containers, Docker, cloud, server, hosting, environment, and infrastructure terminology.',
                'estimated_time_minutes' => 75,
                'task_type' => 'reading',
                'category' => 'Technical English',
                'learning_objectives' => ['Master DevOps vocabulary', 'Understand deployment terms', 'Learn infrastructure terminology'],
                'skills_gained' => ['DevOps Vocabulary', 'Deployment Terms'],
                'tags' => ['devops', 'deployment', 'docker', 'terminology'],
                'success_criteria' => ['Can discuss deployment in English', 'Understands DevOps terminology'],
                'resources' => [
                    ['url' => 'https://docs.docker.com/get-started/', 'title' => 'Docker Getting Started', 'type' => 'article'],
                    ['url' => 'https://github.com/features/actions', 'title' => 'GitHub Actions Docs', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Code Review & Documentation Terms',
                'description' => 'Master professional communication: code review vocabulary, documentation terms, comments, refactoring, and best practices terminology.',
                'estimated_time_minutes' => 60,
                'task_type' => 'reading',
                'category' => 'Technical English',
                'learning_objectives' => ['Learn code review vocabulary', 'Understand documentation terms', 'Master professional communication'],
                'skills_gained' => ['Review Vocabulary', 'Documentation Terms'],
                'tags' => ['code-review', 'documentation', 'terminology'],
                'success_criteria' => ['Can write code reviews in English', 'Understands documentation standards'],
                'resources' => [
                    ['url' => 'https://conventionalcomments.org/', 'title' => 'Conventional Comments Guide', 'type' => 'article'],
                    ['url' => 'https://google.github.io/styleguide/', 'title' => 'Google Style Guides', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Agile & Project Management Terms',
                'description' => 'Learn project management vocabulary: sprint, backlog, standup, retrospective, user story, epic, and Agile methodology terms.',
                'estimated_time_minutes' => 60,
                'task_type' => 'reading',
                'category' => 'Technical English',
                'learning_objectives' => ['Master Agile vocabulary', 'Understand project management terms', 'Learn team communication'],
                'skills_gained' => ['Agile Vocabulary', 'PM Terms'],
                'tags' => ['agile', 'scrum', 'project-management', 'terminology'],
                'success_criteria' => ['Can participate in Agile meetings in English', 'Understands PM terminology'],
                'resources' => [
                    ['url' => 'https://scrumguides.org/', 'title' => 'Official Scrum Guide', 'type' => 'article'],
                    ['url' => 'https://atlassian.com/agile', 'title' => 'Atlassian Agile Guide', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Practice: Technical Conversations',
                'description' => 'Practice using all learned terminology in real scenarios: explaining code, discussing bugs, writing documentation, and team communication.',
                'estimated_time_minutes' => 120,
                'task_type' => 'exercise',
                'category' => 'Technical English',
                'learning_objectives' => ['Apply all learned vocabulary', 'Practice technical communication', 'Build confidence in English'],
                'skills_gained' => ['Technical Communication', 'Professional English'],
                'tags' => ['practice', 'communication', 'terminology'],
                'success_criteria' => ['Can discuss technical topics fluently in English', 'Confident using technical terminology'],
                'has_code_submission' => true,
                'resources' => [
                    ['url' => 'https://stackoverflow.com/', 'title' => 'Stack Overflow - Read Questions', 'type' => 'article'],
                    ['url' => 'https://dev.to/', 'title' => 'DEV Community Articles', 'type' => 'article'],
                ],
            ],
        ];

        $dayNumber = 1;
        foreach ($tasks as $taskData) {
            Task::create(array_merge($taskData, [
                'roadmap_id' => $roadmap->id,
                'day_number' => $dayNumber++,
                'order' => 1,
                'difficulty_level' => 'beginner',
                'has_code_submission' => $taskData['has_code_submission'] ?? false,
                'has_quality_rating' => false,
            ]));
        }
    }
}
