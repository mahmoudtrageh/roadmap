<?php

namespace App\Services;

use App\Models\RoadmapEnrollment;
use App\Models\Task;
use Carbon\Carbon;

class ScheduleService
{
    /**
     * Generate an auto-schedule based on weekly hours and task estimates.
     */
    public function generateSchedule(RoadmapEnrollment $enrollment, int $weeklyHours): array
    {
        $tasks = $enrollment->roadmap->tasks()
            ->orderBy('day_number')
            ->orderBy('order')
            ->get();

        // Calculate daily available minutes
        // Weight: Weekends get 40% more time, weekdays get standard time
        $weekdayMultiplier = 0.8;
        $weekendMultiplier = 1.5;

        // Distribute weekly hours
        $totalWeightedDays = (5 * $weekdayMultiplier) + (2 * $weekendMultiplier);
        $baseMinutesPerDay = ($weeklyHours * 60) / $totalWeightedDays;

        $schedule = [];
        $currentDate = now()->startOfDay();
        $currentDayMinutes = 0;
        $dailyTasks = [];

        foreach ($tasks as $task) {
            $taskMinutes = $task->estimated_time_minutes ?? 60;

            // Determine available minutes for current day
            $isWeekend = $currentDate->isWeekend();
            $availableMinutes = $isWeekend
                ? $baseMinutesPerDay * $weekendMultiplier
                : $baseMinutesPerDay * $weekdayMultiplier;

            // If task doesn't fit in current day, move to next day
            if ($currentDayMinutes + $taskMinutes > $availableMinutes && count($dailyTasks) > 0) {
                // Save current day's tasks
                $schedule[] = [
                    'date' => $currentDate->toDateString(),
                    'day_of_week' => $currentDate->format('l'),
                    'is_weekend' => $isWeekend,
                    'tasks' => $dailyTasks,
                    'total_minutes' => $currentDayMinutes,
                    'available_minutes' => round($availableMinutes),
                ];

                // Move to next day
                $currentDate = $currentDate->addDay();
                $currentDayMinutes = 0;
                $dailyTasks = [];
            }

            // Add task to current day
            $dailyTasks[] = [
                'task_id' => $task->id,
                'task_title' => $task->title,
                'estimated_minutes' => $taskMinutes,
                'day_number' => $task->day_number,
            ];

            $currentDayMinutes += $taskMinutes;
        }

        // Add remaining tasks
        if (count($dailyTasks) > 0) {
            $isWeekend = $currentDate->isWeekend();
            $availableMinutes = $isWeekend
                ? $baseMinutesPerDay * $weekendMultiplier
                : $baseMinutesPerDay * $weekdayMultiplier;

            $schedule[] = [
                'date' => $currentDate->toDateString(),
                'day_of_week' => $currentDate->format('l'),
                'is_weekend' => $isWeekend,
                'tasks' => $dailyTasks,
                'total_minutes' => $currentDayMinutes,
                'available_minutes' => round($availableMinutes),
            ];
        }

        return $schedule;
    }

    /**
     * Get schedule summary statistics.
     */
    public function getScheduleSummary(array $schedule): array
    {
        $totalDays = count($schedule);
        $totalTasks = 0;
        $totalMinutes = 0;
        $weekdayCount = 0;
        $weekendCount = 0;

        foreach ($schedule as $day) {
            $totalTasks += count($day['tasks']);
            $totalMinutes += $day['total_minutes'];

            if ($day['is_weekend']) {
                $weekendCount++;
            } else {
                $weekdayCount++;
            }
        }

        $startDate = $schedule[0]['date'] ?? now()->toDateString();
        $endDate = $schedule[count($schedule) - 1]['date'] ?? now()->toDateString();

        return [
            'total_days' => $totalDays,
            'weekdays' => $weekdayCount,
            'weekends' => $weekendCount,
            'total_tasks' => $totalTasks,
            'total_hours' => round($totalMinutes / 60, 1),
            'total_minutes' => $totalMinutes,
            'avg_minutes_per_day' => $totalDays > 0 ? round($totalMinutes / $totalDays) : 0,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'duration_weeks' => round($totalDays / 7, 1),
        ];
    }

    /**
     * Check if student is on schedule.
     */
    public function checkScheduleAdherence(RoadmapEnrollment $enrollment): array
    {
        if (!$enrollment->auto_schedule) {
            return [
                'has_schedule' => false,
                'message' => 'No schedule configured',
            ];
        }

        $schedule = $enrollment->auto_schedule;
        $today = now()->toDateString();

        // Count tasks that should have been completed by today
        $tasksDue = 0;
        $tasksDueIds = [];

        foreach ($schedule as $day) {
            if ($day['date'] < $today) {
                $tasksDue += count($day['tasks']);
                foreach ($day['tasks'] as $task) {
                    $tasksDueIds[] = $task['task_id'];
                }
            }
        }

        // Count actually completed tasks
        $tasksCompleted = $enrollment->taskCompletions()
            ->whereIn('task_id', $tasksDueIds)
            ->whereIn('status', ['completed', 'skipped'])
            ->count();

        $tasksBehind = max(0, $tasksDue - $tasksCompleted);
        $tasksAhead = max(0, $tasksCompleted - $tasksDue);

        $adherencePercentage = $tasksDue > 0
            ? round(($tasksCompleted / $tasksDue) * 100, 1)
            : 100;

        return [
            'has_schedule' => true,
            'tasks_due' => $tasksDue,
            'tasks_completed' => $tasksCompleted,
            'tasks_behind' => $tasksBehind,
            'tasks_ahead' => $tasksAhead,
            'adherence_percentage' => $adherencePercentage,
            'on_schedule' => $adherencePercentage >= 90,
            'ahead_of_schedule' => $tasksAhead > 0,
            'behind_schedule' => $tasksBehind > 0,
            'message' => $this->getScheduleMessage($tasksBehind, $tasksAhead, $adherencePercentage),
        ];
    }

    /**
     * Get friendly schedule adherence message.
     */
    private function getScheduleMessage(int $tasksBehind, int $tasksAhead, float $adherencePercentage): string
    {
        if ($tasksAhead > 3) {
            return "You're ahead of schedule! Keep up the great work!";
        }

        if ($tasksAhead > 0) {
            return "You're slightly ahead of schedule. Excellent progress!";
        }

        if ($adherencePercentage >= 90) {
            return "You're right on schedule. Great job staying consistent!";
        }

        if ($tasksBehind <= 2) {
            return "You're slightly behind schedule. You can catch up!";
        }

        if ($tasksBehind <= 5) {
            return "You're behind schedule. Consider dedicating extra time this week.";
        }

        return "You're significantly behind schedule. Consider adjusting your pace or pausing to reassess.";
    }
}
