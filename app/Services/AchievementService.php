<?php

namespace App\Services;

use App\Models\Achievement;
use App\Models\User;
use App\Models\UserAchievement;
use Illuminate\Support\Facades\DB;

class AchievementService
{
    /**
     * Check and award all eligible achievements for a user.
     */
    public function checkAndAwardAchievements(User $user): void
    {
        $achievements = Achievement::all();

        foreach ($achievements as $achievement) {
            if (!$this->hasEarnedAchievement($user, $achievement)) {
                if ($this->checkAchievementCriteria($user, $achievement)) {
                    $this->awardAchievement($user, $achievement);
                }
            }
        }
    }

    /**
     * Check if user has already earned a specific achievement.
     */
    public function hasEarnedAchievement(User $user, Achievement $achievement): bool
    {
        return UserAchievement::where('user_id', $user->id)
            ->where('achievement_id', $achievement->id)
            ->exists();
    }

    /**
     * Award an achievement to a user.
     */
    public function awardAchievement(User $user, Achievement $achievement, array $metadata = []): UserAchievement
    {
        return UserAchievement::create([
            'user_id' => $user->id,
            'achievement_id' => $achievement->id,
            'earned_at' => now(),
            'metadata' => $metadata,
        ]);
    }

    /**
     * Get user's achievement progress.
     */
    public function getUserAchievementProgress(User $user): array
    {
        $achievements = Achievement::all();
        $earnedAchievements = $user->achievements()->with('achievement')->get();

        $progress = [
            'total_achievements' => $achievements->count(),
            'earned_achievements' => $earnedAchievements->count(),
            'total_points' => $earnedAchievements->sum(fn($ua) => $ua->achievement->points),
            'achievements' => [],
        ];

        foreach ($achievements as $achievement) {
            $earned = $earnedAchievements->firstWhere('achievement_id', $achievement->id);

            $progress['achievements'][] = [
                'id' => $achievement->id,
                'name' => $achievement->name,
                'description' => $achievement->description,
                'badge_icon' => $achievement->badge_icon,
                'type' => $achievement->type,
                'points' => $achievement->points,
                'earned' => $earned !== null,
                'earned_at' => $earned?->earned_at,
                'metadata' => $earned?->metadata,
                'progress' => $this->getAchievementProgress($user, $achievement),
            ];
        }

        return $progress;
    }

    /**
     * Check if achievement criteria is met based on type.
     */
    protected function checkAchievementCriteria(User $user, Achievement $achievement): bool
    {
        $criteria = $achievement->criteria;
        $type = $achievement->type;

        // Ensure criteria is an array
        if (is_string($criteria)) {
            $criteria = json_decode($criteria, true) ?? [];
        }

        if (!is_array($criteria)) {
            return false;
        }

        return match($type) {
            'task_completion' => $this->checkTaskCompletionCriteria($user, $criteria),
            'streak' => $this->checkStreakCriteria($user, $criteria),
            'milestone' => $this->checkMilestoneCriteria($user, $criteria),
            'quality' => $this->checkQualityCriteria($user, $criteria),
            'learning' => $this->checkLearningCriteria($user, $criteria),
            default => false,
        };
    }

    /**
     * Check task completion criteria.
     */
    protected function checkTaskCompletionCriteria(User $user, array $criteria): bool
    {
        $completedTasksCount = $user->taskCompletions()
            ->where('status', 'completed')
            ->count();

        if (isset($criteria['count'])) {
            return $completedTasksCount >= $criteria['count'];
        }

        if (isset($criteria['min_count'])) {
            return $completedTasksCount >= $criteria['min_count'];
        }

        return false;
    }

    /**
     * Check streak criteria.
     */
    protected function checkStreakCriteria(User $user, array $criteria): bool
    {
        if (isset($criteria['current_streak'])) {
            return $user->current_streak >= $criteria['current_streak'];
        }

        if (isset($criteria['longest_streak'])) {
            return $user->longest_streak >= $criteria['longest_streak'];
        }

        return false;
    }

    /**
     * Check milestone criteria.
     */
    protected function checkMilestoneCriteria(User $user, array $criteria): bool
    {
        if (isset($criteria['roadmaps_completed'])) {
            $completedRoadmaps = $user->enrollments()
                ->where('status', 'completed')
                ->count();

            return $completedRoadmaps >= $criteria['roadmaps_completed'];
        }

        if (isset($criteria['roadmaps_enrolled'])) {
            $enrolledRoadmaps = $user->enrollments()->count();

            return $enrolledRoadmaps >= $criteria['roadmaps_enrolled'];
        }

        return false;
    }

    /**
     * Check quality criteria.
     */
    protected function checkQualityCriteria(User $user, array $criteria): bool
    {
        if (isset($criteria['average_rating']) && isset($criteria['min_tasks'])) {
            $averageRating = $user->taskCompletions()
                ->whereNotNull('quality_rating')
                ->avg('quality_rating');

            $ratedTasksCount = $user->taskCompletions()
                ->whereNotNull('quality_rating')
                ->count();

            return $ratedTasksCount >= $criteria['min_tasks']
                && $averageRating >= $criteria['average_rating'];
        }

        if (isset($criteria['high_quality_tasks'])) {
            $highQualityCount = $user->taskCompletions()
                ->where('quality_rating', '>=', 4)
                ->count();

            return $highQualityCount >= $criteria['high_quality_tasks'];
        }

        return false;
    }

    /**
     * Check learning criteria.
     */
    protected function checkLearningCriteria(User $user, array $criteria): bool
    {
        if (isset($criteria['code_submissions'])) {
            $submissionsCount = $user->codeSubmissions()->count();

            return $submissionsCount >= $criteria['code_submissions'];
        }

        if (isset($criteria['notes_written'])) {
            $notesCount = $user->notes()->count();

            return $notesCount >= $criteria['notes_written'];
        }

        if (isset($criteria['time_spent_hours'])) {
            $totalTimeMinutes = $user->taskCompletions()
                ->sum('time_spent_minutes');

            $totalTimeHours = $totalTimeMinutes / 60;

            return $totalTimeHours >= $criteria['time_spent_hours'];
        }

        return false;
    }

    /**
     * Get progress towards an achievement (0-100).
     */
    protected function getAchievementProgress(User $user, Achievement $achievement): int
    {
        $criteria = $achievement->criteria;
        $type = $achievement->type;

        // Ensure criteria is an array
        if (is_string($criteria)) {
            $criteria = json_decode($criteria, true) ?? [];
        }

        if (!is_array($criteria)) {
            return 0;
        }

        return match($type) {
            'task_completion' => $this->getTaskCompletionProgress($user, $criteria),
            'streak' => $this->getStreakProgress($user, $criteria),
            'milestone' => $this->getMilestoneProgress($user, $criteria),
            'quality' => $this->getQualityProgress($user, $criteria),
            'learning' => $this->getLearningProgress($user, $criteria),
            default => 0,
        };
    }

    /**
     * Get task completion progress percentage.
     */
    protected function getTaskCompletionProgress(User $user, array $criteria): int
    {
        $completedTasksCount = $user->taskCompletions()
            ->where('status', 'completed')
            ->count();

        $required = $criteria['count'] ?? $criteria['min_count'] ?? 1;

        return min(100, (int)(($completedTasksCount / $required) * 100));
    }

    /**
     * Get streak progress percentage.
     */
    protected function getStreakProgress(User $user, array $criteria): int
    {
        $currentStreak = $user->current_streak ?? 0;
        $required = $criteria['current_streak'] ?? $criteria['longest_streak'] ?? 1;

        return min(100, (int)(($currentStreak / $required) * 100));
    }

    /**
     * Get milestone progress percentage.
     */
    protected function getMilestoneProgress(User $user, array $criteria): int
    {
        if (isset($criteria['roadmaps_completed'])) {
            $completedRoadmaps = $user->enrollments()
                ->where('status', 'completed')
                ->count();

            return min(100, (int)(($completedRoadmaps / $criteria['roadmaps_completed']) * 100));
        }

        if (isset($criteria['roadmaps_enrolled'])) {
            $enrolledRoadmaps = $user->enrollments()->count();

            return min(100, (int)(($enrolledRoadmaps / $criteria['roadmaps_enrolled']) * 100));
        }

        return 0;
    }

    /**
     * Get quality progress percentage.
     */
    protected function getQualityProgress(User $user, array $criteria): int
    {
        if (isset($criteria['high_quality_tasks'])) {
            $highQualityCount = $user->taskCompletions()
                ->where('quality_rating', '>=', 4)
                ->count();

            return min(100, (int)(($highQualityCount / $criteria['high_quality_tasks']) * 100));
        }

        return 0;
    }

    /**
     * Get learning progress percentage.
     */
    protected function getLearningProgress(User $user, array $criteria): int
    {
        if (isset($criteria['code_submissions'])) {
            $submissionsCount = $user->codeSubmissions()->count();

            return min(100, (int)(($submissionsCount / $criteria['code_submissions']) * 100));
        }

        if (isset($criteria['notes_written'])) {
            $notesCount = $user->notes()->count();

            return min(100, (int)(($notesCount / $criteria['notes_written']) * 100));
        }

        if (isset($criteria['time_spent_hours'])) {
            $totalTimeMinutes = $user->taskCompletions()->sum('time_spent_minutes');
            $totalTimeHours = $totalTimeMinutes / 60;

            return min(100, (int)(($totalTimeHours / $criteria['time_spent_hours']) * 100));
        }

        return 0;
    }
}
