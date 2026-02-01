<?php

namespace Database\Seeders;

use App\Models\Roadmap;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProfessionalSkillsRoadmapSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@roadmap.camp')->first();
        $phase7 = Roadmap::where('slug', 'phase-7-mid-level-skills')->first();

        $roadmap = Roadmap::create([
            'creator_id' => $admin->id ?? null,
            'title' => 'Professional Skills',
            'description' => 'Develop essential professional skills for career success: communication and project management.',
            'slug' => 'phase-8-professional-skills',
            'duration_days' => 7,
            'difficulty_level' => 'intermediate',
            'is_published' => true,
            'is_featured' => false,
            'order' => 10,
            'prerequisite_roadmap_id' => $phase7->id ?? null,
        ]);

        $this->createTasks($roadmap);
    }

    protected function createTasks(Roadmap $roadmap): void
    {
        $tasks = [
            [
                'title' => 'Technical Communication',
                'description' => 'Learn effective technical communication: writing documentation, explaining technical concepts, creating README files, and communicating with stakeholders.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Professional',
                'learning_objectives' => [],
                'skills_gained' => ['Technical Writing', 'Communication', 'Documentation'],
                'tags' => ['communication', 'documentation', 'writing', 'professional'],
                'success_criteria' => [],
                'has_code_submission' => false,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=YK-GurROGIg', 'title' => 'Traversy Media - Documentation', 'type' => 'video'],
                    ['url' => 'https://developers.google.com/tech-writing/one', 'title' => 'Technical Writing Guide - Google', 'type' => 'article'],
                    ['url' => 'https://freecodecamp.org/news/how-to-write-a-good-readme-file/', 'title' => 'How to Write Good README', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Technical Communication by Mike Markel', 'type' => 'book'],
                    ['url' => '#', 'title' => 'The Elements of Technical Writing', 'type' => 'book'],
                ],
            ],
            [
                'title' => 'Time Estimation & Project Management',
                'description' => 'Learn project management fundamentals: estimating tasks, managing time, and working in teams.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Professional',
                'learning_objectives' => [],
                'skills_gained' => ['Time Estimation', 'Project Management', 'Task Planning'],
                'tags' => ['project-management', 'time-estimation', 'planning'],
                'success_criteria' => [],
                'has_code_submission' => false,
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=TiC8pig6PGE', 'title' => 'Project Management Basics', 'type' => 'video'],
                    ['url' => 'https://atlassian.com/agile/project-management/estimation', 'title' => 'Agile Estimation - Atlassian', 'type' => 'article'],
                    ['url' => '#', 'title' => 'The Mythical Man-Month by Fred Brooks', 'type' => 'book'],
                ],
            ],

            // Days 3-7: Agile Methodology
            [
                'title' => 'Agile Fundamentals',
                'description' => 'Understand Agile methodology: Agile manifesto, principles, values, and the Agile mindset for software development.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Professional',
                'learning_objectives' => [],
                'skills_gained' => ['Agile Methodology', 'Agile Principles', 'Agile Mindset'],
                'tags' => ['agile', 'methodology', 'principles', 'mindset'],
                'success_criteria' => [],
                'has_code_submission' => false,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=8eVXTyIZ1Hs', 'title' => 'Agile Methodology - freeCodeCamp', 'type' => 'video'],
                    ['url' => 'https://agilemanifesto.org/', 'title' => 'Agile Manifesto', 'type' => 'article'],
                    ['url' => 'https://www.atlassian.com/agile', 'title' => 'What is Agile? - Atlassian', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Scrum Framework',
                'description' => 'Master Scrum: roles (Product Owner, Scrum Master, Team), ceremonies (Sprint Planning, Daily Standup, Review, Retrospective), and artifacts.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Professional',
                'learning_objectives' => [],
                'skills_gained' => ['Scrum', 'Sprint Planning', 'Scrum Ceremonies', 'Team Collaboration'],
                'tags' => ['scrum', 'sprint', 'ceremonies', 'collaboration'],
                'success_criteria' => [],
                'has_code_submission' => false,
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=9TycLR0TqFA', 'title' => 'Scrum in 20 Minutes', 'type' => 'video'],
                    ['url' => 'https://scrumguides.org/scrum-guide.html', 'title' => 'Official Scrum Guide', 'type' => 'article'],
                    ['url' => 'https://www.scrum.org/resources/what-is-scrum', 'title' => 'What is Scrum? - Scrum.org', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Kanban Methodology',
                'description' => 'Learn Kanban: visualizing workflow, WIP limits, continuous delivery, Kanban boards, and comparing Kanban vs Scrum.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Professional',
                'learning_objectives' => [],
                'skills_gained' => ['Kanban', 'Workflow Management', 'WIP Limits', 'Continuous Delivery'],
                'tags' => ['kanban', 'workflow', 'boards', 'delivery'],
                'success_criteria' => [],
                'has_code_submission' => false,
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=iVaFVa7HYj4', 'title' => 'Kanban Explained', 'type' => 'video'],
                    ['url' => 'https://www.atlassian.com/agile/kanban', 'title' => 'Kanban Guide - Atlassian', 'type' => 'article'],
                    ['url' => 'https://www.atlassian.com/agile/kanban/kanban-vs-scrum', 'title' => 'Kanban vs Scrum - Atlassian', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'User Stories & Backlog Management',
                'description' => 'Write effective user stories: INVEST criteria, acceptance criteria, story points, backlog grooming, and prioritization techniques.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Professional',
                'learning_objectives' => [],
                'skills_gained' => ['User Stories', 'Backlog Management', 'Story Points', 'Prioritization'],
                'tags' => ['user-stories', 'backlog', 'stories', 'prioritization'],
                'success_criteria' => [],
                'has_code_submission' => false,
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=apOvF9NVguA', 'title' => 'Writing User Stories', 'type' => 'video'],
                    ['url' => 'https://www.atlassian.com/agile/project-management/user-stories', 'title' => 'User Stories - Atlassian', 'type' => 'article'],
                    ['url' => 'https://www.mountaingoatsoftware.com/agile/user-stories', 'title' => 'User Stories Guide', 'type' => 'article'],
                ],
            ],
            [
                'title' => 'Agile Tools & Practices',
                'description' => 'Master Agile tools: Jira, Trello, Azure DevOps, burndown charts, velocity tracking, and team collaboration tools.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Professional',
                'learning_objectives' => [],
                'skills_gained' => ['Jira', 'Agile Tools', 'Burndown Charts', 'Velocity Tracking'],
                'tags' => ['jira', 'tools', 'tracking', 'collaboration'],
                'success_criteria' => [],
                'has_code_submission' => false,
                'resources' => [
                    ['url' => 'https://www.youtube.com/watch?v=uM_m6EzMg3k', 'title' => 'Jira Tutorial for Beginners', 'type' => 'video'],
                    ['url' => 'https://www.atlassian.com/software/jira/guides', 'title' => 'Jira Guides - Atlassian', 'type' => 'article'],
                    ['url' => 'https://www.atlassian.com/agile/tutorials', 'title' => 'Agile Tutorials - Atlassian', 'type' => 'article'],
                    ['url' => '#', 'title' => 'Agile Estimating and Planning by Mike Cohn', 'type' => 'book'],
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
