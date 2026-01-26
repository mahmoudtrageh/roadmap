<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $achievements = [
            // Task Completion Achievements
            [
                'name' => 'First Steps',
                'description' => 'Complete your first task',
                'badge_icon' => '🎯',
                'type' => 'task_completion',
                'criteria' => ['count' => 1],
                'points' => 10,
            ],
            [
                'name' => 'Getting Started',
                'description' => 'Complete 10 tasks',
                'badge_icon' => '📚',
                'type' => 'task_completion',
                'criteria' => ['count' => 10],
                'points' => 50,
            ],
            [
                'name' => 'Dedicated Learner',
                'description' => 'Complete 50 tasks',
                'badge_icon' => '🔥',
                'type' => 'task_completion',
                'criteria' => ['count' => 50],
                'points' => 200,
            ],
            [
                'name' => 'Century Club',
                'description' => 'Complete 100 tasks',
                'badge_icon' => '💯',
                'type' => 'task_completion',
                'criteria' => ['count' => 100],
                'points' => 500,
            ],
            [
                'name' => 'Master Scholar',
                'description' => 'Complete all 251 tasks',
                'badge_icon' => '👑',
                'type' => 'task_completion',
                'criteria' => ['count' => 251],
                'points' => 2000,
            ],

            // Streak Achievements
            [
                'name' => 'Consistency Beginner',
                'description' => 'Maintain a 3-day learning streak',
                'badge_icon' => '🔥',
                'type' => 'streak',
                'criteria' => ['current_streak' => 3],
                'points' => 30,
            ],
            [
                'name' => 'Week Warrior',
                'description' => 'Maintain a 7-day learning streak',
                'badge_icon' => '⚡',
                'type' => 'streak',
                'criteria' => ['current_streak' => 7],
                'points' => 100,
            ],
            [
                'name' => 'Two Week Champion',
                'description' => 'Maintain a 14-day learning streak',
                'badge_icon' => '💪',
                'type' => 'streak',
                'criteria' => ['current_streak' => 14],
                'points' => 250,
            ],
            [
                'name' => 'Monthly Master',
                'description' => 'Maintain a 30-day learning streak',
                'badge_icon' => '🏆',
                'type' => 'streak',
                'criteria' => ['current_streak' => 30],
                'points' => 500,
            ],
            [
                'name' => 'Unstoppable',
                'description' => 'Maintain a 100-day learning streak',
                'badge_icon' => '🌟',
                'type' => 'streak',
                'criteria' => ['current_streak' => 100],
                'points' => 2000,
            ],

            // Quality Achievements
            [
                'name' => 'Quality Conscious',
                'description' => 'Maintain an average rating of 8+ on 10 tasks',
                'badge_icon' => '⭐',
                'type' => 'quality',
                'criteria' => ['average_rating' => 8, 'min_tasks' => 10],
                'points' => 150,
            ],
            [
                'name' => 'Excellence Seeker',
                'description' => 'Maintain an average rating of 9+ on 20 tasks',
                'badge_icon' => '🌟',
                'type' => 'quality',
                'criteria' => ['average_rating' => 9, 'min_tasks' => 20],
                'points' => 400,
            ],
            [
                'name' => 'Perfectionist',
                'description' => 'Achieve a perfect 10 rating on 10 tasks',
                'badge_icon' => '💎',
                'type' => 'quality',
                'criteria' => ['perfect_count' => 10],
                'points' => 300,
            ],

            // Speed Achievements
            [
                'name' => 'Quick Learner',
                'description' => 'Complete 5 tasks in less than 50% of estimated time',
                'badge_icon' => '⚡',
                'type' => 'learning',
                'criteria' => ['fast_completions' => 5],
                'points' => 100,
            ],
            [
                'name' => 'Speed Demon',
                'description' => 'Complete 10 tasks in less than 50% of estimated time',
                'badge_icon' => '🚀',
                'type' => 'learning',
                'criteria' => ['fast_completions' => 10],
                'points' => 250,
            ],
            [
                'name' => 'Lightning Fast',
                'description' => 'Complete 20 tasks in less than 50% of estimated time',
                'badge_icon' => '⚡',
                'type' => 'learning',
                'criteria' => ['fast_completions' => 20],
                'points' => 500,
            ],

            // Learning Style Achievements
            [
                'name' => 'Code Warrior',
                'description' => 'Submit 50 code assignments',
                'badge_icon' => '💻',
                'type' => 'learning',
                'criteria' => ['code_submissions' => 50],
                'points' => 300,
            ],
            [
                'name' => 'Note Taker',
                'description' => 'Create 50 study notes',
                'badge_icon' => '📝',
                'type' => 'learning',
                'criteria' => ['notes_written' => 50],
                'points' => 200,
            ],
            [
                'name' => 'Quiz Master',
                'description' => 'Pass all quizzes on first attempt',
                'badge_icon' => '🎓',
                'type' => 'learning',
                'criteria' => ['perfect_quizzes' => true],
                'points' => 400,
            ],
            [
                'name' => 'Help Seeker',
                'description' => 'Ask 10 thoughtful questions',
                'badge_icon' => '❓',
                'type' => 'learning',
                'criteria' => ['questions_asked' => 10],
                'points' => 100,
            ],
            [
                'name' => 'Marathon Learner',
                'description' => 'Spend 100 hours learning',
                'badge_icon' => '⏰',
                'type' => 'learning',
                'criteria' => ['time_spent_hours' => 100],
                'points' => 500,
            ],

            // Milestone Achievements
            [
                'name' => 'Roadmap Rookie',
                'description' => 'Complete your first roadmap',
                'badge_icon' => '🎖️',
                'type' => 'milestone',
                'criteria' => ['roadmaps_completed' => 1],
                'points' => 300,
            ],
            [
                'name' => 'Triple Threat',
                'description' => 'Complete 3 roadmaps',
                'badge_icon' => '🥉',
                'type' => 'milestone',
                'criteria' => ['roadmaps_completed' => 3],
                'points' => 800,
            ],
            [
                'name' => 'Five Star Developer',
                'description' => 'Complete 5 roadmaps',
                'badge_icon' => '⭐',
                'type' => 'milestone',
                'criteria' => ['roadmaps_completed' => 5],
                'points' => 1500,
            ],
            [
                'name' => 'Ultimate Champion',
                'description' => 'Complete all 8 roadmaps',
                'badge_icon' => '🏅',
                'type' => 'milestone',
                'criteria' => ['roadmaps_completed' => 8],
                'points' => 3000,
            ],

            // Social Achievements
            [
                'name' => 'Helpful Hand',
                'description' => 'Help 10 students by answering their questions',
                'badge_icon' => '🤝',
                'type' => 'learning',
                'criteria' => ['answers_given' => 10],
                'points' => 250,
            ],
        ];

        foreach ($achievements as $achievement) {
            Achievement::create($achievement);
        }
    }
}
