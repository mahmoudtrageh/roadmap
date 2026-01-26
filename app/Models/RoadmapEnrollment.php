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
        'weekly_hours',
        'auto_schedule',
        'paused_at',
        'pause_reason',
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
            'weekly_hours' => 'integer',
            'auto_schedule' => 'array',
            'paused_at' => 'datetime',
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

    /**
     * Check if enrollment is currently paused.
     */
    public function isPaused(): bool
    {
        return $this->paused_at !== null && $this->status === 'active';
    }

    /**
     * Pause the enrollment.
     */
    public function pause(?string $reason = null): void
    {
        $this->paused_at = now();
        $this->pause_reason = $reason;
        $this->save();
    }

    /**
     * Resume the enrollment.
     */
    public function resume(): void
    {
        $this->paused_at = null;
        $this->pause_reason = null;
        $this->save();
    }

    /**
     * Get days paused.
     */
    public function getDaysPaused(): int
    {
        if (!$this->paused_at) {
            return 0;
        }

        return now()->diffInDays($this->paused_at);
    }

    /**
     * Calculate estimated completion date based on weekly hours.
     */
    public function getEstimatedCompletionDate(): ?\DateTime
    {
        if (!$this->weekly_hours || !$this->roadmap) {
            return null;
        }

        // Get total estimated minutes for all remaining tasks
        $completedTaskIds = $this->taskCompletions()
            ->whereIn('status', ['completed', 'skipped'])
            ->pluck('task_id')
            ->toArray();

        $remainingTasks = $this->roadmap->tasks()
            ->whereNotIn('id', $completedTaskIds)
            ->get();

        $totalMinutesRemaining = $remainingTasks->sum('estimated_time_minutes');

        // Convert weekly hours to daily hours (assume 7 days availability)
        $dailyHoursAvailable = $this->weekly_hours / 7;
        $dailyMinutesAvailable = $dailyHoursAvailable * 60;

        // Calculate days needed
        $daysNeeded = $dailyMinutesAvailable > 0
            ? ceil($totalMinutesRemaining / $dailyMinutesAvailable)
            : 0;

        // Add pause time if paused
        if ($this->isPaused()) {
            $daysNeeded += $this->getDaysPaused();
        }

        return now()->addDays($daysNeeded)->toDateTime();
    }

    /**
     * Get weekly progress percentage.
     */
    public function getWeeklyProgressPercentage(): float
    {
        $weekStart = now()->startOfWeek();
        $weekEnd = now()->endOfWeek();

        $tasksCompletedThisWeek = $this->taskCompletions()
            ->whereIn('status', ['completed', 'skipped'])
            ->whereBetween('completed_at', [$weekStart, $weekEnd])
            ->count();

        $totalTasks = $this->roadmap->tasks()->count();

        if ($totalTasks === 0) {
            return 0;
        }

        return ($tasksCompletedThisWeek / $totalTasks) * 100;
    }
}
