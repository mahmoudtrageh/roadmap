<?php

namespace App\Services;

use App\Models\Achievement;
use App\Models\User;
use App\Models\UserAchievement;
use App\Models\TaskCompletion;
use App\Models\RoadmapEnrollment;
use Carbon\Carbon;

class AchievementService
{
    /**
     * Check and award achievements for a user
     */
    public function checkAndAwardAchievements(User $user): array
    {
        $newAchievements = [];

        // Get user stats
        $stats = $this->getUserStats($user);

        // Check all active achievements
        $achievements = Achievement::where('is_active', true)->get();

        foreach ($achievements as $achievement) {
            // Skip if user already has this achievement
            if ($user->achievements()->where('achievement_id', $achievement->id)->exists()) {
                continue;
            }

            // Check if user qualifies for this achievement
            if ($this->qualifiesForAchievement($user, $achievement, $stats)) {
                $this->awardAchievement($user, $achievement, $stats);
                $newAchievements[] = $achievement;
            }
        }

        return $newAchievements;
    }

    /**
     * Check if user qualifies for specific achievement
     */
    protected function qualifiesForAchievement(User $user, Achievement $achievement, array $stats): bool
    {
        switch ($achievement->key) {
            // Milestone achievements
            case 'first_task':
                return $stats['completed_tasks'] >= 1;
            case 'tasks_10':
                return $stats['completed_tasks'] >= 10;
            case 'tasks_25':
                return $stats['completed_tasks'] >= 25;
            case 'tasks_50':
                return $stats['completed_tasks'] >= 50;
            case 'tasks_100':
                return $stats['completed_tasks'] >= 100;
            case 'tasks_250':
                return $stats['completed_tasks'] >= 250;
            case 'tasks_500':
                return $stats['completed_tasks'] >= 500;

            // Roadmap achievements
            case 'first_roadmap':
                return $stats['completed_roadmaps'] >= 1;
            case 'roadmaps_3':
                return $stats['completed_roadmaps'] >= 3;
            case 'roadmaps_5':
                return $stats['completed_roadmaps'] >= 5;
            case 'roadmaps_10':
                return $stats['completed_roadmaps'] >= 10;

            // Streak achievements
            case 'streak_3':
                return $user->current_streak >= 3;
            case 'streak_7':
                return $user->current_streak >= 7;
            case 'streak_14':
                return $user->current_streak >= 14;
            case 'streak_30':
                return $user->current_streak >= 30;
            case 'streak_60':
                return $user->current_streak >= 60;
            case 'streak_100':
                return $user->current_streak >= 100;

            // Time-based achievements
            case 'time_10_hours':
                return $stats['total_time_minutes'] >= 600; // 10 hours
            case 'time_50_hours':
                return $stats['total_time_minutes'] >= 3000; // 50 hours
            case 'time_100_hours':
                return $stats['total_time_minutes'] >= 6000; // 100 hours
            case 'time_500_hours':
                return $stats['total_time_minutes'] >= 30000; // 500 hours

            // Quality achievements
            case 'quality_perfectionist':
                return $stats['high_quality_tasks'] >= 20; // 20 tasks with 9+ rating
            case 'code_contributor':
                return $stats['code_submissions'] >= 10;
            case 'fast_learner':
                return $stats['tasks_faster_than_estimated'] >= 25;

            default:
                return false;
        }
    }

    /**
     * Award achievement to user
     */
    protected function awardAchievement(User $user, Achievement $achievement, array $stats): void
    {
        UserAchievement::create([
            'user_id' => $user->id,
            'achievement_id' => $achievement->id,
            'earned_at' => now(),
            'metadata' => [
                'stats_at_earning' => $stats,
            ],
        ]);
    }

    /**
     * Get user statistics for achievement checking
     */
    public function getUserStats(User $user): array
    {
        $completedTasks = TaskCompletion::where('student_id', $user->id)
            ->where('status', 'completed')
            ->get();

        return [
            'completed_tasks' => $completedTasks->count(),
            'completed_roadmaps' => RoadmapEnrollment::where('student_id', $user->id)
                ->where('status', 'completed')
                ->count(),
            'total_time_minutes' => $completedTasks->sum('time_spent_minutes') ?? 0,
            'high_quality_tasks' => $completedTasks->where('quality_rating', '>=', 9)->count(),
            'code_submissions' => $user->codeSubmissions()->count(),
            'tasks_faster_than_estimated' => $completedTasks->filter(function ($completion) {
                return $completion->time_spent_minutes < ($completion->task->estimated_time_minutes ?? 0);
            })->count(),
            'current_streak' => $user->current_streak ?? 0,
            'longest_streak' => $user->longest_streak ?? 0,
        ];
    }

    /**
     * Get achievement progress for display
     */
    public function getAchievementProgress(User $user): array
    {
        $stats = $this->getUserStats($user);
        $allAchievements = Achievement::where('is_active', true)->get();
        $earnedAchievements = $user->achievements()->get();

        return [
            'earned' => $earnedAchievements,
            'in_progress' => $allAchievements->reject(function ($achievement) use ($earnedAchievements) {
                return $earnedAchievements->contains('id', $achievement->id);
            })->map(function ($achievement) use ($user, $stats) {
                return [
                    'achievement' => $achievement,
                    'progress' => $this->calculateProgress($achievement, $stats),
                    'current' => $this->getCurrentValue($achievement, $stats),
                    'required' => $achievement->requirement_value,
                ];
            })->values(),
            'stats' => $stats,
        ];
    }

    /**
     * Calculate progress percentage for an achievement
     */
    protected function calculateProgress(Achievement $achievement, array $stats): int
    {
        $current = $this->getCurrentValue($achievement, $stats);
        $required = $achievement->requirement_value ?? 1;

        return min(100, (int) (($current / $required) * 100));
    }

    /**
     * Get current value for achievement requirement
     */
    protected function getCurrentValue(Achievement $achievement, array $stats): int
    {
        return match ($achievement->category) {
            'milestone' => $stats['completed_tasks'],
            'roadmap' => $stats['completed_roadmaps'],
            'streak' => $stats['current_streak'],
            'time' => (int) ($stats['total_time_minutes'] / 60),
            'quality' => $stats['high_quality_tasks'],
            default => 0,
        };
    }
}
