<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeeklyReview extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'enrollment_id',
        'week_number',
        'week_start_date',
        'week_end_date',
        'what_learned',
        'applied_to_code',
        'next_week_focus',
        'code_quality_rating',
        'improvements',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'week_number' => 'integer',
            'week_start_date' => 'date',
            'week_end_date' => 'date',
            'code_quality_rating' => 'integer',
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
