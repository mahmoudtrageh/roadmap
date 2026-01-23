<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'roadmap_id',
        'title',
        'description',
        'day_number',
        'estimated_time_minutes',
        'task_type',
        'category',
        'order',
        'resources_links',
        'resources', // New structured resources with language support
        'has_code_submission',
        'has_quality_rating',
        // Enhanced fields for task splitting
        'parent_task_id',
        'is_split_task',
        'part_number',
        'total_parts',
        // Enhanced fields for learning experience
        'learning_objectives',
        'skills_gained',
        'tags',
        'difficulty_level',
        // Phase 1 enhancements
        'success_criteria',
        'common_mistakes',
        'quick_tips',
        'prerequisites',
        'recommended_tasks',
        // Analytics fields (typically managed by system, but included for flexibility)
        'actual_avg_time_minutes',
        'completion_count',
        'average_rating',
        'skip_count',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'day_number' => 'integer',
            'estimated_time_minutes' => 'integer',
            'order' => 'integer',
            'resources_links' => 'array',
            'resources' => 'array', // Structured resources with language support
            'has_code_submission' => 'boolean',
            'has_quality_rating' => 'boolean',
            // Task splitting fields
            'parent_task_id' => 'integer',
            'is_split_task' => 'boolean',
            'part_number' => 'integer',
            'total_parts' => 'integer',
            // Learning experience fields
            'learning_objectives' => 'array',
            'skills_gained' => 'array',
            'tags' => 'array',
            // Phase 1 enhancements
            'success_criteria' => 'array',
            'prerequisites' => 'array',
            'recommended_tasks' => 'array',
            // Analytics fields
            'actual_avg_time_minutes' => 'integer',
            'completion_count' => 'integer',
            'average_rating' => 'decimal:2',
            'skip_count' => 'integer',
        ];
    }

    /**
     * Get the roadmap that this task belongs to.
     */
    public function roadmap(): BelongsTo
    {
        return $this->belongsTo(Roadmap::class);
    }

    /**
     * Get the task completions for this task.
     */
    public function taskCompletions(): HasMany
    {
        return $this->hasMany(TaskCompletion::class);
    }

    /**
     * Get the notes for this task.
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class);
    }

    /**
     * Get the resource ratings for this task.
     */
    public function resourceRatings(): HasMany
    {
        return $this->hasMany(ResourceRating::class);
    }

    /**
     * Get the resource comments for this task.
     */
    public function resourceComments(): HasMany
    {
        return $this->hasMany(ResourceComment::class);
    }

    /**
     * Get the checklists for this task.
     */
    public function checklists(): HasMany
    {
        return $this->hasMany(TaskChecklist::class);
    }

    /**
     * Get the active checklist for this task.
     */
    public function activeChecklist()
    {
        return $this->hasOne(TaskChecklist::class)->where('is_active', true);
    }


    /**
     * Get the code examples for this task.
     */
    public function examples(): HasMany
    {
        return $this->hasMany(TaskExample::class);
    }

    /**
     * Get active code examples ordered by difficulty and order.
     */
    public function activeExamples()
    {
        return $this->hasMany(TaskExample::class)
            ->where('is_active', true)
            ->orderBy('order');
    }

    /**
     * Get the hints for this task.
     */
    public function hints(): HasMany
    {
        return $this->hasMany(TaskHint::class);
    }

    /**
     * Get the active hints for this task.
     */
    public function activeHints()
    {
        return $this->hasOne(TaskHint::class)->where('is_active', true);
    }

    /**
     * Get questions asked about this task.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(StudentQuestion::class);
    }

    /**
     * Get the parent task if this is a split task.
     */
    public function parentTask(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'parent_task_id');
    }

    /**
     * Get all child tasks (parts) if this task was split.
     */
    public function childTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'parent_task_id');
    }

    /**
     * Get all sibling tasks (other parts from the same parent).
     */
    public function siblingTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'parent_task_id')
            ->where('id', '!=', $this->id);
    }

    /**
     * Check if this task is part of a multi-part task.
     */
    public function isPartOfSplit(): bool
    {
        return $this->is_split_task && $this->parent_task_id !== null;
    }

    /**
     * Get formatted part display (e.g., "Part 1 of 3").
     */
    public function getPartDisplay(): ?string
    {
        if (!$this->isPartOfSplit()) {
            return null;
        }

        return "Part {$this->part_number} of {$this->total_parts}";
    }

    /**
     * Scope to get only non-split tasks.
     */
    public function scopeOriginalTasks($query)
    {
        return $query->where('is_split_task', false);
    }

    /**
     * Scope to get only split tasks.
     */
    public function scopeSplitTasks($query)
    {
        return $query->where('is_split_task', true);
    }

    /**
     * Scope to filter by difficulty level.
     */
    public function scopeDifficulty($query, string $level)
    {
        return $query->where('difficulty_level', $level);
    }

    /**
     * Scope to filter by tags.
     */
    public function scopeWithTag($query, string $tag)
    {
        return $query->whereJsonContains('tags', $tag);
    }

    /**
     * Get prerequisite tasks.
     */
    public function prerequisiteTasks()
    {
        if (!$this->prerequisites || !is_array($this->prerequisites) || count($this->prerequisites) === 0) {
            return collect([]);
        }

        return Task::whereIn('id', $this->prerequisites)->get();
    }

    /**
     * Get recommended tasks.
     */
    public function recommendedTasksList()
    {
        if (!$this->recommended_tasks || !is_array($this->recommended_tasks) || count($this->recommended_tasks) === 0) {
            return collect([]);
        }

        return Task::whereIn('id', $this->recommended_tasks)->get();
    }

    /**
     * Check if all prerequisites are met for a given student.
     */
    public function hasMetPrerequisites(int $studentId, int $enrollmentId): bool
    {
        if (!$this->prerequisites || !is_array($this->prerequisites) || count($this->prerequisites) === 0) {
            return true;
        }

        $completedTaskIds = \App\Models\TaskCompletion::where('student_id', $studentId)
            ->where('enrollment_id', $enrollmentId)
            ->whereIn('status', ['completed', 'skipped'])
            ->pluck('task_id')
            ->toArray();

        foreach ($this->prerequisites as $prereqId) {
            if (!in_array($prereqId, $completedTaskIds)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get tasks that depend on this task (reverse lookup).
     */
    public function getDependentTasks()
    {
        return Task::where('roadmap_id', $this->roadmap_id)
            ->whereJsonContains('prerequisites', $this->id)
            ->get();
    }

    /**
     * Get tasks that recommend this task (reverse lookup).
     */
    public function getRecommendingTasks()
    {
        return Task::where('roadmap_id', $this->roadmap_id)
            ->whereJsonContains('recommended_tasks', $this->id)
            ->get();
    }

    /**
     * Get resources filtered by language.
     *
     * @param string $language Language code ('en', 'ar', 'both')
     * @return array
     */
    public function getResourcesByLanguage(string $language = 'both'): array
    {
        if (!$this->resources || !is_array($this->resources)) {
            return [];
        }

        if ($language === 'both') {
            return $this->resources;
        }

        return array_filter($this->resources, function($resource) use ($language) {
            return isset($resource['language']) && $resource['language'] === $language;
        });
    }

    /**
     * Get resources grouped by language.
     *
     * @return array ['en' => [], 'ar' => []]
     */
    public function getResourcesGroupedByLanguage(): array
    {
        if (!$this->resources || !is_array($this->resources)) {
            return ['en' => [], 'ar' => []];
        }

        $grouped = ['en' => [], 'ar' => []];

        foreach ($this->resources as $resource) {
            $lang = $resource['language'] ?? 'en';
            if (!isset($grouped[$lang])) {
                $grouped[$lang] = [];
            }
            $grouped[$lang][] = $resource;
        }

        return $grouped;
    }

    /**
     * Check if task has resources in a specific language.
     *
     * @param string $language Language code ('en' or 'ar')
     * @return bool
     */
    public function hasResourcesInLanguage(string $language): bool
    {
        if (!$this->resources || !is_array($this->resources)) {
            return false;
        }

        foreach ($this->resources as $resource) {
            if (isset($resource['language']) && $resource['language'] === $language) {
                return true;
            }
        }

        return false;
    }
}
