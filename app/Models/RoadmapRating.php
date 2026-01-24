<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoadmapRating extends Model
{
    protected $fillable = [
        'student_id',
        'roadmap_id',
        'rating',
        'review',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    /**
     * Student who rated the roadmap
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Roadmap being rated
     */
    public function roadmap(): BelongsTo
    {
        return $this->belongsTo(Roadmap::class);
    }

    /**
     * Update roadmap average rating after creating/updating/deleting a rating
     */
    protected static function booted(): void
    {
        static::created(function ($rating) {
            $rating->updateRoadmapAverageRating();
        });

        static::updated(function ($rating) {
            $rating->updateRoadmapAverageRating();
        });

        static::deleted(function ($rating) {
            $rating->updateRoadmapAverageRating();
        });
    }

    /**
     * Recalculate and update the roadmap's average rating
     */
    public function updateRoadmapAverageRating(): void
    {
        $roadmap = $this->roadmap;

        $stats = static::where('roadmap_id', $roadmap->id)
            ->selectRaw('AVG(rating) as average, COUNT(*) as count')
            ->first();

        $roadmap->update([
            'average_rating' => $stats->average ? round($stats->average, 2) : 0,
            'rating_count' => $stats->count,
        ]);
    }
}
