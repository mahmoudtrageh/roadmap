<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentQuestion extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'task_id',
        'enrollment_id',
        'question',
        'answer',
        'status',
        'answered_by',
        'answered_at',
        'is_public',
        'helpful_count',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
            'helpful_count' => 'integer',
            'answered_at' => 'datetime',
        ];
    }

    /**
     * Get the student who asked the question.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the task.
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the enrollment.
     */
    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(RoadmapEnrollment::class, 'enrollment_id');
    }

    /**
     * Get the user who answered the question.
     */
    public function answeredByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'answered_by');
    }

    /**
     * Scope to get pending questions.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope to get answered questions.
     */
    public function scopeAnswered($query)
    {
        return $query->where('status', 'answered');
    }

    /**
     * Scope to get public questions.
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }
}
