<?php

namespace App\Livewire;

use App\Models\Feedback;
use Livewire\Component;

class FeedbackButton extends Component
{
    public $showModal = false;
    public $type = 'other';
    public $subject = '';
    public $message = '';
    public $submitSuccess = false;

    protected $rules = [
        'type' => 'required|in:bug,feature,improvement,other',
        'subject' => 'required|string|min:5|max:200',
        'message' => 'required|string|min:10|max:2000',
    ];

    protected $messages = [
        'subject.required' => 'Please provide a subject for your feedback.',
        'subject.min' => 'Subject must be at least 5 characters.',
        'message.required' => 'Please describe your feedback in detail.',
        'message.min' => 'Message must be at least 10 characters.',
    ];

    public function openModal()
    {
        $this->showModal = true;
        $this->submitSuccess = false;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['type', 'subject', 'message', 'submitSuccess']);
        $this->resetValidation();
    }

    public function submitFeedback()
    {
        $this->validate();

        Feedback::create([
            'user_id' => auth()->id(),
            'type' => $this->type,
            'subject' => $this->subject,
            'message' => $this->message,
            'page_url' => url()->previous(),
            'status' => 'new',
        ]);

        $this->submitSuccess = true;

        // Reset form after 2 seconds and close modal
        $this->dispatch('feedback-submitted');

        // Reset and close
        $this->reset(['type', 'subject', 'message']);

        // Close modal after showing success message briefly
        $this->showModal = false;
        $this->submitSuccess = false;
    }

    public function render()
    {
        return view('livewire.feedback-button');
    }
}
