<?php

namespace App\Livewire\Student;

use App\Models\StudentChecklistProgress;
use App\Models\TaskChecklist;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ChecklistBox extends Component
{
    #[Locked]
    public $taskId;

    #[Locked]
    public $enrollmentId;

    #[Locked]
    public $isLocked = false;

    public $checklistId;
    public $progressId;
    public $items = [];
    public $checkedItems = [];
    public $completionPercentage = 0;
    public $description = '';

    public function mount(): void
    {
        if (!$this->enrollmentId) {
            return;
        }

        // Load the checklist for this task
        $checklist = TaskChecklist::where('task_id', $this->taskId)
            ->where('is_active', true)
            ->first();

        if (!$checklist) {
            return;
        }

        $this->checklistId = $checklist->id;
        $this->items = $checklist->items ?? [];
        $this->description = $checklist->description ?? '';

        // Load or create student progress
        $progress = StudentChecklistProgress::firstOrCreate(
            [
                'student_id' => Auth::id(),
                'task_checklist_id' => $checklist->id,
                'enrollment_id' => $this->enrollmentId,
            ],
            [
                'checked_items' => [],
                'completion_percentage' => 0,
            ]
        );

        $this->progressId = $progress->id;
        $this->checkedItems = $progress->checked_items ?? [];
        $this->completionPercentage = $progress->completion_percentage ?? 0;
    }

    public function toggle($index)
    {
        \Log::info('toggle called', ['index' => $index, 'component' => get_class($this)]);

        if ($this->isLocked || !$this->progressId) {
            \Log::warning('toggle blocked', ['isLocked' => $this->isLocked, 'progressId' => $this->progressId]);
            return;
        }

        $progress = StudentChecklistProgress::find($this->progressId);
        if (!$progress) {
            \Log::error('Progress not found', ['progressId' => $this->progressId]);
            return;
        }

        $totalItems = count($this->items);
        $progress->toggleItem($index, $totalItems);

        // Refresh local state
        $progress->refresh();
        $this->checkedItems = $progress->checked_items ?? [];
        $this->completionPercentage = $progress->completion_percentage ?? 0;

        // Emit event for parent component
        $this->dispatch('checklist-updated', [
            'taskId' => $this->taskId,
            'percentage' => $this->completionPercentage,
        ]);

        \Log::info('toggle completed', ['percentage' => $this->completionPercentage]);
    }

    // Keep old name for backward compatibility
    public function toggleItem($index)
    {
        return $this->toggle($index);
    }

    public function isChecked(int $index): bool
    {
        return in_array($index, $this->checkedItems);
    }

    public function render(): View
    {
        return view('livewire.student.checklist-box');
    }
}
