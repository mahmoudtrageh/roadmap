<?php

namespace App\Livewire\Student;

use App\Services\ProgressService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class ProgressTracker extends Component
{
    public ?object $activeEnrollment = null;
    public array $progressStats = [];
    public int $progressPercentage = 0;
    public int $currentDay = 1;
    public int $totalDays = 1;
    public int $completedTasks = 0;
    public int $remainingTasks = 0;
    public int $totalTasks = 0;
    public array $categoryProgress = [];
    public array $dayWiseProgress = [];

    protected ProgressService $progressService;

    public function boot(ProgressService $progressService): void
    {
        $this->progressService = $progressService;
    }

    public function mount(): void
    {
        $user = Auth::user();

        // Get active enrollment
        $this->activeEnrollment = $user->enrollments()
            ->with('roadmap')
            ->where('status', 'active')
            ->first();

        if ($this->activeEnrollment) {
            $this->loadProgressData();
        }
    }

    public function loadProgressData(): void
    {
        if (!$this->activeEnrollment) {
            return;
        }

        // Get progress statistics
        $this->progressStats = $this->progressService->getProgressStats($this->activeEnrollment);

        // Set individual properties
        $this->progressPercentage = $this->progressStats['progress_percentage'];
        $this->currentDay = $this->progressStats['current_day'];
        $this->totalDays = $this->progressStats['total_days'];
        $this->completedTasks = $this->progressStats['completed_tasks'];
        $this->remainingTasks = $this->progressStats['remaining_tasks'];
        $this->totalTasks = $this->progressStats['total_tasks'];

        // Get progress by category
        $this->categoryProgress = $this->progressService->getProgressByCategory($this->activeEnrollment);

        // Get day-wise progress
        $this->loadDayWiseProgress();
    }

    public function loadDayWiseProgress(): void
    {
        if (!$this->activeEnrollment || !$this->activeEnrollment->roadmap) {
            return;
        }

        $this->dayWiseProgress = [];

        for ($day = 1; $day <= $this->totalDays; $day++) {
            $tasksForDay = $this->activeEnrollment->roadmap->tasks()
                ->where('day_number', $day)
                ->count();

            $completedForDay = $this->activeEnrollment->taskCompletions()
                ->where('status', 'completed')
                ->whereIn('task_id', function ($query) use ($day) {
                    $query->select('id')
                        ->from('tasks')
                        ->where('roadmap_id', $this->activeEnrollment->roadmap_id)
                        ->where('day_number', $day);
                })
                ->count();

            $this->dayWiseProgress[] = [
                'day' => $day,
                'total_tasks' => $tasksForDay,
                'completed_tasks' => $completedForDay,
                'is_completed' => $tasksForDay > 0 && $completedForDay >= $tasksForDay,
                'is_current' => $day === $this->currentDay,
                'percentage' => $tasksForDay > 0 ? (int)(($completedForDay / $tasksForDay) * 100) : 0,
            ];
        }
    }

    public function refreshProgress(): void
    {
        $this->loadProgressData();
        session()->flash('message', 'Progress refreshed successfully!');
    }

    public function render(): View
    {
        return view('livewire.student.progress-tracker');
    }
}
