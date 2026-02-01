<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Roadmap extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'slug',
        'creator_id',
        'duration_days',
        'difficulty_level',
        'is_published',
        'is_featured',
        'requires_enrollment',
        'image_path',
        'order',
        'prerequisite_roadmap_id',
        'average_rating',
        'rating_count',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'requires_enrollment' => 'boolean',
        'duration_days' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($roadmap) {
            if (empty($roadmap->slug)) {
                $roadmap->slug = Str::slug($roadmap->title);
            }
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class)->orderBy('day_number')->orderBy('order');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(RoadmapEnrollment::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(RoadmapRating::class);
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }
}
