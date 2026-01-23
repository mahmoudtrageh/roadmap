<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskQuiz extends Model
{
    protected $fillable = [
        'task_id',
        'questions',
        'introduction',
        'passing_score',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'questions' => 'array',
            'passing_score' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(StudentQuizAttempt::class);
    }

    public function getTotalQuestions(): int
    {
        return is_array($this->questions) ? count($this->questions) : 0;
    }

    public function getAttemptForStudent(int $studentId, int $enrollmentId): ?StudentQuizAttempt
    {
        return $this->attempts()
            ->where('student_id', $studentId)
            ->where('enrollment_id', $enrollmentId)
            ->latest()
            ->first();
    }
}
