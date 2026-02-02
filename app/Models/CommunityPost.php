<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class CommunityPost extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'category',
        'likes_count',
        'comments_count',
        'is_pinned',
        'is_resolved',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'is_resolved' => 'boolean',
        'likes_count' => 'integer',
        'comments_count' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(CommunityComment::class, 'post_id');
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
