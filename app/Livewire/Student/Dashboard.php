<?php

namespace App\Livewire\Student;

use App\Services\ProgressService;
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
    }

    public function render(): View
    {
        return view('livewire.student.dashboard');
    }
}
