<?php

namespace App\Livewire\Instructor;

use App\Models\CodeReview;
use App\Models\CodeSubmission;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class CodeReviewQueue extends Component
{
    use WithPagination;

    public $selectedSubmissionId = null;
    public $showReviewForm = false;

    #[Validate('required|string')]
    public $feedback = '';

    #[Validate('required|integer|min:1|max:10')]
    public $rating = 5;

    #[Validate('required|in:approved,needs_revision')]
    public $status = 'approved';

    public $filterStatus = 'submitted';
    public $filterLanguage = 'all';
    public $searchStudent = '';

    public function mount(): void
    {
        if (!Auth::user()->isInstructor() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function getSubmissionsProperty()
    {
        $query = CodeSubmission::with([
            'student',
            'taskCompletion.task.roadmap',
            'codeReviews' => function ($q) {
                $q->latest()->limit(1);
            }
        ]);

        if ($this->filterStatus !== 'all') {
            $query->where('submission_status', $this->filterStatus);
        }

        if ($this->filterLanguage !== 'all') {
            $query->where('language', $this->filterLanguage);
        }

        if ($this->searchStudent) {
            $query->whereHas('student', function ($q) {
                $q->where('name', 'like', '%' . $this->searchStudent . '%')
                    ->orWhere('email', 'like', '%' . $this->searchStudent . '%');
            });
        }

        return $query->latest()->paginate(10);
    }

    public function getLanguagesProperty()
    {
        return CodeSubmission::distinct()->pluck('language')->filter()->toArray();
    }

    public function getSelectedSubmissionProperty()
    {
        if (!$this->selectedSubmissionId) {
            return null;
        }

        return CodeSubmission::with([
            'student',
            'taskCompletion.task.roadmap',
            'codeReviews.reviewer'
        ])->findOrFail($this->selectedSubmissionId);
    }

    public function viewSubmission($submissionId): void
    {
        $this->selectedSubmissionId = $submissionId;
        $this->showReviewForm = true;
        $this->reset(['feedback', 'rating', 'status']);
    }

    public function closeReviewForm(): void
    {
        $this->showReviewForm = false;
        $this->selectedSubmissionId = null;
        $this->reset(['feedback', 'rating', 'status']);
    }

    public function submitReview(): void
    {
        $this->validate();

        try {
            $submission = CodeSubmission::findOrFail($this->selectedSubmissionId);

            // Create the code review
            CodeReview::create([
                'code_submission_id' => $this->selectedSubmissionId,
                'reviewer_id' => Auth::id(),
                'feedback' => $this->feedback,
                'rating' => $this->rating,
                'status' => $this->status,
                'reviewed_at' => now(),
            ]);

            // Update submission status
            $submission->submission_status = $this->status;
            $submission->save();

            session()->flash('message', 'Code review submitted successfully.');
            $this->closeReviewForm();
            $this->resetPage();
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function markAsReviewed($submissionId, $status): void
    {
        try {
            $submission = CodeSubmission::findOrFail($submissionId);
            $submission->submission_status = $status;
            $submission->save();

            session()->flash('message', 'Submission status updated.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function updatedFilterStatus(): void
    {
        $this->resetPage();
    }

    public function updatedFilterLanguage(): void
    {
        $this->resetPage();
    }

    public function updatedSearchStudent(): void
    {
        $this->resetPage();
    }

    public function downloadSubmission($submissionId)
    {
        $submission = CodeSubmission::findOrFail($submissionId);

        if (!$submission->file_path) {
            session()->flash('error', 'No file to download.');
            return;
        }

        return \Storage::disk('local')->download(
            $submission->file_path,
            $submission->original_filename
        );
    }

    public function render()
    {
        return view('livewire.instructor.code-review-queue', [
            'submissions' => $this->submissions,
            'languages' => $this->languages,
            'selectedSubmission' => $this->selectedSubmission,
        ]);
    }
}
