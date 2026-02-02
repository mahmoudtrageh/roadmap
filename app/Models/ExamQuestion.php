<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_exam_id',
        'question',
        'options',
        'correct_answer',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function taskExam()
    {
        return $this->belongsTo(TaskExam::class);
    }
}
