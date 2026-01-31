<?php

namespace App\Livewire\Student;

use App\Services\ProgressService;
use App\Services\ScheduleService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public int $tasksCompletedToday = 0;
    public int $overallProgress = 0;
    public ?object $activeEnrollment = null;
    public int $totalTasks = 0;
    public int $totalSkipped = 0;
    public int $totalTimeSpent = 0;
    public array $progressStats = [];
    public $recentJobs = [];
    public bool $showPauseModal = false;
    public string $pauseReason = '';
    public array $scheduleAdherence = [];

    protected ProgressService $progressService;
    protected ScheduleService $scheduleService;

    public function boot(ProgressService $progressService, ScheduleService $scheduleService): void
    {
        $this->progressService = $progressService;
        $this->scheduleService = $scheduleService;
    }

    public function mount(): void
    {
        $user = Auth::user();

        // Get active enrollment (or most recent if none active)
        $this->activeEnrollment = $user->enrollments()
            ->with('roadmap')
            ->where('status', 'active')
            ->first();

        // If no active enrollment, get the most recent completed one
        if (!$this->activeEnrollment) {
            $this->activeEnrollment = $user->enrollments()
                ->with('roadmap')
                ->latest('updated_at')
                ->first();
        }

        // Calculate tasks completed today
        $this->tasksCompletedToday = $user->taskCompletions()
            ->where('status', 'completed')
            ->whereDate('completed_at', today())
            ->count();

        // Get overall progress from active enrollment
        if ($this->activeEnrollment) {
            $this->overallProgress = $this->progressService->calculateProgress($this->activeEnrollment);
            $this->progressStats = $this->progressService->getProgressStats($this->activeEnrollment);
        }

        // Quick stats
        $this->totalTasks = $user->taskCompletions()
            ->where('status', 'completed')
            ->count();

        $this->totalSkipped = $user->taskCompletions()
            ->where('status', 'skipped')
            ->count();

        $this->totalTimeSpent = $user->taskCompletions()
            ->sum('time_spent_minutes');

        // Get recent job listings
        $this->recentJobs = \App\Models\JobListing::with('company')
            ->where('status', 'open')
            ->where(function($query) {
                $query->whereNull('deadline')
                    ->orWhere('deadline', '>=', today());
            })
            ->latest()
            ->take(3)
            ->get()
            ->toArray();

        // Check schedule adherence if enrollment has auto_schedule
        if ($this->activeEnrollment && $this->activeEnrollment->auto_schedule) {
            $this->scheduleAdherence = $this->scheduleService->checkScheduleAdherence($this->activeEnrollment);
        }
    }

    public function openPauseModal()
    {
        $this->showPauseModal = true;
    }

    public function closePauseModal()
    {
        $this->showPauseModal = false;
        $this->pauseReason = '';
    }

    public function pauseEnrollment()
    {
        if (!$this->activeEnrollment) {
            session()->flash('error', 'No active enrollment to pause.');
            return;
        }

        $this->activeEnrollment->pause($this->pauseReason);

        session()->flash('message', 'Enrollment paused successfully. You can resume anytime.');
        $this->closePauseModal();
        $this->mount(); // Reload data
    }

    public function resumeEnrollment()
    {
        if (!$this->activeEnrollment) {
            session()->flash('error', 'No enrollment to resume.');
            return;
        }

        $this->activeEnrollment->resume();

        session()->flash('message', 'Welcome back! Your enrollment has been resumed.');
        $this->mount(); // Reload data
    }

    public function render(): View
    {
        return view('livewire.student.dashboard');
    }
}
