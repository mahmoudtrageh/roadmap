<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Achievement extends Model
{
    protected $fillable = [
        'key',
        'name',
        'description',
        'icon',
        'category',
        'requirement_value',
        'badge_color',
        'points',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'requirement_value' => 'integer',
        'points' => 'integer',
    ];

    /**
     * Users who have earned this achievement
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_achievements')
            ->withPivot('earned_at', 'metadata')
            ->withTimestamps();
    }
}
