<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskExample extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'task_id',
        'title',
        'description',
        'code',
        'language',
        'difficulty',
        'order',
        'explanation',
        'output',
        'is_interactive',
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
            'is_interactive' => 'boolean',
            'is_active' => 'boolean',
            'order' => 'integer',
        ];
    }

    /**
     * Get the task that this example belongs to.
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Scope to get only active examples.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by difficulty.
     */
    public function scopeOrderedByDifficulty($query)
    {
        return $query->orderByRaw("FIELD(difficulty, 'beginner', 'intermediate', 'advanced')");
    }

    /**
     * Get language display name.
     */
    public function getLanguageDisplay(): string
    {
        $languages = [
            'javascript' => 'JavaScript',
            'python' => 'Python',
            'php' => 'PHP',
            'java' => 'Java',
            'cpp' => 'C++',
            'csharp' => 'C#',
            'html' => 'HTML',
            'css' => 'CSS',
            'sql' => 'SQL',
            'bash' => 'Bash',
        ];

        return $languages[$this->language] ?? ucfirst($this->language);
    }
}
