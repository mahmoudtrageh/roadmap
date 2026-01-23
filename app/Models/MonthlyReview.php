<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MonthlyReview extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'enrollment_id',
        'month_number',
        'month_start_date',
        'month_end_date',
        'goals_completed',
        'code_comparison',
        'needs_more_practice',
        'ready_for_next_month',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'month_number' => 'integer',
            'month_start_date' => 'date',
            'month_end_date' => 'date',
            'goals_completed' => 'boolean',
            'ready_for_next_month' => 'boolean',
        ];
    }

    /**
     * Get the student (user) that owns this review.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the roadmap enrollment that this review belongs to.
     */
    public function roadmapEnrollment(): BelongsTo
    {
        return $this->belongsTo(RoadmapEnrollment::class, 'enrollment_id');
    }
}
