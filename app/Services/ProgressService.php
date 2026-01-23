<?php

namespace App\Services;

use App\Models\Roadmap;
use App\Models\RoadmapEnrollment;
use Illuminate\Support\Facades\DB;

class ProgressService
{
    /**
     * Calculate progress percentage for an enrollment.
     */
    public function calculateProgress(RoadmapEnrollment $enrollment): int
    {
        if (!$enrollment->roadmap) {
            return 0;
        }

        $totalTasks = $this->getTotalTasksCount($enrollment->roadmap);

        if ($totalTasks === 0) {
            return 0;
        }

        $completedTasks = $this->getCompletedTasksCount($enrollment);

        return (int) round(($completedTasks / $totalTasks) * 100);
    }

    /**
     * Get the count of completed tasks for an enrollment.
     */
    public function getCompletedTasksCount(RoadmapEnrollment $enrollment): int
    {
        return $enrollment->taskCompletions()
            ->where('status', 'completed')
            ->count();
    }

    /**
     * Get the total count of tasks in a roadmap.
     */
    public function getTotalTasksCount(Roadmap $roadmap): int
    {
        return $roadmap->tasks()->count();
    }

    /**
     * Advance enrollment to the next day.
     */
    public function advanceToNextDay(RoadmapEnrollment $enrollment): void
    {
        $currentDay = $enrollment->current_day ?? 1;
        $maxDay = $enrollment->roadmap->duration_days;

        if ($currentDay < $maxDay) {
            $enrollment->current_day = $currentDay + 1;
            $enrollment->save();
        }
    }

    /**
     * Update current day based on enrollment progress and task completions.
     */
    public function updateCurrentDay(RoadmapEnrollment $enrollment): void
    {
        // Get the highest day number from completed tasks
        $highestCompletedDay = $enrollment->taskCompletions()
            ->where('status', 'completed')
            ->join('tasks', 'task_completions.task_id', '=', 'tasks.id')
            ->where('tasks.roadmap_id', $enrollment->roadmap_id)
            ->max('tasks.day_number');

        if ($highestCompletedDay !== null) {
            // Move to the next day after the highest completed day
            $newCurrentDay = min($highestCompletedDay + 1, $enrollment->roadmap->duration_days);

            if ($newCurrentDay > ($enrollment->current_day ?? 1)) {
                $enrollment->current_day = $newCurrentDay;
                $enrollment->save();
            }
        }
    }

    /**
     * Check if all tasks for a specific day are completed.
     */
    public function isDayCompleted(RoadmapEnrollment $enrollment, int $dayNumber): bool
    {
        $tasksForDay = $enrollment->roadmap->tasks()
            ->where('day_number', $dayNumber)
            ->pluck('id');

        if ($tasksForDay->isEmpty()) {
            return false;
        }

        $completedTaskIds = $enrollment->taskCompletions()
            ->where('status', 'completed')
            ->whereIn('task_id', $tasksForDay)
            ->pluck('task_id');

        return $tasksForDay->count() === $completedTaskIds->count();
    }

    /**
     * Get detailed progress statistics for an enrollment.
     */
    public function getProgressStats(RoadmapEnrollment $enrollment): array
    {
        if (!$enrollment->roadmap) {
            return [
                'total_tasks' => 0,
                'completed_tasks' => 0,
                'in_progress_tasks' => 0,
                'remaining_tasks' => 0,
                'progress_percentage' => 0,
                'current_day' => 1,
                'total_days' => 0,
                'completed_days' => 0,
                'days_percentage' => 0,
            ];
        }

        $totalTasks = $this->getTotalTasksCount($enrollment->roadmap);
        $completedTasks = $this->getCompletedTasksCount($enrollment);
        $inProgressTasks = $enrollment->taskCompletions()
            ->where('status', 'in_progress')
            ->count();

        $currentDay = $enrollment->current_day ?? 1;
        $totalDays = $enrollment->roadmap->duration_days;

        $completedDays = 0;
        for ($day = 1; $day < $currentDay; $day++) {
            if ($this->isDayCompleted($enrollment, $day)) {
                $completedDays++;
            }
        }

        return [
            'total_tasks' => $totalTasks,
            'completed_tasks' => $completedTasks,
            'in_progress_tasks' => $inProgressTasks,
            'remaining_tasks' => $totalTasks - $completedTasks,
            'progress_percentage' => $this->calculateProgress($enrollment),
            'current_day' => $currentDay,
            'total_days' => $totalDays,
            'completed_days' => $completedDays,
            'days_percentage' => $totalDays > 0 ? (int) round(($currentDay / $totalDays) * 100) : 0,
        ];
    }

    /**
     * Mark enrollment as completed if all tasks are done.
     */
    public function checkAndMarkComplete(RoadmapEnrollment $enrollment): bool
    {
        $totalTasks = $this->getTotalTasksCount($enrollment->roadmap);
        $completedTasks = $this->getCompletedTasksCount($enrollment);

        if ($totalTasks > 0 && $completedTasks >= $totalTasks && $enrollment->status !== 'completed') {
            $enrollment->status = 'completed';
            $enrollment->completed_at = now();
            $enrollment->save();

            return true;
        }

        return false;
    }

    /**
     * Get tasks for a specific day in the enrollment.
     */
    public function getTasksForDay(RoadmapEnrollment $enrollment, int $dayNumber): array
    {
        $tasks = $enrollment->roadmap->tasks()
            ->where('day_number', $dayNumber)
            ->orderBy('order')
            ->get();

        $completedTaskIds = $enrollment->taskCompletions()
            ->where('status', 'completed')
            ->pluck('task_id')
            ->toArray();

        $inProgressTaskIds = $enrollment->taskCompletions()
            ->where('status', 'in_progress')
            ->pluck('task_id')
            ->toArray();

        return $tasks->map(function ($task) use ($completedTaskIds, $inProgressTaskIds) {
            return [
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'estimated_time_minutes' => $task->estimated_time_minutes,
                'task_type' => $task->task_type,
                'category' => $task->category,
                'order' => $task->order,
                'status' => in_array($task->id, $completedTaskIds)
                    ? 'completed'
                    : (in_array($task->id, $inProgressTaskIds) ? 'in_progress' : 'not_started'),
            ];
        })->toArray();
    }

    /**
     * Get progress by category for an enrollment.
     */
    public function getProgressByCategory(RoadmapEnrollment $enrollment): array
    {
        $tasks = $enrollment->roadmap->tasks;
        $completedTaskIds = $enrollment->taskCompletions()
            ->where('status', 'completed')
            ->pluck('task_id');

        $categories = $tasks->groupBy('category');
        $categoryProgress = [];

        foreach ($categories as $category => $categoryTasks) {
            $total = $categoryTasks->count();
            $completed = $categoryTasks->whereIn('id', $completedTaskIds)->count();

            $categoryProgress[$category] = [
                'total' => $total,
                'completed' => $completed,
                'percentage' => $total > 0 ? (int) round(($completed / $total) * 100) : 0,
            ];
        }

        return $categoryProgress;
    }
}
