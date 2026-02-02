<?php

namespace App\Livewire\Admin;

use App\Models\Task;
use App\Models\TaskExam;
use App\Models\ExamQuestion;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class ExamManager extends Component
{
    public $taskId;
    public $task;
    public $exam;
    public $questions = [];
    public $editingQuestion = null;
    public $questionForm = [
        'question' => '',
        'option_a' => '',
        'option_b' => '',
        'option_c' => '',
        'option_d' => '',
        'correct_answer' => 0,
    ];
    public $passingScore = 60;

    protected $rules = [
        'questionForm.question' => 'required|string|min:5',
        'questionForm.option_a' => 'required|string',
        'questionForm.option_b' => 'required|string',
        'questionForm.option_c' => 'required|string',
        'questionForm.option_d' => 'required|string',
        'questionForm.correct_answer' => 'required|integer|min:0|max:3',
        'passingScore' => 'required|integer|min:0|max:100',
    ];

    public function mount($taskId)
    {
        $this->taskId = $taskId;
        $this->task = Task::with('exam.questions')->findOrFail($taskId);
        $this->exam = $this->task->exam;

        if (!$this->exam) {
            $this->exam = TaskExam::create([
                'task_id' => $this->task->id,
                'questions_count' => 5,
                'passing_score' => 60,
            ]);
        }

        $this->passingScore = $this->exam->passing_score;
        $this->loadQuestions();
    }

    public function loadQuestions()
    {
        $this->questions = $this->exam->questions()->orderBy('id')->get()->toArray();
    }

    public function editQuestion($questionId)
    {
        $question = ExamQuestion::find($questionId);
        if ($question) {
            $this->editingQuestion = $questionId;
            $this->questionForm = [
                'question' => $question->question,
                'option_a' => $question->options[0] ?? '',
                'option_b' => $question->options[1] ?? '',
                'option_c' => $question->options[2] ?? '',
                'option_d' => $question->options[3] ?? '',
                'correct_answer' => $question->correct_answer,
            ];
        }
    }

    public function saveQuestion()
    {
        $this->validate();

        $options = [
            $this->questionForm['option_a'],
            $this->questionForm['option_b'],
            $this->questionForm['option_c'],
            $this->questionForm['option_d'],
        ];

        if ($this->editingQuestion) {
            $question = ExamQuestion::find($this->editingQuestion);
            $question->update([
                'question' => $this->questionForm['question'],
                'options' => $options,
                'correct_answer' => $this->questionForm['correct_answer'],
            ]);
        } else {
            ExamQuestion::create([
                'task_exam_id' => $this->exam->id,
                'question' => $this->questionForm['question'],
                'options' => $options,
                'correct_answer' => $this->questionForm['correct_answer'],
            ]);
        }

        $this->reset('questionForm', 'editingQuestion');
        $this->loadQuestions();
        session()->flash('message', 'Question saved successfully!');
    }

    public function deleteQuestion($questionId)
    {
        ExamQuestion::find($questionId)?->delete();
        $this->loadQuestions();
        session()->flash('message', 'Question deleted successfully!');
    }

    public function cancelEdit()
    {
        $this->reset('questionForm', 'editingQuestion');
    }

    public function updatePassingScore()
    {
        $this->validate(['passingScore' => 'required|integer|min:0|max:100']);
        $this->exam->update(['passing_score' => $this->passingScore]);
        session()->flash('message', 'Passing score updated!');
    }

    public function render()
    {
        return view('livewire.admin.exam-manager');
    }
}
