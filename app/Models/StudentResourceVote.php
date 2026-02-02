<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentResourceVote extends Model
{
    protected $fillable = [
        'student_resource_id',
        'student_id',
        'is_helpful',
    ];

    protected $casts = [
        'is_helpful' => 'boolean',
    ];

    /**
     * The resource being voted on
     */
    public function studentResource(): BelongsTo
    {
        return $this->belongsTo(StudentResource::class);
    }

    /**
     * The student who voted
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
