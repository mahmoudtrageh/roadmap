<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class CommunityComment extends Model
{
    protected $fillable = [
        'post_id',
        'user_id',
        'content',
        'likes_count',
        'is_solution',
    ];

    protected $casts = [
        'is_solution' => 'boolean',
        'likes_count' => 'integer',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(CommunityPost::class, 'post_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(CommunityLike::class, 'likeable');
    }

    public function isLikedBy($userId): bool
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }
}
