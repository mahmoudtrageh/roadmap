<?php

namespace App\Services;

use App\Models\User;

class PointsService
{
    /**
     * Level thresholds and titles
     */
    private const LEVELS = [
        1 => ['points' => 0, 'title' => 'Beginner'],
        2 => ['points' => 100, 'title' => 'Novice Coder'],
        3 => ['points' => 250, 'title' => 'Code Apprentice'],
        4 => ['points' => 500, 'title' => 'Junior Developer'],
        5 => ['points' => 1000, 'title' => 'Developer'],
        6 => ['points' => 2000, 'title' => 'Skilled Developer'],
        7 => ['points' => 3500, 'title' => 'Senior Developer'],
        8 => ['points' => 5500, 'title' => 'Expert Developer'],
        9 => ['points' => 8000, 'title' => 'Master Developer'],
        10 => ['points' => 11000, 'title' => 'Lead Developer'],
        11 => ['points' => 15000, 'title' => 'Principal Engineer'],
        12 => ['points' => 20000, 'title' => 'Architect'],
        13 => ['points' => 26000, 'title' => 'Tech Lead'],
        14 => ['points' => 33000, 'title' => 'Engineering Manager'],
        15 => ['points' => 41000, 'title' => 'Staff Engineer'],
        16 => ['points' => 50000, 'title' => 'Distinguished Engineer'],
        17 => ['points' => 60000, 'title' => 'Fellow'],
        18 => ['points' => 72000, 'title' => 'Chief Architect'],
        19 => ['points' => 85000, 'title' => 'CTO'],
        20 => ['points' => 100000, 'title' => 'Legend'],
    ];

    /**
     * Award points to a user
     */
    public function awardPoints(User $user, int $points, string $reason = null): void
    {
        $user->total_points += $points;
        $this->updateLevel($user);
        $user->save();
    }

    /**
     * Award points for task completion
     */
    public function awardTaskCompletion(User $user, string $taskDifficulty = 'moderate', int $qualityRating = null): int
    {
        $points = match($taskDifficulty) {
            'light' => 10,
            'moderate' => 25,
            'project' => 50,
            default => 25,
        };

        // Bonus for high quality ratings
        if ($qualityRating >= 9) {
            $points += 15;
        } elseif ($qualityRating >= 8) {
            $points += 10;
        }

        $this->awardPoints($user, $points, 'Task completion');
        return $points;
    }

    /**
     * Award points for code submission
     */
    public function awardCodeSubmission(User $user): int
    {
        $points = 20;
        $this->awardPoints($user, $points, 'Code submission');
        return $points;
    }

    /**
     * Award points for approved code review
     */
    public function awardCodeApproval(User $user, int $rating = null): int
    {
        $points = 30;

        // Bonus for excellent code
        if ($rating >= 9) {
            $points += 20;
        } elseif ($rating >= 8) {
            $points += 10;
        }

        $this->awardPoints($user, $points, 'Code approved');
        return $points;
    }

    /**
     * Award points for quiz completion
     */
    public function awardQuizCompletion(User $user, bool $passed, bool $firstAttempt = false): int
    {
        if (!$passed) {
            return 0;
        }

        $points = $firstAttempt ? 25 : 10;
        $this->awardPoints($user, $points, 'Quiz completion');
        return $points;
    }

    /**
     * Award points for daily streak
     */
    public function awardStreakMaintenance(User $user, int $streakDays): int
    {
        $points = 5;

        // Bonus for longer streaks
        if ($streakDays >= 30) {
            $points += 10;
        } elseif ($streakDays >= 14) {
            $points += 7;
        } elseif ($streakDays >= 7) {
            $points += 5;
        }

        $this->awardPoints($user, $points, 'Streak maintenance');
        return $points;
    }

    /**
     * Award points for helping peers
     */
    public function awardHelpingPeer(User $user): int
    {
        $points = 15;
        $this->awardPoints($user, $points, 'Helping peer');
        return $points;
    }

    /**
     * Update user's level based on total points
     */
    private function updateLevel(User $user): void
    {
        $currentLevel = 1;
        $currentTitle = 'Beginner';

        foreach (self::LEVELS as $level => $data) {
            if ($user->total_points >= $data['points']) {
                $currentLevel = $level;
                $currentTitle = $data['title'];
            } else {
                break;
            }
        }

        $user->current_level = $currentLevel;
        $user->level_title = $currentTitle;
    }

    /**
     * Get points needed for next level
     */
    public function getPointsToNextLevel(User $user): ?int
    {
        $nextLevel = $user->current_level + 1;

        if (!isset(self::LEVELS[$nextLevel])) {
            return null; // Max level reached
        }

        return self::LEVELS[$nextLevel]['points'] - $user->total_points;
    }

    /**
     * Get progress percentage to next level
     */
    public function getLevelProgress(User $user): float
    {
        $currentLevelPoints = self::LEVELS[$user->current_level]['points'];
        $nextLevel = $user->current_level + 1;

        if (!isset(self::LEVELS[$nextLevel])) {
            return 100; // Max level
        }

        $nextLevelPoints = self::LEVELS[$nextLevel]['points'];
        $pointsInCurrentLevel = $user->total_points - $currentLevelPoints;
        $pointsNeededForLevel = $nextLevelPoints - $currentLevelPoints;

        return ($pointsInCurrentLevel / $pointsNeededForLevel) * 100;
    }

    /**
     * Get all level data
     */
    public function getLevels(): array
    {
        return self::LEVELS;
    }
}
