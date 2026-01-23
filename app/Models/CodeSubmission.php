<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CodeSubmission extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'task_completion_id',
        'student_id',
        'code_content',
        'language',
        'file_path',
        'submission_status',
    ];

    /**
     * Get the task completion that this submission belongs to.
     */
    public function taskCompletion(): BelongsTo
    {
        return $this->belongsTo(TaskCompletion::class);
    }

    /**
     * Get the student (user) that owns this submission.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the code reviews for this submission.
     */
    public function codeReviews(): HasMany
    {
        return $this->hasMany(CodeReview::class);
    }
}
