<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskExam extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'questions_count',
        'passing_score',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function questions()
    {
        return $this->hasMany(ExamQuestion::class);
    }

    public function attempts()
    {
        return $this->hasMany(ExamAttempt::class);
    }

    public function userAttempts($userId)
    {
        return $this->attempts()->where('user_id', $userId)->orderBy('attempt_number');
    }
}
