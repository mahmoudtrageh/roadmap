<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\StreakService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use App\Notifications\StreakAchievementNotification;

class UpdateUserStreaks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'streaks:update
                            {--recalculate : Recalculate streaks from scratch}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all users\' streaks and check for broken streaks';

    /**
     * Execute the console command.
     */
    public function handle(StreakService $streakService): int
    {
        $this->info('Starting streak updates...');

        $users = User::all();
        $totalUsers = $users->count();
        $brokenStreaks = 0;
        $activeStreaks = 0;
        $milestones = [];

        $this->withProgressBar($users, function ($user) use ($streakService, &$brokenStreaks, &$activeStreaks, &$milestones) {
            $previousStreak = $user->current_streak ?? 0;

            if ($this->option('recalculate')) {
                // Recalculate streak from scratch
                $streakService->updateStreakFromRecalculation($user);
            } else {
                // Regular streak update
                $streakService->updateUserStreak($user);
            }

            // Reload user to get updated streak values
            $user->refresh();
            $currentStreak = $user->current_streak ?? 0;

            // Track statistics
            if ($currentStreak === 0 && $previousStreak > 0) {
                $brokenStreaks++;
            } elseif ($currentStreak > 0) {
                $activeStreaks++;
            }

            // Check for streak milestones and send notifications
            $milestone = $this->checkStreakMilestone($user, $previousStreak, $currentStreak);
            if ($milestone) {
                $milestones[] = [
                    'user' => $user,
                    'milestone' => $milestone,
                ];

                // Send notification for streak achievement
                $user->notify(new StreakAchievementNotification($currentStreak, $milestone));
            }
        });

        $this->newLine(2);
        $this->info("Streak updates completed!");
        $this->table(
            ['Metric', 'Count'],
            [
                ['Total Users', $totalUsers],
                ['Active Streaks', $activeStreaks],
                ['Broken Streaks', $brokenStreaks],
                ['Milestone Achievements', count($milestones)],
            ]
        );

        // Display milestone achievements
        if (!empty($milestones)) {
            $this->newLine();
            $this->info('Streak Milestones Achieved:');
            foreach ($milestones as $item) {
                $this->line("  - {$item['user']->name}: {$item['milestone']} day streak!");
            }
        }

        return Command::SUCCESS;
    }

    /**
     * Check if user reached a streak milestone.
     */
    protected function checkStreakMilestone(User $user, int $previousStreak, int $currentStreak): ?int
    {
        // Define milestone thresholds
        $milestones = [7, 14, 30, 60, 90, 180, 365];

        foreach ($milestones as $milestone) {
            // Check if user just reached this milestone
            if ($currentStreak >= $milestone && $previousStreak < $milestone) {
                return $milestone;
            }
        }

        return null;
    }
}
