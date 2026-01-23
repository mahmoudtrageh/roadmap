<?php

namespace App\Services;

use App\Models\Roadmap;
use Illuminate\Support\Collection;

class StudyPreferenceService
{
    /**
     * Calculate task distribution based on daily study hours
     *
     * @param Roadmap $roadmap
     * @param int $dailyStudyHours (1-8 hours)
     * @return array ['days' => int, 'schedule' => array]
     */
    public function calculateSchedule(Roadmap $roadmap, int $dailyStudyHours): array
    {
        $dailyStudyMinutes = $dailyStudyHours * 60;

        // Get all tasks ordered by day and order
        $tasks = $roadmap->tasks()
            ->orderBy('day_number')
            ->orderBy('order')
            ->get();

        if ($tasks->isEmpty()) {
            return [
                'days' => 0,
                'schedule' => [],
                'total_time_minutes' => 0,
            ];
        }

        // Redistribute tasks across days based on study time
        $schedule = [];
        $currentDay = 1;
        $currentDayMinutes = 0;
        $dayTasks = [];

        foreach ($tasks as $task) {
            $taskMinutes = $task->estimated_time_minutes;

            // Check if adding this task exceeds daily limit
            if ($currentDayMinutes > 0 && ($currentDayMinutes + $taskMinutes) > $dailyStudyMinutes) {
                // Save current day and start new day
                $schedule[$currentDay] = [
                    'tasks' => $dayTasks,
                    'total_minutes' => $currentDayMinutes,
                ];

                $currentDay++;
                $currentDayMinutes = 0;
                $dayTasks = [];
            }

            // Add task to current day
            $dayTasks[] = [
                'id' => $task->id,
                'title' => $task->title,
                'estimated_time_minutes' => $taskMinutes,
                'original_day' => $task->day_number,
            ];
            $currentDayMinutes += $taskMinutes;
        }

        // Add the last day if it has tasks
        if (!empty($dayTasks)) {
            $schedule[$currentDay] = [
                'tasks' => $dayTasks,
                'total_minutes' => $currentDayMinutes,
            ];
        }

        $totalTimeMinutes = $tasks->sum('estimated_time_minutes');

        return [
            'days' => count($schedule),
            'schedule' => $schedule,
            'total_time_minutes' => $totalTimeMinutes,
            'original_days' => $roadmap->duration_days,
        ];
    }

    /**
     * Get available study hour options
     *
     * @return array
     */
    public function getStudyHourOptions(): array
    {
        return [
            1 => '1 hour per day (Relaxed pace)',
            2 => '2 hours per day (Recommended)',
            3 => '3 hours per day (Fast pace)',
            4 => '4 hours per day (Intensive)',
            5 => '5 hours per day (Very intensive)',
            6 => '6 hours per day (Full commitment)',
        ];
    }

    /**
     * Get task by day number in custom schedule
     *
     * @param array $schedule
     * @param int $dayNumber
     * @return array|null
     */
    public function getTasksByDay(array $schedule, int $dayNumber): ?array
    {
        return $schedule[$dayNumber] ?? null;
    }

    /**
     * Get the day number for a specific task in custom schedule
     *
     * @param array $schedule
     * @param int $taskId
     * @return int|null
     */
    public function getDayForTask(array $schedule, int $taskId): ?int
    {
        foreach ($schedule as $dayNumber => $dayData) {
            foreach ($dayData['tasks'] as $task) {
                if ($task['id'] === $taskId) {
                    return $dayNumber;
                }
            }
        }

        return null;
    }
}
