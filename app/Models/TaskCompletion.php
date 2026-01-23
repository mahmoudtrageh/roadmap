<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskCompletion extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'task_id',
        'student_id',
        'enrollment_id',
        'status',
        'started_at',
        'completed_at',
        'time_spent_minutes',
        'quality_rating',
        'self_notes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
            'time_spent_minutes' => 'integer',
            'quality_rating' => 'integer',
        ];
    }

    /**
     * Get the task that this completion belongs to.
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the student (user) that owns this completion.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the roadmap enrollment that this completion belongs to.
     */
    public function roadmapEnrollment(): BelongsTo
    {
        return $this->belongsTo(RoadmapEnrollment::class, 'enrollment_id');
    }

    /**
     * Get the code submissions for this task completion.
     */
    public function codeSubmissions(): HasMany
    {
        return $this->hasMany(CodeSubmission::class);
    }
}
