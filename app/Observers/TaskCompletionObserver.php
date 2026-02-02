<?php

namespace App\Observers;

use App\Models\TaskCompletion;
use App\Services\StreakService;
use App\Services\AchievementService;

class TaskCompletionObserver
{
    public function __construct(
        protected StreakService $streakService,
        protected AchievementService $achievementService
    ) {
    }

    /**
     * Handle the TaskCompletion "created" event.
     */
    public function created(TaskCompletion $taskCompletion): void
    {
        if ($taskCompletion->status === 'completed') {
            $this->handleCompletion($taskCompletion);
        }
    }

    /**
     * Handle the TaskCompletion "updated" event.
     */
    public function updated(TaskCompletion $taskCompletion): void
    {
        // Check if the task was just marked as completed
        if ($taskCompletion->status === 'completed' && $taskCompletion->isDirty('status')) {
            $this->handleCompletion($taskCompletion);
        }
    }

    /**
     * Handle the TaskCompletion "deleted" event.
     */
    public function deleted(TaskCompletion $taskCompletion): void
    {
        //
    }

    /**
     * Handle the TaskCompletion "restored" event.
     */
    public function restored(TaskCompletion $taskCompletion): void
    {
        //
    }

    /**
     * Handle the TaskCompletion "force deleted" event.
     */
    public function forceDeleted(TaskCompletion $taskCompletion): void
    {
        //
    }

    /**
     * Handle task completion logic.
     */
    protected function handleCompletion(TaskCompletion $taskCompletion): void
    {
        $user = $taskCompletion->student;

        if (!$user) {
            return;
        }

        // Update user streak
        $this->streakService->updateUserStreak($user);

        // Check and award achievements
        $this->achievementService->checkAndAwardAchievements($user);

        // Advance roadmap day if all tasks for current day are complete
        $this->advanceRoadmapDayIfComplete($taskCompletion);
    }

    /**
     * Advance roadmap day if all tasks for the current day are completed.
     */
    protected function advanceRoadmapDayIfComplete(TaskCompletion $taskCompletion): void
    {
        $enrollment = $taskCompletion->roadmapEnrollment;

        if (!$enrollment) {
            return;
        }

        $currentDay = $enrollment->current_day;

        // Get all tasks for the current day
        $tasksForCurrentDay = $enrollment->roadmap
            ->tasks()
            ->where('day_number', $currentDay)
            ->pluck('id');

        if ($tasksForCurrentDay->isEmpty()) {
            return;
        }

        // Get completed task IDs for this enrollment on the current day
        $completedTaskIds = $enrollment->taskCompletions()
            ->where('status', 'completed')
            ->whereIn('task_id', $tasksForCurrentDay)
            ->pluck('task_id');

        // Check if all tasks for the current day are completed
        $allTasksCompleted = $tasksForCurrentDay->count() === $completedTaskIds->count();

        if ($allTasksCompleted) {
            // Get the total number of days in the roadmap
            $totalDays = $enrollment->roadmap->tasks()->max('day_number');

            // Advance to next day if not already on the last day
            if ($currentDay < $totalDays) {
                $enrollment->current_day = $currentDay + 1;
                $enrollment->save();
            } elseif ($currentDay === $totalDays && $enrollment->status !== 'completed') {
                // Mark enrollment as completed if on the last day
                $enrollment->status = 'completed';
                $enrollment->completed_at = now();
                $enrollment->save();
            }
        }
    }
}
