<?php

namespace App\Livewire\Student;

use App\Models\TaskExam;
use App\Models\ExamAttempt;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class TakeExam extends Component
{
    public $taskId;
    public $task;
    public $exam;
    public $questions;
    public $answers = [];
    public $attemptNumber = 1;
    public $previousAttempts = [];
    public $showResults = false;
    public $currentAttempt = null;

    public function mount($taskId)
    {
        $this->taskId = $taskId;
        $this->task = \App\Models\Task::with('exam.questions')->findOrFail($taskId);
        $this->exam = $this->task->exam;

        if (!$this->exam) {
            session()->flash('error', 'No exam available for this task.');
            return redirect()->route('student.tasks');
        }

        $this->questions = $this->exam->questions()->inRandomOrder()->get();

        $this->previousAttempts = ExamAttempt::where('task_exam_id', $this->exam->id)
            ->where('user_id', Auth::id())
            ->orderBy('attempt_number', 'desc')
            ->get();

        $this->attemptNumber = $this->previousAttempts->count() + 1;
    }

    public function submitExam()
    {
        if ($this->attemptNumber > 2) {
            session()->flash('error', 'Maximum attempts reached.');
            return redirect()->route('student.tasks');
        }

        // Validate all questions are answered
        if (count($this->answers) < $this->questions->count()) {
            session()->flash('error', 'Please answer all questions before submitting.');
            return;
        }

        $correctAnswers = 0;
        $totalQuestions = $this->questions->count();

        foreach ($this->questions as $index => $question) {
            $userAnswer = $this->answers[$question->id] ?? null;
            if ($userAnswer !== null && (int)$userAnswer === $question->correct_answer) {
                $correctAnswers++;
            }
        }

        $score = ($correctAnswers / $totalQuestions) * 100;
        $passed = $score >= $this->exam->passing_score;

        $this->currentAttempt = ExamAttempt::create([
            'task_exam_id' => $this->exam->id,
            'user_id' => Auth::id(),
            'score' => $score,
            'attempt_number' => $this->attemptNumber,
            'answers' => $this->answers,
            'passed' => $passed,
        ]);

        $this->showResults = true;
        $this->previousAttempts = $this->previousAttempts->prepend($this->currentAttempt);
    }

    public function retryExam()
    {
        if ($this->attemptNumber >= 2) {
            session()->flash('error', 'Maximum attempts reached.');
            return;
        }

        $this->reset(['answers', 'showResults', 'currentAttempt']);
        $this->questions = $this->exam->questions()->inRandomOrder()->get();
        $this->attemptNumber++;
    }

    public function backToTasks()
    {
        return redirect()->route('student.tasks');
    }

    public function render()
    {
        return view('livewire.student.take-exam');
    }
}
