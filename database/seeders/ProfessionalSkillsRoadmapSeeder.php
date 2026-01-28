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
            'title' => 'Phase 8: Professional Skills',
            'description' => 'Develop essential professional skills for career success: communication and project management.',
            'slug' => 'phase-8-professional-skills',
            'duration_days' => 2,
            'difficulty_level' => 'intermediate',
            'is_published' => true,
            'is_featured' => false,
            'order' => 12,
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
                'learning_objectives' => ['Write clear documentation', 'Explain complex concepts', 'Create README files'],
                'skills_gained' => ['Technical Writing', 'Communication', 'Documentation'],
                'tags' => ['communication', 'documentation', 'writing', 'professional'],
                'success_criteria' => ['Can write clear docs', 'Can explain to non-technical people', 'Creates comprehensive READMEs'],
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
                'description' => 'Learn project management fundamentals: estimating tasks, managing time, Agile/Scrum basics, and working in teams.',
                'estimated_time_minutes' => 120,
                'task_type' => 'video',
                'category' => 'Professional',
                'learning_objectives' => ['Estimate task complexity', 'Understand Agile/Scrum', 'Work in teams'],
                'skills_gained' => ['Time Estimation', 'Agile Methodology', 'Scrum', 'Project Management'],
                'tags' => ['project-management', 'agile', 'scrum', 'time-estimation'],
                'success_criteria' => ['Can estimate task durations', 'Understands Agile/Scrum', 'Can work in sprints'],
                'has_code_submission' => false,
                'resources' => [
                    ['url' => 'https://youtube.com/watch?v=8eVXTyIZ1Hs', 'title' => 'freeCodeCamp - Agile', 'type' => 'video'],
                    ['url' => 'https://atlassian.com/agile/project-management/estimation', 'title' => 'Agile Estimation - Atlassian', 'type' => 'article'],
                    ['url' => 'https://scrumguides.org/scrum-guide.html', 'title' => 'Scrum Guide', 'type' => 'article'],
                    ['url' => '#', 'title' => 'The Mythical Man-Month by Fred Brooks', 'type' => 'book'],
                    ['url' => '#', 'title' => 'Agile Estimating and Planning', 'type' => 'book'],
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
