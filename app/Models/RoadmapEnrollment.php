<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoadmapEnrollment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'roadmap_id',
        'student_id',
        'started_at',
        'completed_at',
        'current_day',
        'custom_schedule',
        'custom_total_days',
        'status',
        'overall_rating',
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
            'current_day' => 'integer',
            'custom_schedule' => 'array',
            'custom_total_days' => 'integer',
            'overall_rating' => 'integer',
        ];
    }

    /**
     * Get the roadmap that this enrollment belongs to.
     */
    public function roadmap(): BelongsTo
    {
        return $this->belongsTo(Roadmap::class);
    }

    /**
     * Get the student (user) that owns this enrollment.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the task completions for this enrollment.
     */
    public function taskCompletions(): HasMany
    {
        return $this->hasMany(TaskCompletion::class, 'enrollment_id');
    }

    /**
     * Get the weekly reviews for this enrollment.
     */
    public function weeklyReviews(): HasMany
    {
        return $this->hasMany(WeeklyReview::class, 'enrollment_id');
    }

    /**
     * Get the monthly reviews for this enrollment.
     */
    public function monthlyReviews(): HasMany
    {
        return $this->hasMany(MonthlyReview::class, 'enrollment_id');
    }
}
