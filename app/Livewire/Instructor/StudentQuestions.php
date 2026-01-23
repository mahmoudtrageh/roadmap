<?php

namespace App\Livewire\Instructor;

use App\Models\StudentQuestion;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class StudentQuestions extends Component
{
    use WithPagination;

    public $selectedQuestionId = null;
    public $showAnswerForm = false;

    #[Validate('required|string|min:10')]
    public $answer = '';

    public $isPublic = false;

    public $filterStatus = 'pending';
    public $searchStudent = '';

    public function mount(): void
    {
        if (!Auth::user()->isInstructor() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function getQuestionsProperty()
    {
        $query = StudentQuestion::with([
            'student',
            'task.roadmap',
            'enrollment',
            'answeredByUser'
        ]);

        if ($this->filterStatus !== 'all') {
            $query->where('status', $this->filterStatus);
        }

        if ($this->searchStudent) {
            $query->whereHas('student', function ($q) {
                $q->where('name', 'like', '%' . $this->searchStudent . '%')
                    ->orWhere('email', 'like', '%' . $this->searchStudent . '%');
            });
        }

        return $query->latest()->paginate(10);
    }

    public function getSelectedQuestionProperty()
    {
        if (!$this->selectedQuestionId) {
            return null;
        }

        return StudentQuestion::with([
            'student',
            'task.roadmap',
            'enrollment',
            'answeredByUser'
        ])->findOrFail($this->selectedQuestionId);
    }

    public function viewQuestion($questionId): void
    {
        $this->selectedQuestionId = $questionId;
        $this->showAnswerForm = true;

        $question = StudentQuestion::find($questionId);
        if ($question && $question->answer) {
            $this->answer = $question->answer;
            $this->isPublic = $question->is_public ?? false;
        } else {
            $this->reset(['answer']);
            $this->isPublic = false;
        }
    }

    public function closeAnswerForm(): void
    {
        $this->showAnswerForm = false;
        $this->selectedQuestionId = null;
        $this->reset(['answer', 'isPublic']);
    }

    public function submitAnswer(): void
    {
        $this->validate();

        try {
            $question = StudentQuestion::findOrFail($this->selectedQuestionId);

            $question->update([
                'answer' => $this->answer,
                'status' => 'answered',
                'answered_by' => Auth::id(),
                'answered_at' => now(),
                'is_public' => $this->isPublic,
            ]);

            session()->flash('message', 'Answer submitted successfully.');
            $this->closeAnswerForm();
            $this->resetPage();
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function markAsAnswered($questionId): void
    {
        try {
            $question = StudentQuestion::findOrFail($questionId);
            $question->status = 'answered';
            $question->save();

            session()->flash('message', 'Question marked as answered.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function deleteQuestion($questionId): void
    {
        try {
            $question = StudentQuestion::findOrFail($questionId);
            $question->delete();

            session()->flash('message', 'Question deleted successfully.');
            $this->resetPage();
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function updatedFilterStatus(): void
    {
        $this->resetPage();
    }

    public function updatedSearchStudent(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.instructor.student-questions', [
            'questions' => $this->questions,
            'selectedQuestion' => $this->selectedQuestion,
        ]);
    }
}
