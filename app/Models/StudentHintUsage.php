<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentHintUsage extends Model
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
        'hints_revealed',
        'revealed_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'hints_revealed' => 'integer',
            'revealed_at' => 'array',
        ];
    }

    /**
     * Get the student who revealed hints.
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
     * Reveal next hint and track timestamp.
     */
    public function revealNextHint(): void
    {
        $this->hints_revealed++;

        $revealedAt = $this->revealed_at ?? [];
        $revealedAt[] = now()->toIso8601String();
        $this->revealed_at = $revealedAt;

        $this->save();
    }
}
