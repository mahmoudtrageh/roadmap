<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskHint extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'task_id',
        'hints',
        'introduction',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'hints' => 'array',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the task that this hint belongs to.
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get hint usage records.
     */
    public function usageRecords(): HasMany
    {
        return $this->hasMany(StudentHintUsage::class, 'task_id', 'task_id');
    }

    /**
     * Get total number of hints.
     */
    public function getTotalHints(): int
    {
        return is_array($this->hints) ? count($this->hints) : 0;
    }

    /**
     * Get specific hint by level (0-indexed).
     */
    public function getHint(int $level): ?array
    {
        if (is_array($this->hints) && isset($this->hints[$level])) {
            return $this->hints[$level];
        }
        return null;
    }

    /**
     * Scope to get only active hints.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
