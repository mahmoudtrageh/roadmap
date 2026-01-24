<?php

namespace App\Livewire\Student;

use App\Models\Task;
use App\Models\TaskCompletion;
use App\Services\PointsService;
use App\Services\ProgressService;
use App\Services\StreakService;
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

    // Form properties for task completion
    public ?int $selectedTaskId = null;
    public string $status = '';
    public ?int $qualityRating = null;
    public string $selfNotes = '';
    public ?int $timeSpentMinutes = null;
    public bool $showCompletionModal = false;
    public bool $showCompleteAllModal = false;

    protected ProgressService $progressService;
    protected PointsService $pointsService;
    protected StreakService $streakService;

    protected $rules = [
        'status' => 'required|in:in_progress,completed,skipped',
        'qualityRating' => 'nullable|integer|min:1|max:10',
        'selfNotes' => 'nullable|string|max:1000',
        'timeSpentMinutes' => 'nullable|integer|min:0',
    ];

    public function boot(ProgressService $progressService, PointsService $pointsService, StreakService $streakService): void
    {
        $this->progressService = $progressService;
        $this->pointsService = $pointsService;
        $this->streakService = $streakService;
    }

    public function mount(): void
    {
        $user = Auth::user();

        // Get active enrollment
        $this->activeEnrollment = $user->enrollments()
            ->with('roadmap.tasks')
            ->where('status', 'active')
            ->first();

        // If no active enrollment, try to get most recent for viewing
        if (!$this->activeEnrollment) {
            $this->activeEnrollment = $user->enrollments()
                ->with('roadmap.tasks')
                ->latest('updated_at')
                ->first();
        }

        if ($this->activeEnrollment) {
            $this->currentDay = $this->activeEnrollment->current_day ?? 1;
            $this->loadTasksForCurrentDay();
        }
    }

    public function loadTasksForCurrentDay(): void
    {
        if (!$this->activeEnrollment) {
            return;
        }

        // Get tasks for current day
        $tasksForDay = $this->activeEnrollment->roadmap->tasks()
            ->where('day_number', $this->currentDay)
            ->orderBy('order')
            ->get();

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

        // Get all tasks for prerequisite checking
        $allTasks = $this->activeEnrollment->roadmap->tasks()->get()->keyBy('id');

        // Map tasks with their completion status and locked state
        $this->tasks = $tasksForDay->map(function ($task) use ($completions, $allTasksUpToCurrent, $allCompletedTaskIds, $allTasks) {
            $completion = $completions->get($task->id);
            $status = $completion?->status ?? 'not_started';

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

            // Check if code has been submitted for this task
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

            // Filter resources by user's learning style (Phase 2 enhancement)
            $learningStyle = Auth::user()->learning_style ?? null;
            $filteredResources = $task->getResourcesByLearningStyle($learningStyle);

            return [
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'estimated_time_minutes' => $task->estimated_time_minutes,
                'task_type' => $task->task_type,
                'category' => $task->category,
                'order' => $task->order,
                'resources_links' => $task->resources_links,
                'resources' => $filteredResources, // Personalized by learning style
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
        $this->reset(['selectedTaskId', 'status', 'qualityRating', 'selfNotes', 'timeSpentMinutes']);
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
        $completion->self_notes = $this->selfNotes;
        $completion->time_spent_minutes = $this->timeSpentMinutes ?? 0;

        if ($this->status === 'in_progress' && !$completion->started_at) {
            $completion->started_at = now();
        }

        if ($this->status === 'completed') {
            $completion->completed_at = now();
            $completion->quality_rating = $this->qualityRating;
        }

        $completion->save();

        // Award points and update streak if task completed
        if ($this->status === 'completed') {
            $user = Auth::user();
            $task = Task::find($this->selectedTaskId);

            // Award points for task completion
            $pointsEarned = $this->pointsService->awardTaskCompletion(
                $user,
                $task->estimated_time_category ?? 'moderate',
                $this->qualityRating
            );

            // Update streak
            $this->streakService->updateStreak($user);

            // Award streak points if applicable
            if ($user->current_streak > 0) {
                $this->pointsService->awardStreakMaintenance($user, $user->current_streak);
            }

            session()->flash('message', 'Task completed! You earned ' . $pointsEarned . ' points!');
        } else {
            session()->flash('message', 'Task status updated successfully!');
        }

        // Check if enrollment should be marked as complete
        $this->progressService->checkAndMarkComplete($this->activeEnrollment);

        // Reload tasks
        $this->loadTasksForCurrentDay();
        $this->closeCompletionModal();
    }

    public function completeTask(int $taskId): void
    {
        $this->openCompletionModal($taskId, 'completed');
    }

    public function skipTask(int $taskId): void
    {
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

        $user = Auth::user();
        $roadmap = $this->activeEnrollment->roadmap;

        // Get all tasks in the roadmap
        $allTasks = $roadmap->tasks()->orderBy('day_number')->orderBy('order')->get();

        $completedCount = 0;
        $totalPointsEarned = 0;

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

            // Award points for task completion
            $points = $this->pointsService->awardTaskCompletion(
                $user,
                $task->estimated_time_category ?? 'moderate',
                7 // Default quality rating
            );

            $totalPointsEarned += $points;
            $completedCount++;
        }

        // Update streak
        $this->streakService->updateStreak($user);

        // Award streak points
        if ($user->current_streak > 0) {
            $this->pointsService->awardStreakMaintenance($user, $user->current_streak);
        }

        // Check if roadmap should be marked as complete and generate certificate
        $this->progressService->checkAndMarkComplete($this->activeEnrollment);

        session()->flash('message', "🎉 Completed {$completedCount} tasks! You earned {$totalPointsEarned} points!");

        $this->closeCompleteAllModal();
        $this->mount(); // Reload all data
    }

    public function render(): View
    {
        // Calculate which days are accessible and completed
        $accessibleDays = [];
        $completedDays = [];

        if ($this->activeEnrollment) {
            for ($day = 1; $day <= $this->activeEnrollment->roadmap->duration_days; $day++) {
                // All days are accessible for exploration
                $accessibleDays[$day] = true;

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
        ]);
    }
}
