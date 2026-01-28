<?php

namespace App\Livewire\Admin;

use App\Models\Feedback;
use Livewire\Component;
use Livewire\WithPagination;

class FeedbackManager extends Component
{
    use WithPagination;

    public $filterStatus = 'all';
    public $filterType = 'all';
    public $selectedFeedback = null;
    public $showDetailModal = false;
    public $adminNotes = '';

    protected $queryString = ['filterStatus', 'filterType'];

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function updatingFilterType()
    {
        $this->resetPage();
    }

    public function viewFeedback($feedbackId)
    {
        $this->selectedFeedback = Feedback::with('user')->find($feedbackId);
        $this->adminNotes = $this->selectedFeedback->admin_notes ?? '';
        $this->showDetailModal = true;
    }

    public function closeDetailModal()
    {
        $this->showDetailModal = false;
        $this->selectedFeedback = null;
        $this->adminNotes = '';
    }

    public function updateStatus($feedbackId, $status)
    {
        $feedback = Feedback::find($feedbackId);

        if ($feedback) {
            $feedback->update([
                'status' => $status,
                'resolved_at' => $status === 'resolved' ? now() : null,
            ]);

            session()->flash('message', 'Feedback status updated successfully.');
        }
    }

    public function saveNotes()
    {
        if ($this->selectedFeedback) {
            $this->selectedFeedback->update([
                'admin_notes' => $this->adminNotes,
            ]);

            $this->selectedFeedback->refresh();
            session()->flash('message', 'Admin notes saved successfully.');
        }
    }

    public function markAsResolved()
    {
        if ($this->selectedFeedback) {
            $this->selectedFeedback->markAsResolved($this->adminNotes);
            $this->selectedFeedback->refresh();
            session()->flash('message', 'Feedback marked as resolved.');
        }
    }

    public function render()
    {
        $query = Feedback::with('user')->latest();

        if ($this->filterStatus !== 'all') {
            $query->where('status', $this->filterStatus);
        }

        if ($this->filterType !== 'all') {
            $query->where('type', $this->filterType);
        }

        $feedback = $query->paginate(20);

        $stats = [
            'total' => Feedback::count(),
            'new' => Feedback::where('status', 'new')->count(),
            'in_progress' => Feedback::where('status', 'in_progress')->count(),
            'resolved' => Feedback::where('status', 'resolved')->count(),
        ];

        return view('livewire.admin.feedback-manager', [
            'feedback' => $feedback,
            'stats' => $stats,
        ]);
    }
}
