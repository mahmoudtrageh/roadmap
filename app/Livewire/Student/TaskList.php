<?php

namespace App\Livewire\Student;

use App\Models\Task;
use App\Models\TaskCompletion;
use App\Services\ProgressService;
use App\Services\StreakService;
use App\Helpers\TranslationData;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class TaskList extends Component
{
    public ?object $activeEnrollment = null;
    public array $tasks = [];
    public int $currentDay = 1;
    public array $taskCompletions = [];
    public array $allEnrollments = [];

    // Form properties for task completion
    public ?int $selectedTaskId = null;
    public string $status = '';
    public ?int $qualityRating = null;
    public ?int $timeSpentMinutes = null;
    public bool $showCompletionModal = false;
    public bool $showCompleteAllModal = false;

    protected ProgressService $progressService;
    protected StreakService $streakService;

    protected $rules = [
        'status' => 'required|in:in_progress,completed,skipped',
        'qualityRating' => 'nullable|integer|min:1|max:10',
        'timeSpentMinutes' => 'nullable|integer|min:0',
    ];

    public function boot(ProgressService $progressService, StreakService $streakService): void
    {
        $this->progressService = $progressService;
        $this->streakService = $streakService;
    }

    public function mount(?int $roadmapId = null): void
    {
        $user = Auth::user();

        // Get all enrollments (active and completed, NOT skipped) for roadmap selector
        $this->allEnrollments = $user->enrollments()
            ->with('roadmap')
            ->whereIn('status', ['active', 'completed'])
            ->orderByRaw("CASE WHEN status = 'active' THEN 1 ELSE 2 END")
            ->orderBy('updated_at', 'desc')
            ->get()
            ->toArray();

        // If roadmapId is provided, load that specific roadmap
        if ($roadmapId) {
            $roadmap = \App\Models\Roadmap::with('tasks')->find($roadmapId);

            // Check if roadmap requires enrollment
            if ($roadmap && !$roadmap->requires_enrollment) {
                // For roadmaps that don't require enrollment, create a virtual enrollment
                $this->activeEnrollment = (object) [
                    'id' => null,
                    'roadmap_id' => $roadmap->id,
                    'student_id' => $user->id,
                    'current_day' => 1,
                    'status' => 'active',
                    'roadmap' => $roadmap,
                ];
            } else {
                // For regular roadmaps, get actual enrollment
                $this->activeEnrollment = $user->enrollments()
                    ->with('roadmap.tasks')
                    ->where('roadmap_id', $roadmapId)
                    ->whereIn('status', ['active', 'completed'])
                    ->first();
            }
        }

        // Otherwise, get active enrollment first
        if (!$this->activeEnrollment) {
            $this->activeEnrollment = $user->enrollments()
                ->with('roadmap.tasks')
                ->where('status', 'active')
                ->first();
        }

        // If no active enrollment, try to get completed one for viewing
        if (!$this->activeEnrollment) {
            $this->activeEnrollment = $user->enrollments()
                ->with('roadmap.tasks')
                ->where('status', 'completed')
                ->latest('updated_at')
                ->first();
        }

        if ($this->activeEnrollment) {
            $this->currentDay = $this->activeEnrollment->current_day ?? 1;
            $this->loadTasksForCurrentDay();
        }
    }

    public function switchRoadmap(int $roadmapId): void
    {
        $user = Auth::user();

        $this->activeEnrollment = $user->enrollments()
            ->with('roadmap.tasks')
            ->where('roadmap_id', $roadmapId)
            ->whereIn('status', ['active', 'completed'])
            ->first();

        if ($this->activeEnrollment) {
            $this->currentDay = $this->activeEnrollment->current_day ?? 1;
            $this->loadTasksForCurrentDay();
        }
    }

    public function loadTasksForCurrentDay(): void
    {
        if (!$this->activeEnrollment || !$this->activeEnrollment->roadmap) {
            return;
        }

        // Check if this is a virtual enrollment (for non-enrollment roadmaps)
        $isVirtualEnrollment = is_object($this->activeEnrollment) &&
                               !($this->activeEnrollment instanceof \App\Models\RoadmapEnrollment);

        // Get tasks for current day
        if ($isVirtualEnrollment) {
            $tasksForDay = $this->activeEnrollment->roadmap->tasks
                ->where('day_number', $this->currentDay)
                ->sortBy('order')
                ->values();
        } else {
            $tasksForDay = $this->activeEnrollment->roadmap->tasks()
                ->where('day_number', $this->currentDay)
                ->orderBy('order')
                ->get();
        }

        // For roadmaps that don't require enrollment, skip task completion tracking
        if ($isVirtualEnrollment || !$this->activeEnrollment->roadmap->requires_enrollment) {
            $this->taskCompletions = [];
            $completions = collect();
            $allCompletedTaskIds = [];
            $allTasksUpToCurrent = $tasksForDay->pluck('id')->toArray();
        } else {
            // Get task completions
            $completions = $this->activeEnrollment->taskCompletions()
                ->whereIn('task_id', $tasksForDay->pluck('id'))
                ->get()
                ->keyBy('task_id');

            $this->taskCompletions = $completions->toArray();

            // Get all completed task IDs across all days to determine locking
            $allCompletedTaskIds = $this->activeEnrollment->taskCompletions()
                ->whereIn('status', ['completed', 'skipped'])
                ->pluck('task_id')
                ->toArray();

            // Get all task IDs up to current day in order
            $allTasksUpToCurrent = $this->activeEnrollment->roadmap->tasks()
                ->where('day_number', '<=', $this->currentDay)
                ->orderBy('day_number')
                ->orderBy('order')
                ->pluck('id')
                ->toArray();
        }

        // Get all tasks for prerequisite checking
        $allTasks = $this->activeEnrollment->roadmap->tasks()->get()->keyBy('id');

        // Map tasks with their completion status and locked state
        $this->tasks = $tasksForDay->map(function ($task) use ($completions, $allTasksUpToCurrent, &$allCompletedTaskIds, $allTasks) {
            $completion = $completions->get($task->id);
            $status = $completion?->status ?? 'not_started';

            // Check if task has code submission - if so, consider it completed even if status is not set
            if ($task->has_code_submission && $completion) {
                $hasSubmission = \App\Models\CodeSubmission::where('task_completion_id', $completion->id)->exists();
                if ($hasSubmission) {
                    $status = 'completed';
                    // Add to completed task IDs if not already there
                    if (!in_array($task->id, $allCompletedTaskIds)) {
                        $allCompletedTaskIds[] = $task->id;
                    }
                }
            }

            // Task is locked if any previous task (by global order) is not completed
            $taskIndex = array_search($task->id, $allTasksUpToCurrent);
            $isLocked = false;

            if ($taskIndex !== false && $taskIndex > 0) {
                // Check if all previous tasks are completed
                for ($i = 0; $i < $taskIndex; $i++) {
                    if (!in_array($allTasksUpToCurrent[$i], $allCompletedTaskIds)) {
                        $isLocked = true;
                        break;
                    }
                }
            }

            // Check prerequisites - task is also locked if prerequisites not met
            $prerequisitesMet = true;
            $missingPrerequisites = [];
            if ($task->prerequisites && is_array($task->prerequisites) && count($task->prerequisites) > 0) {
                foreach ($task->prerequisites as $prereqId) {
                    if (!in_array($prereqId, $allCompletedTaskIds)) {
                        $prerequisitesMet = false;
                        $prereqTask = $allTasks->get($prereqId);
                        if ($prereqTask) {
                            $missingPrerequisites[] = [
                                'id' => $prereqId,
                                'title' => $prereqTask->title,
                                'day_number' => $prereqTask->day_number,
                            ];
                        }
                    }
                }
            }

            // Lock task if prerequisites aren't met
            if (!$prerequisitesMet) {
                $isLocked = true;
            }

            // Get recommended tasks info
            $recommendedTasksInfo = [];
            if ($task->recommended_tasks && is_array($task->recommended_tasks) && count($task->recommended_tasks) > 0) {
                foreach ($task->recommended_tasks as $recId) {
                    $recTask = $allTasks->get($recId);
                    if ($recTask) {
                        $recommendedTasksInfo[] = [
                            'id' => $recId,
                            'title' => $recTask->title,
                            'day_number' => $recTask->day_number,
                            'is_completed' => in_array($recId, $allCompletedTaskIds),
                        ];
                    }
                }
            }

            // Check if code has been submitted for this task (status already updated above)
            $codeSubmitted = false;
            if ($task->has_code_submission && $completion) {
                $codeSubmitted = \App\Models\CodeSubmission::where('task_completion_id', $completion->id)->exists();
            }

            // Get task rating statistics
            $ratingStats = \App\Models\TaskCompletion::where('task_id', $task->id)
                ->whereNotNull('quality_rating')
                ->selectRaw('AVG(quality_rating) as avg_rating, COUNT(*) as rating_count')
                ->first();

            $avgRating = $ratingStats && $ratingStats->rating_count > 0
                ? round($ratingStats->avg_rating, 1)
                : null;
            $ratingCount = $ratingStats ? $ratingStats->rating_count : 0;

            return [
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'estimated_time_minutes' => $task->estimated_time_minutes,
                'task_type' => $task->task_type,
                'category' => $task->category,
                'order' => $task->order,
                'resources_links' => $task->resources_links,
                'resources' => $task->resources,
                'has_code_submission' => $task->has_code_submission,
                'code_submitted' => $codeSubmitted,
                'has_quality_rating' => $task->has_quality_rating,
                'status' => $status,
                'completion_id' => $completion?->id,
                'quality_rating' => $completion?->quality_rating,
                'time_spent_minutes' => $completion?->time_spent_minutes,
                'self_notes' => $completion?->self_notes,
                'is_locked' => $isLocked,
                // Rating statistics
                'avg_quality_rating' => $avgRating,
                'rating_count' => $ratingCount,
                // Phase 1 enhancements
                'learning_objectives' => $task->learning_objectives,
                'skills_gained' => $task->skills_gained,
                'success_criteria' => $task->success_criteria,
                'common_mistakes' => $task->common_mistakes,
                'quick_tips' => $task->quick_tips,
                'prerequisites' => $task->prerequisites,
                'recommended_tasks' => $task->recommended_tasks,
                // Dependency checking
                'prerequisites_met' => $prerequisitesMet,
                'missing_prerequisites' => $missingPrerequisites,
                'recommended_tasks_info' => $recommendedTasksInfo,
            ];
        })->toArray();
    }

    public function openCompletionModal(int $taskId, string $status): void
    {
        $this->selectedTaskId = $taskId;
        $this->status = $status;

        // Load existing data if task is already started/completed
        $task = collect($this->tasks)->firstWhere('id', $taskId);
        if ($task && $task['completion_id']) {
            $this->qualityRating = $task['quality_rating'];
            $this->selfNotes = $task['self_notes'] ?? '';
            $this->timeSpentMinutes = $task['time_spent_minutes'];
        } else {
            $this->qualityRating = null;
            $this->selfNotes = '';
            $this->timeSpentMinutes = null;
        }

        $this->showCompletionModal = true;
    }

    public function closeCompletionModal(): void
    {
        $this->showCompletionModal = false;
        $this->reset(['selectedTaskId', 'status', 'qualityRating', 'timeSpentMinutes']);
    }

    public function updateTaskStatus(): void
    {
        $this->validate();

        if (!$this->selectedTaskId || !$this->activeEnrollment) {
            return;
        }

        $task = Task::find($this->selectedTaskId);
        if (!$task) {
            return;
        }

        // Check if trying to complete a task that requires code submission
        if ($this->status === 'completed' && $task->has_code_submission) {
            // Find or create task completion to check for code submission
            $completion = TaskCompletion::firstOrNew([
                'task_id' => $this->selectedTaskId,
                'student_id' => Auth::id(),
                'enrollment_id' => $this->activeEnrollment->id,
            ]);

            // Save completion first if it's new
            if (!$completion->exists) {
                $completion->status = 'in_progress';
                $completion->started_at = now();
                $completion->save();
            }

            // Check if there's a code submission
            $hasCodeSubmission = \App\Models\CodeSubmission::where('task_completion_id', $completion->id)
                ->exists();

            if (!$hasCodeSubmission) {
                $this->closeCompletionModal();
                session()->flash('error', 'This task requires code submission. Please submit your code first using the "Click Submit" button.');
                return;
            }
        }

        // Find or create task completion
        $completion = TaskCompletion::firstOrNew([
            'task_id' => $this->selectedTaskId,
            'student_id' => Auth::id(),
            'enrollment_id' => $this->activeEnrollment->id,
        ]);

        $completion->status = $this->status;
        $completion->time_spent_minutes = $this->timeSpentMinutes ?? 0;

        if ($this->status === 'in_progress' && !$completion->started_at) {
            $completion->started_at = now();
        }

        if ($this->status === 'completed') {
            $completion->completed_at = now();
            $completion->quality_rating = $this->qualityRating;
        }

        $completion->save();

        // Award streak and check completion
        if ($this->status === 'completed') {
            $user = Auth::user();

            // Update streak
            $this->streakService->updateUserStreak($user);

            session()->flash('message', 'Task completed successfully!');
        } else {
            session()->flash('message', 'Task status updated successfully!');
        }

        // Check if enrollment should be marked as complete
        $this->progressService->checkAndMarkComplete($this->activeEnrollment);

        $this->closeCompletionModal();

        $nextTaskId = null;

        // If task was completed, find the next task
        if ($this->status === 'completed') {
            // Get all tasks in order
            $allTasksInOrder = $this->activeEnrollment->roadmap->tasks()
                ->orderBy('day_number')
                ->orderBy('order')
                ->get();

            // Get completed task IDs (refresh from database to include the just-completed task)
            $completedTaskIds = TaskCompletion::where('student_id', Auth::id())
                ->where('enrollment_id', $this->activeEnrollment->id)
                ->whereIn('status', ['completed', 'skipped'])
                ->pluck('task_id')
                ->toArray();

            // Make sure the current task is included in completed tasks
            if (!in_array($this->selectedTaskId, $completedTaskIds)) {
                $completedTaskIds[] = $this->selectedTaskId;
            }

            // Find next incomplete task
            $nextTask = null;
            foreach ($allTasksInOrder as $task) {
                if (!in_array($task->id, $completedTaskIds)) {
                    $nextTask = $task;
                    break;
                }
            }

            // If next task is on a different day, switch to that day
            if ($nextTask) {
                $nextTaskId = $nextTask->id;
                if ($nextTask->day_number != $this->currentDay) {
                    $this->currentDay = $nextTask->day_number;
                }
            }
        }

        // Reload tasks
        $this->loadTasksForCurrentDay();

        // Dispatch event to scroll to next task
        if ($nextTaskId) {
            $this->dispatch('scrollToTask', taskId: $nextTaskId);
        }
    }

    public function completeTask(int $taskId): void
    {
        // Prevent completion for roadmaps that don't require enrollment
        if ($this->activeEnrollment &&
            $this->activeEnrollment->roadmap &&
            !$this->activeEnrollment->roadmap->requires_enrollment) {
            return;
        }

        $this->openCompletionModal($taskId, 'completed');
    }

    public function skipTask(int $taskId): void
    {
        // Prevent skipping for roadmaps that don't require enrollment
        if ($this->activeEnrollment &&
            $this->activeEnrollment->roadmap &&
            !$this->activeEnrollment->roadmap->requires_enrollment) {
            return;
        }

        $this->openCompletionModal($taskId, 'skipped');
    }

    public function changeDay(int $dayNumber): void
    {
        if (!$this->activeEnrollment) {
            return;
        }

        if ($dayNumber < 1 || $dayNumber > $this->activeEnrollment->roadmap->duration_days) {
            return;
        }

        // Allow day exploration - no day locking
        $this->currentDay = $dayNumber;
        $this->loadTasksForCurrentDay();
    }

    private function canAccessDay(int $dayNumber): bool
    {
        // All days are accessible for exploration
        // Tasks within days remain locked until previous tasks are completed
        return true;
    }

    public function openCompleteAllModal(): void
    {
        $this->showCompleteAllModal = true;
    }

    public function closeCompleteAllModal(): void
    {
        $this->showCompleteAllModal = false;
    }

    public function completeAllTasks(): void
    {
        if (!$this->activeEnrollment) {
            session()->flash('error', 'No active enrollment found.');
            return;
        }

        // Prevent for roadmaps that don't require enrollment
        if (!$this->activeEnrollment->roadmap->requires_enrollment) {
            return;
        }

        $user = Auth::user();
        $roadmap = $this->activeEnrollment->roadmap;

        // Get all tasks in the roadmap
        $allTasks = $roadmap->tasks()->orderBy('day_number')->orderBy('order')->get();

        $completedCount = 0;

        foreach ($allTasks as $task) {
            // Check if task is already completed
            $existingCompletion = TaskCompletion::where('task_id', $task->id)
                ->where('student_id', $user->id)
                ->where('enrollment_id', $this->activeEnrollment->id)
                ->first();

            if ($existingCompletion && $existingCompletion->status === 'completed') {
                continue; // Skip already completed tasks
            }

            // Create or update task completion
            $completion = TaskCompletion::updateOrCreate(
                [
                    'task_id' => $task->id,
                    'student_id' => $user->id,
                    'enrollment_id' => $this->activeEnrollment->id,
                ],
                [
                    'status' => 'completed',
                    'completed_at' => now(),
                    'started_at' => $existingCompletion->started_at ?? now(),
                    'time_spent_minutes' => $existingCompletion->time_spent_minutes ?? 0,
                    'quality_rating' => 7, // Default rating
                ]
            );

            $completedCount++;
        }

        // Update streak
        $this->streakService->updateUserStreak($user);

        // Check if roadmap should be marked as complete
        $this->progressService->checkAndMarkComplete($this->activeEnrollment);

        session()->flash('message', "🎉 Completed {$completedCount} tasks!");

        $this->closeCompleteAllModal();
        $this->mount(); // Reload all data
    }

    protected function getTranslationTerms($day)
    {
        return TranslationData::getTerms($day);
    }

    public function render(): View
    {
        // Calculate which days are accessible and completed
        $accessibleDays = [];
        $completedDays = [];
        $translationTerms = null;

        if ($this->activeEnrollment) {
            // Check if this is a virtual enrollment
            $isVirtualEnrollment = is_object($this->activeEnrollment) &&
                                   !($this->activeEnrollment instanceof \App\Models\RoadmapEnrollment);

            // Get translation terms if this is translation roadmap
            if ($this->activeEnrollment->roadmap->slug === 'technical-terms-translation') {
                $translationTerms = $this->getTranslationTerms($this->currentDay);
            }

            for ($day = 1; $day <= $this->activeEnrollment->roadmap->duration_days; $day++) {
                // All days are accessible for exploration
                $accessibleDays[$day] = true;

                // Skip completion tracking for virtual enrollments
                if ($isVirtualEnrollment || !$this->activeEnrollment->roadmap->requires_enrollment) {
                    $completedDays[$day] = false;
                    continue;
                }

                // Check if day is completed (all tasks done/skipped)
                $dayTaskIds = $this->activeEnrollment->roadmap->tasks()
                    ->where('day_number', $day)
                    ->pluck('id')
                    ->toArray();

                if (!empty($dayTaskIds)) {
                    $completedCount = $this->activeEnrollment->taskCompletions()
                        ->whereIn('task_id', $dayTaskIds)
                        ->whereIn('status', ['completed', 'skipped'])
                        ->count();

                    $completedDays[$day] = $completedCount === count($dayTaskIds);
                }
            }
        }

        return view('livewire.student.task-list', [
            'accessibleDays' => $accessibleDays,
            'completedDays' => $completedDays,
            'translationTerms' => $translationTerms,
        ]);
    }
}
