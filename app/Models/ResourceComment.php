<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ResourceComment extends Model
{
    protected $fillable = [
        'task_id',
        'user_id',
        'resource_url',
        'comment',
        'parent_id',
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ResourceComment::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(ResourceComment::class, 'parent_id')->with('user', 'replies');
    }
}
