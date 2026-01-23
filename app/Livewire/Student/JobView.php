<?php

namespace App\Livewire\Student;

use App\Models\JobApplication;
use App\Models\JobListing;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class JobView extends Component
{
    use WithFileUploads;

    public $jobId;
    public $job;
    public $hasApplied = false;
    public $showApplicationForm = false;

    #[Validate('required|file|mimes:pdf,doc,docx|max:2048')]
    public $cv;

    #[Validate('nullable|string|max:1000')]
    public $coverLetter = '';

    public $answers = [];

    public function mount($jobId)
    {
        $this->jobId = $jobId;
        $this->job = JobListing::with(['company', 'questions' => function($q) {
            $q->orderBy('order');
        }])->findOrFail($jobId);

        $this->hasApplied = JobApplication::where('job_id', $this->jobId)
            ->where('student_id', auth()->id())
            ->exists();

        // Initialize answers array
        foreach ($this->job->questions as $question) {
            $this->answers[$question->id] = '';
        }
    }

    public function toggleApplicationForm()
    {
        $this->showApplicationForm = !$this->showApplicationForm;
    }

    public function submitApplication()
    {
        $this->validate([
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'coverLetter' => 'nullable|string|max:1000',
        ]);

        // Validate required questions
        foreach ($this->job->questions as $question) {
            if ($question->is_required && empty($this->answers[$question->id])) {
                $this->addError('answers.' . $question->id, 'This question is required');
                return;
            }
        }

        try {
            // Store CV
            $cvPath = $this->cv->store('cvs', 'local');

            // Create application
            JobApplication::create([
                'job_id' => $this->jobId,
                'student_id' => auth()->id(),
                'cv_path' => $cvPath,
                'answers' => $this->answers,
                'cover_letter' => $this->coverLetter,
                'status' => 'pending',
            ]);

            $this->hasApplied = true;
            $this->showApplicationForm = false;
            session()->flash('message', 'Application submitted successfully!');

        } catch (\Exception $e) {
            session()->flash('error', 'Error submitting application: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.student.job-view');
    }
}
