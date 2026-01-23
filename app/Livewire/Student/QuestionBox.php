<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\Attributes\Locked;

class QuestionBox extends Component
{
    #[Locked]
    public $taskId;

    #[Locked]
    public $enrollmentId;

    public $showQuestionForm = false;
    public $question = '';
    public $myQuestions = [];
    public $publicQuestions = [];

    public function mount($taskId, $enrollmentId)
    {
        $this->taskId = $taskId;
        $this->enrollmentId = $enrollmentId;
        $this->loadQuestions();
    }

    public function toggleQuestionForm()
    {
        $this->showQuestionForm = !$this->showQuestionForm;
        if (!$this->showQuestionForm) {
            $this->question = '';
        }
    }

    public function loadQuestions()
    {
        // Load user's own questions (both public and private)
        $this->myQuestions = \App\Models\StudentQuestion::where('student_id', auth()->id())
            ->where('task_id', $this->taskId)
            ->with(['answeredByUser', 'student'])
            ->latest()
            ->get()
            ->toArray();

        // Load all public questions from other students
        $this->publicQuestions = \App\Models\StudentQuestion::where('task_id', $this->taskId)
            ->where('student_id', '!=', auth()->id())
            ->where('is_public', true)
            ->where('status', 'answered') // Only show answered public questions
            ->with(['answeredByUser', 'student'])
            ->latest()
            ->get()
            ->toArray();
    }

    public function submitQuestion()
    {
        $this->validate([
            'question' => 'required|min:10|max:1000',
        ]);

        \App\Models\StudentQuestion::create([
            'student_id' => auth()->id(),
            'task_id' => $this->taskId,
            'enrollment_id' => $this->enrollmentId,
            'question' => $this->question,
            'status' => 'pending',
        ]);

        session()->flash('question-submitted', 'Your question has been submitted! We\'ll get back to you soon.');

        $this->question = '';
        $this->showQuestionForm = false;
        $this->loadQuestions();
    }

    public function render()
    {
        return view('livewire.student.question-box');
    }
}
