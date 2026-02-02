<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_exam_id',
        'user_id',
        'score',
        'attempt_number',
        'answers',
        'passed',
    ];

    protected $casts = [
        'answers' => 'array',
        'passed' => 'boolean',
    ];

    public function taskExam()
    {
        return $this->belongsTo(TaskExam::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
