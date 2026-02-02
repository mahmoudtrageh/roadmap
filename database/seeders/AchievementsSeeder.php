<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $achievements = [
            // Milestone Achievements
            [
                'key' => 'first_task',
                'name' => 'First Steps',
                'description' => 'Complete your first task',
                'icon' => '🎯',
                'category' => 'milestone',
                'requirement_value' => 1,
                'badge_color' => 'green',
                'points' => 10,
            ],
            [
                'key' => 'tasks_10',
                'name' => 'Getting Started',
                'description' => 'Complete 10 tasks',
                'icon' => '⭐',
                'category' => 'milestone',
                'requirement_value' => 10,
                'badge_color' => 'blue',
                'points' => 50,
            ],
            [
                'key' => 'tasks_25',
                'name' => 'Dedicated Learner',
                'description' => 'Complete 25 tasks',
                'icon' => '🌟',
                'category' => 'milestone',
                'requirement_value' => 25,
                'badge_color' => 'purple',
                'points' => 100,
            ],
            [
                'key' => 'tasks_50',
                'name' => 'Half Century',
                'description' => 'Complete 50 tasks',
                'icon' => '💫',
                'category' => 'milestone',
                'requirement_value' => 50,
                'badge_color' => 'indigo',
                'points' => 200,
            ],
            [
                'key' => 'tasks_100',
                'name' => 'Centurion',
                'description' => 'Complete 100 tasks',
                'icon' => '🏆',
                'category' => 'milestone',
                'requirement_value' => 100,
                'badge_color' => 'yellow',
                'points' => 500,
            ],
            [
                'key' => 'tasks_250',
                'name' => 'Master Learner',
                'description' => 'Complete 250 tasks',
                'icon' => '👑',
                'category' => 'milestone',
                'requirement_value' => 250,
                'badge_color' => 'orange',
                'points' => 1000,
            ],
            [
                'key' => 'tasks_500',
                'name' => 'Legend',
                'description' => 'Complete 500 tasks',
                'icon' => '💎',
                'category' => 'milestone',
                'requirement_value' => 500,
                'badge_color' => 'red',
                'points' => 2500,
            ],

            // Roadmap Achievements
            [
                'key' => 'first_roadmap',
                'name' => 'Path Completed',
                'description' => 'Complete your first roadmap',
                'icon' => '🗺️',
                'category' => 'roadmap',
                'requirement_value' => 1,
                'badge_color' => 'green',
                'points' => 100,
            ],
            [
                'key' => 'roadmaps_3',
                'name' => 'Road Warrior',
                'description' => 'Complete 3 roadmaps',
                'icon' => '🛣️',
                'category' => 'roadmap',
                'requirement_value' => 3,
                'badge_color' => 'blue',
                'points' => 300,
            ],
            [
                'key' => 'roadmaps_5',
                'name' => 'Journey Master',
                'description' => 'Complete 5 roadmaps',
                'icon' => '🚀',
                'category' => 'roadmap',
                'requirement_value' => 5,
                'badge_color' => 'purple',
                'points' => 500,
            ],
            [
                'key' => 'roadmaps_10',
                'name' => 'Expert Navigator',
                'description' => 'Complete 10 roadmaps',
                'icon' => '🌠',
                'category' => 'roadmap',
                'requirement_value' => 10,
                'badge_color' => 'yellow',
                'points' => 1000,
            ],

            // Streak Achievements
            [
                'key' => 'streak_3',
                'name' => 'Consistent',
                'description' => 'Maintain a 3-day learning streak',
                'icon' => '🔥',
                'category' => 'streak',
                'requirement_value' => 3,
                'badge_color' => 'orange',
                'points' => 30,
            ],
            [
                'key' => 'streak_7',
                'name' => 'Week Warrior',
                'description' => 'Maintain a 7-day learning streak',
                'icon' => '🔥',
                'category' => 'streak',
                'requirement_value' => 7,
                'badge_color' => 'orange',
                'points' => 70,
            ],
            [
                'key' => 'streak_14',
                'name' => 'Two Weeks Strong',
                'description' => 'Maintain a 14-day learning streak',
                'icon' => '🔥',
                'category' => 'streak',
                'requirement_value' => 14,
                'badge_color' => 'red',
                'points' => 150,
            ],
            [
                'key' => 'streak_30',
                'name' => 'Month Champion',
                'description' => 'Maintain a 30-day learning streak',
                'icon' => '🔥',
                'category' => 'streak',
                'requirement_value' => 30,
                'badge_color' => 'red',
                'points' => 300,
            ],
            [
                'key' => 'streak_60',
                'name' => 'Unstoppable',
                'description' => 'Maintain a 60-day learning streak',
                'icon' => '🔥',
                'category' => 'streak',
                'requirement_value' => 60,
                'badge_color' => 'red',
                'points' => 600,
            ],
            [
                'key' => 'streak_100',
                'name' => 'Streak Legend',
                'description' => 'Maintain a 100-day learning streak',
                'icon' => '🔥',
                'category' => 'streak',
                'requirement_value' => 100,
                'badge_color' => 'red',
                'points' => 1000,
            ],

            // Time-based Achievements
            [
                'key' => 'time_10_hours',
                'name' => 'Time Invested',
                'description' => 'Spend 10 hours learning',
                'icon' => '⏰',
                'category' => 'time',
                'requirement_value' => 10,
                'badge_color' => 'cyan',
                'points' => 50,
            ],
            [
                'key' => 'time_50_hours',
                'name' => 'Dedicated Student',
                'description' => 'Spend 50 hours learning',
                'icon' => '⏱️',
                'category' => 'time',
                'requirement_value' => 50,
                'badge_color' => 'cyan',
                'points' => 250,
            ],
            [
                'key' => 'time_100_hours',
                'name' => 'Hundred Hour Club',
                'description' => 'Spend 100 hours learning',
                'icon' => '⌚',
                'category' => 'time',
                'requirement_value' => 100,
                'badge_color' => 'teal',
                'points' => 500,
            ],
            [
                'key' => 'time_500_hours',
                'name' => 'Master of Time',
                'description' => 'Spend 500 hours learning',
                'icon' => '⏳',
                'category' => 'time',
                'requirement_value' => 500,
                'badge_color' => 'teal',
                'points' => 2500,
            ],

            // Quality Achievements
            [
                'key' => 'quality_perfectionist',
                'name' => 'Perfectionist',
                'description' => 'Complete 20 tasks with 9+ quality rating',
                'icon' => '✨',
                'category' => 'quality',
                'requirement_value' => 20,
                'badge_color' => 'pink',
                'points' => 200,
            ],
            [
                'key' => 'code_contributor',
                'name' => 'Code Contributor',
                'description' => 'Submit code for 10 tasks',
                'icon' => '💻',
                'category' => 'quality',
                'requirement_value' => 10,
                'badge_color' => 'indigo',
                'points' => 100,
            ],
            [
                'key' => 'fast_learner',
                'name' => 'Fast Learner',
                'description' => 'Complete 25 tasks faster than estimated',
                'icon' => '⚡',
                'category' => 'quality',
                'requirement_value' => 25,
                'badge_color' => 'yellow',
                'points' => 250,
            ],
        ];

        foreach ($achievements as $achievement) {
            Achievement::updateOrCreate(
                ['key' => $achievement['key']],
                $achievement
            );
        }
    }
}
