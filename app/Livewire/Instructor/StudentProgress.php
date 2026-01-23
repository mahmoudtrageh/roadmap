<?php

namespace App\Livewire\Instructor;

use App\Models\RoadmapEnrollment;
use App\Models\User;
use App\Services\ProgressService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class StudentProgress extends Component
{
    use WithPagination;

    public $selectedStudentId = null;
    public $selectedEnrollmentId = null;
    public $showDetails = false;
    public $searchStudent = '';
    public $filterRoadmap = 'all';
    public $filterStatus = 'all';

    protected ProgressService $progressService;

    public function boot(ProgressService $progressService): void
    {
        $this->progressService = $progressService;
    }

    public function mount(): void
    {
        if (!Auth::user()->isInstructor() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function getEnrollmentsProperty()
    {
        $query = RoadmapEnrollment::with(['student', 'roadmap'])
            ->withCount([
                'taskCompletions as completed_tasks_count' => function ($q) {
                    $q->where('status', 'completed');
                }
            ]);

        if ($this->searchStudent) {
            $query->whereHas('student', function ($q) {
                $q->where('name', 'like', '%' . $this->searchStudent . '%')
                    ->orWhere('email', 'like', '%' . $this->searchStudent . '%');
            });
        }

        if ($this->filterRoadmap !== 'all') {
            $query->where('roadmap_id', $this->filterRoadmap);
        }

        if ($this->filterStatus !== 'all') {
            $query->where('status', $this->filterStatus);
        }

        return $query->latest()->paginate(15);
    }

    public function getRoadmapsProperty()
    {
        return \App\Models\Roadmap::select('id', 'title')->get();
    }

    public function getSelectedEnrollmentProperty()
    {
        if (!$this->selectedEnrollmentId) {
            return null;
        }

        return RoadmapEnrollment::with([
            'student',
            'roadmap.tasks',
            'taskCompletions.task'
        ])->findOrFail($this->selectedEnrollmentId);
    }

    public function getProgressStatsProperty()
    {
        if (!$this->selectedEnrollmentId) {
            return null;
        }

        $enrollment = RoadmapEnrollment::findOrFail($this->selectedEnrollmentId);
        return $this->progressService->getProgressStats($enrollment);
    }

    public function getCategoryProgressProperty()
    {
        if (!$this->selectedEnrollmentId) {
            return null;
        }

        $enrollment = RoadmapEnrollment::findOrFail($this->selectedEnrollmentId);
        return $this->progressService->getProgressByCategory($enrollment);
    }

    public function getTaskCompletionChartDataProperty()
    {
        if (!$this->selectedEnrollmentId) {
            return null;
        }

        $enrollment = RoadmapEnrollment::findOrFail($this->selectedEnrollmentId);

        // Get task completions by day for the last 30 days
        $completions = $enrollment->taskCompletions()
            ->where('status', 'completed')
            ->where('completed_at', '>=', now()->subDays(30))
            ->select(
                DB::raw('DATE(completed_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $data = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $count = $completions->firstWhere('date', $date)?->count ?? 0;
            $data[] = [
                'date' => now()->subDays($i)->format('M d'),
                'count' => $count,
            ];
        }

        return $data;
    }

    public function getTimeSpentChartDataProperty()
    {
        if (!$this->selectedEnrollmentId) {
            return null;
        }

        $enrollment = RoadmapEnrollment::findOrFail($this->selectedEnrollmentId);

        // Get time spent by category
        $timeByCategory = $enrollment->taskCompletions()
            ->join('tasks', 'task_completions.task_id', '=', 'tasks.id')
            ->select(
                'tasks.category',
                DB::raw('SUM(task_completions.time_spent_minutes) as total_time')
            )
            ->groupBy('tasks.category')
            ->get();

        return $timeByCategory->map(function ($item) {
            return [
                'category' => $item->category,
                'time' => $item->total_time,
            ];
        })->toArray();
    }

    public function viewDetails($enrollmentId): void
    {
        $this->selectedEnrollmentId = $enrollmentId;
        $this->showDetails = true;
    }

    public function closeDetails(): void
    {
        $this->showDetails = false;
        $this->selectedEnrollmentId = null;
    }

    public function updatedSearchStudent(): void
    {
        $this->resetPage();
    }

    public function updatedFilterRoadmap(): void
    {
        $this->resetPage();
    }

    public function updatedFilterStatus(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.instructor.student-progress', [
            'enrollments' => $this->enrollments,
            'roadmaps' => $this->roadmaps,
            'selectedEnrollment' => $this->selectedEnrollment,
            'progressStats' => $this->progressStats,
            'categoryProgress' => $this->categoryProgress,
            'taskCompletionChartData' => $this->taskCompletionChartData,
            'timeSpentChartData' => $this->timeSpentChartData,
        ]);
    }
}
