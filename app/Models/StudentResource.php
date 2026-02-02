<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentResource extends Model
{
    protected $fillable = [
        'task_id',
        'student_id',
        'url',
        'title',
        'description',
        'type',
        'helpful_count',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'helpful_count' => 'integer',
    ];

    /**
     * The task this resource belongs to
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * The student who contributed this resource
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Votes on this resource
     */
    public function votes(): HasMany
    {
        return $this->hasMany(StudentResourceVote::class);
    }

    /**
     * Check if current user voted this resource as helpful
     */
    public function isVotedHelpfulBy($studentId): bool
    {
        return $this->votes()
            ->where('student_id', $studentId)
            ->where('is_helpful', true)
            ->exists();
    }

    /**
     * Toggle helpful vote
     */
    public function toggleHelpful($studentId): bool
    {
        $vote = $this->votes()->where('student_id', $studentId)->first();

        if ($vote) {
            // Remove vote
            $vote->delete();
            $this->decrement('helpful_count');
            return false;
        } else {
            // Add vote
            $this->votes()->create([
                'student_id' => $studentId,
                'is_helpful' => true,
            ]);
            $this->increment('helpful_count');
            return true;
        }
    }
}
