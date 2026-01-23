<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentQuizAttempt extends Model
{
    protected $fillable = [
        'student_id',
        'task_quiz_id',
        'enrollment_id',
        'answers',
        'score',
        'correct_count',
        'total_questions',
        'passed',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'answers' => 'array',
            'score' => 'integer',
            'correct_count' => 'integer',
            'total_questions' => 'integer',
            'passed' => 'boolean',
            'completed_at' => 'datetime',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function taskQuiz(): BelongsTo
    {
        return $this->belongsTo(TaskQuiz::class);
    }

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(RoadmapEnrollment::class);
    }

    public function calculateScore(array $correctAnswers): void
    {
        $this->total_questions = count($correctAnswers);
        $this->correct_count = 0;

        foreach ($this->answers as $index => $answer) {
            if (isset($correctAnswers[$index]) && $answer === $correctAnswers[$index]) {
                $this->correct_count++;
            }
        }

        $this->score = $this->total_questions > 0
            ? round(($this->correct_count / $this->total_questions) * 100)
            : 0;

        $quiz = $this->taskQuiz;
        $this->passed = $this->score >= ($quiz->passing_score ?? 60);
        $this->completed_at = now();
        $this->save();
    }
}
