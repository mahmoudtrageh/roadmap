<?php

namespace App\Livewire\Student;

use App\Models\StudentQuizAttempt;
use App\Models\TaskQuiz;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;

class QuizBox extends Component
{
    #[Locked]
    public $taskId;

    #[Locked]
    public $enrollmentId;

    #[Locked]
    public $isLocked = false;

    public $quizId;
    public $questions = [];
    public $introduction = '';
    public $passingScore = 60;

    // Quiz state
    public $answers = [];
    public $showResults = false;
    public $score = 0;
    public $correctCount = 0;
    public $totalQuestions = 0;
    public $passed = false;
    public $attemptId = null;

    public function mount(): void
    {
        if (!$this->enrollmentId) {
            return;
        }

        // Load the quiz for this task
        $quiz = TaskQuiz::where('task_id', $this->taskId)
            ->where('is_active', true)
            ->first();

        if (!$quiz) {
            return;
        }

        $this->quizId = $quiz->id;
        $this->questions = $quiz->questions ?? [];
        $this->introduction = $quiz->introduction ?? '';
        $this->passingScore = $quiz->passing_score ?? 60;
        $this->totalQuestions = count($this->questions);

        // Check for existing attempt
        $attempt = StudentQuizAttempt::where('student_id', Auth::id())
            ->where('task_quiz_id', $quiz->id)
            ->where('enrollment_id', $this->enrollmentId)
            ->latest()
            ->first();

        if ($attempt && $attempt->completed_at) {
            // Load previous results
            $this->attemptId = $attempt->id;
            $this->answers = $attempt->answers ?? [];
            $this->score = $attempt->score;
            $this->correctCount = $attempt->correct_count;
            $this->passed = $attempt->passed;
            $this->showResults = true;
        } else {
            // Initialize empty answers
            $this->answers = array_fill(0, $this->totalQuestions, null);
        }
    }

    public function selectAnswer($questionIndex, $optionIndex)
    {
        if ($this->isLocked || $this->showResults) {
            return;
        }

        $this->answers[$questionIndex] = $optionIndex;
    }

    public function submitQuiz()
    {
        if ($this->isLocked || $this->showResults) {
            return;
        }

        // Check if all questions are answered
        foreach ($this->answers as $answer) {
            if ($answer === null) {
                session()->flash('quiz-error', 'Please answer all questions before submitting.');
                return;
            }
        }

        // Get correct answers
        $correctAnswers = [];
        foreach ($this->questions as $question) {
            $correctAnswers[] = $question['correct_answer'] ?? 0;
        }

        // Create or update attempt
        $attempt = StudentQuizAttempt::updateOrCreate(
            [
                'student_id' => Auth::id(),
                'task_quiz_id' => $this->quizId,
                'enrollment_id' => $this->enrollmentId,
            ],
            [
                'answers' => $this->answers,
                'total_questions' => $this->totalQuestions,
            ]
        );

        // Calculate score
        $attempt->calculateScore($correctAnswers);

        // Update local state
        $this->attemptId = $attempt->id;
        $this->score = $attempt->score;
        $this->correctCount = $attempt->correct_count;
        $this->passed = $attempt->passed;
        $this->showResults = true;

        // Dispatch event
        $this->dispatch('quiz-completed', [
            'taskId' => $this->taskId,
            'score' => $this->score,
            'passed' => $this->passed,
        ]);
    }

    public function retakeQuiz()
    {
        if ($this->isLocked) {
            return;
        }

        $this->answers = array_fill(0, $this->totalQuestions, null);
        $this->showResults = false;
        $this->score = 0;
        $this->correctCount = 0;
        $this->passed = false;
    }

    public function render(): View
    {
        return view('livewire.student.quiz-box');
    }
}
