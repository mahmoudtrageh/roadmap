<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentChecklistProgress extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'task_checklist_id',
        'enrollment_id',
        'checked_items',
        'completion_percentage',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'checked_items' => 'array',
            'completion_percentage' => 'integer',
        ];
    }

    /**
     * Get the student that owns this progress.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the task checklist.
     */
    public function taskChecklist(): BelongsTo
    {
        return $this->belongsTo(TaskChecklist::class);
    }

    /**
     * Get the enrollment.
     */
    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    /**
     * Check if a specific item is checked.
     */
    public function isItemChecked(int $index): bool
    {
        return is_array($this->checked_items) && in_array($index, $this->checked_items);
    }

    /**
     * Toggle a checklist item.
     */
    public function toggleItem(int $index, int $totalItems): void
    {
        $checkedItems = $this->checked_items ?? [];

        if (in_array($index, $checkedItems)) {
            // Remove from checked
            $checkedItems = array_values(array_diff($checkedItems, [$index]));
        } else {
            // Add to checked
            $checkedItems[] = $index;
            $checkedItems = array_values(array_unique($checkedItems));
        }

        $this->checked_items = $checkedItems;
        $this->completion_percentage = $totalItems > 0 ? round((count($checkedItems) / $totalItems) * 100) : 0;
        $this->save();
    }

    /**
     * Update completion percentage based on checked items.
     */
    public function updateCompletionPercentage(int $totalItems): void
    {
        $checkedCount = is_array($this->checked_items) ? count($this->checked_items) : 0;
        $this->completion_percentage = $totalItems > 0 ? round(($checkedCount / $totalItems) * 100) : 0;
        $this->save();
    }
}
