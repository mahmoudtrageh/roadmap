<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\Attributes\Locked;

class HintBox extends Component
{
    #[Locked]
    public $taskId;

    #[Locked]
    public $enrollmentId;

    public $hints = [];
    public $introduction = '';
    public $hintsRevealed = 0;
    public $totalHints = 0;
    public $showQuestionForm = false;
    public $question = '';
    public $studentQuestions = [];

    public function mount($taskId, $enrollmentId)
    {
        $this->taskId = $taskId;
        $this->enrollmentId = $enrollmentId;
        $this->loadHints();
        $this->loadStudentProgress();
        $this->loadStudentQuestions();
    }

    public function loadHints()
    {
        $taskHint = \App\Models\TaskHint::where('task_id', $this->taskId)
            ->where('is_active', true)
            ->first();

        if ($taskHint) {
            $this->hints = $taskHint->hints ?? [];
            $this->introduction = $taskHint->introduction;
            $this->totalHints = count($this->hints);
        }
    }

    public function loadStudentProgress()
    {
        $studentId = auth()->id();

        $usage = \App\Models\StudentHintUsage::firstOrCreate(
            [
                'student_id' => $studentId,
                'task_id' => $this->taskId,
                'enrollment_id' => $this->enrollmentId,
            ],
            [
                'hints_revealed' => 0,
                'revealed_at' => [],
            ]
        );

        $this->hintsRevealed = $usage->hints_revealed;
    }

    public function revealNextHint()
    {
        if ($this->hintsRevealed < $this->totalHints) {
            $studentId = auth()->id();

            $usage = \App\Models\StudentHintUsage::where('student_id', $studentId)
                ->where('task_id', $this->taskId)
                ->where('enrollment_id', $this->enrollmentId)
                ->first();

            if ($usage) {
                $usage->revealNextHint();
                $this->hintsRevealed = $usage->hints_revealed;
            }
        }
    }

    public function toggleQuestionForm()
    {
        $this->showQuestionForm = !$this->showQuestionForm;
        if (!$this->showQuestionForm) {
            $this->question = '';
        }
    }

    public function loadStudentQuestions()
    {
        $this->studentQuestions = \App\Models\StudentQuestion::where('student_id', auth()->id())
            ->where('task_id', $this->taskId)
            ->where('enrollment_id', $this->enrollmentId)
            ->with('answeredByUser')
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
        $this->loadStudentQuestions();
    }

    public function render()
    {
        return view('livewire.student.hint-box');
    }
}
