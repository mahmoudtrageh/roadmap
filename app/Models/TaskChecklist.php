<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskChecklist extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'task_id',
        'items',
        'description',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'items' => 'array',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the task that owns this checklist.
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get all student progress records for this checklist.
     */
    public function studentProgress(): HasMany
    {
        return $this->hasMany(StudentChecklistProgress::class);
    }

    /**
     * Get progress for a specific student and enrollment.
     */
    public function getProgressForStudent(int $studentId, int $enrollmentId): ?StudentChecklistProgress
    {
        return $this->studentProgress()
            ->where('student_id', $studentId)
            ->where('enrollment_id', $enrollmentId)
            ->first();
    }

    /**
     * Get total number of checklist items.
     */
    public function getTotalItems(): int
    {
        return is_array($this->items) ? count($this->items) : 0;
    }
}
