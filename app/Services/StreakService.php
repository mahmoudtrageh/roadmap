<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StreakService
{
    /**
     * Update user's streak based on their activity.
     * Alias for backward compatibility.
     */
    public function updateStreak(User $user): void
    {
        $this->updateUserStreak($user);
    }

    /**
     * Update user's streak based on their activity.
     */
    public function updateUserStreak(User $user): void
    {
        $today = Carbon::today();
        $lastActivityDate = $user->last_activity_date ? Carbon::parse($user->last_activity_date) : null;

        // If user completed a task today, update their streak
        if ($this->hasActivityToday($user)) {
            if (!$lastActivityDate) {
                // First time activity
                $user->current_streak = 1;
                $user->longest_streak = max($user->longest_streak ?? 0, 1);
                $user->last_activity_date = $today;
            } elseif ($lastActivityDate->isSameDay($today)) {
                // Already counted for today, no change needed
                return;
            } elseif ($lastActivityDate->isYesterday()) {
                // Consecutive day, increment streak
                $user->current_streak = ($user->current_streak ?? 0) + 1;
                $user->longest_streak = max($user->longest_streak ?? 0, $user->current_streak);
                $user->last_activity_date = $today;
            } else {
                // Streak broken, start over
                $user->current_streak = 1;
                $user->longest_streak = max($user->longest_streak ?? 0, 1);
                $user->last_activity_date = $today;
            }

            $user->save();
        } elseif ($lastActivityDate && $lastActivityDate->isBefore($today->subDay())) {
            // No activity today and last activity was not yesterday, reset streak
            $this->resetStreak($user);
        }
    }

    /**
     * Check if user has a valid streak for today.
     */
    public function checkStreakForToday(User $user): bool
    {
        if (!$user->last_activity_date) {
            return false;
        }

        $lastActivityDate = Carbon::parse($user->last_activity_date);
        $today = Carbon::today();

        // Streak is valid if last activity was today or yesterday
        return $lastActivityDate->isSameDay($today) || $lastActivityDate->isYesterday();
    }

    /**
     * Reset user's current streak.
     */
    public function resetStreak(User $user): void
    {
        $user->current_streak = 0;
        $user->save();
    }

    /**
     * Check if user has completed any tasks today.
     */
    protected function hasActivityToday(User $user): bool
    {
        $today = Carbon::today();

        return $user->taskCompletions()
            ->where('status', 'completed')
            ->whereDate('completed_at', $today)
            ->exists();
    }

    /**
     * Calculate current streak based on task completion history.
     * This method recalculates from scratch and can be used to fix inconsistencies.
     */
    public function recalculateStreak(User $user): array
    {
        $completions = $user->taskCompletions()
            ->where('status', 'completed')
            ->whereNotNull('completed_at')
            ->orderBy('completed_at', 'desc')
            ->get()
            ->pluck('completed_at')
            ->map(fn($date) => Carbon::parse($date)->startOfDay())
            ->unique()
            ->values();

        if ($completions->isEmpty()) {
            return [
                'current_streak' => 0,
                'longest_streak' => 0,
                'last_activity_date' => null,
            ];
        }

        $currentStreak = 0;
        $longestStreak = 0;
        $tempStreak = 0;
        $today = Carbon::today();
        $expectedDate = $today;

        foreach ($completions as $date) {
            if ($date->isSameDay($expectedDate)) {
                $tempStreak++;

                // Count current streak only if it includes today or yesterday
                if ($currentStreak === 0 && ($date->isToday() || $date->isYesterday())) {
                    $currentStreak = $tempStreak;
                }

                $longestStreak = max($longestStreak, $tempStreak);
                $expectedDate = $date->copy()->subDay();
            } else {
                // Gap found, reset temp streak
                $tempStreak = 1;
                $longestStreak = max($longestStreak, $tempStreak);
                $expectedDate = $date->copy()->subDay();
            }
        }

        // If the most recent activity is not today or yesterday, current streak is 0
        if (!$completions->first()->isToday() && !$completions->first()->isYesterday()) {
            $currentStreak = 0;
        }

        return [
            'current_streak' => $currentStreak,
            'longest_streak' => $longestStreak,
            'last_activity_date' => $completions->first(),
        ];
    }

    /**
     * Update user streak from recalculated values.
     */
    public function updateStreakFromRecalculation(User $user): void
    {
        $streakData = $this->recalculateStreak($user);

        $user->current_streak = $streakData['current_streak'];
        $user->longest_streak = $streakData['longest_streak'];
        $user->last_activity_date = $streakData['last_activity_date'];
        $user->save();
    }

    /**
     * Get streak statistics for a user.
     */
    public function getStreakStats(User $user): array
    {
        return [
            'current_streak' => $user->current_streak ?? 0,
            'longest_streak' => $user->longest_streak ?? 0,
            'last_activity_date' => $user->last_activity_date,
            'is_active_today' => $this->hasActivityToday($user),
            'streak_valid' => $this->checkStreakForToday($user),
        ];
    }
}
