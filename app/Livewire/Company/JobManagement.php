<?php

namespace App\Livewire\Company;

use App\Models\JobListing;
use App\Models\JobQuestion;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class JobManagement extends Component
{
    use WithPagination;

    public $showJobForm = false;
    public $editingJobId = null;

    #[Validate('required|string|max:255')]
    public $title = '';

    #[Validate('required|string')]
    public $description = '';

    #[Validate('nullable|string|max:255')]
    public $location = '';

    #[Validate('required|in:full_time,part_time,contract,internship')]
    public $jobType = 'full_time';

    #[Validate('required|in:entry,mid,senior')]
    public $experienceLevel = 'entry';

    #[Validate('nullable|numeric|min:0')]
    public $salaryMin = '';

    #[Validate('nullable|numeric|min:0')]
    public $salaryMax = '';

    #[Validate('nullable|string')]
    public $requirements = '';

    #[Validate('nullable|string')]
    public $responsibilities = '';

    #[Validate('nullable|string')]
    public $benefits = '';

    #[Validate('required|in:open,closed,filled')]
    public $status = 'open';

    #[Validate('nullable|date')]
    public $deadline = '';

    #[Validate('required|integer|min:1')]
    public $positionsAvailable = 1;

    public $questions = [];

    public function mount()
    {
        if (!auth()->user()->isCompany()) {
            abort(403);
        }
    }

    public function createJob()
    {
        $this->resetForm();
        $this->showJobForm = true;
    }

    public function editJob($jobId)
    {
        $job = JobListing::with('questions')->findOrFail($jobId);

        if ($job->company_id !== auth()->user()->company->id) {
            abort(403);
        }

        $this->editingJobId = $jobId;
        $this->title = $job->title;
        $this->description = $job->description;
        $this->location = $job->location;
        $this->jobType = $job->job_type;
        $this->experienceLevel = $job->experience_level;
        $this->salaryMin = $job->salary_min;
        $this->salaryMax = $job->salary_max;
        $this->requirements = $job->requirements;
        $this->responsibilities = $job->responsibilities;
        $this->benefits = $job->benefits;
        $this->status = $job->status;
        $this->deadline = $job->deadline?->format('Y-m-d');
        $this->positionsAvailable = $job->positions_available;

        $this->questions = $job->questions->map(function($q) {
            // Convert options array to string for editing
            $options = '';
            if (!empty($q->options) && is_array($q->options)) {
                $options = implode("\n", $q->options);
            }

            return [
                'id' => $q->id,
                'question' => $q->question,
                'type' => $q->type,
                'options' => $options,
                'is_required' => $q->is_required,
            ];
        })->toArray();

        $this->showJobForm = true;
    }

    public function saveJob()
    {
        $this->validate();

        $company = auth()->user()->company;

        if (!$company) {
            session()->flash('error', 'Please complete your company profile first.');
            return;
        }

        $data = [
            'company_id' => $company->id,
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location,
            'job_type' => $this->jobType,
            'experience_level' => $this->experienceLevel,
            'salary_min' => $this->salaryMin ?: null,
            'salary_max' => $this->salaryMax ?: null,
            'requirements' => $this->requirements,
            'responsibilities' => $this->responsibilities,
            'benefits' => $this->benefits,
            'status' => $this->status,
            'deadline' => $this->deadline ?: null,
            'positions_available' => $this->positionsAvailable,
        ];

        if ($this->editingJobId) {
            $job = JobListing::findOrFail($this->editingJobId);
            $job->update($data);

            // Update questions
            $job->questions()->delete();
        } else {
            $job = JobListing::create($data);
        }

        // Save questions
        foreach ($this->questions as $index => $q) {
            if (!empty($q['question'])) {
                // Convert options from string to array if it's a string
                $options = null;
                if (isset($q['options']) && !empty($q['options'])) {
                    if (is_string($q['options'])) {
                        // Split by newlines and filter empty lines
                        $options = array_filter(
                            array_map('trim', explode("\n", $q['options'])),
                            fn($option) => !empty($option)
                        );
                    } else {
                        $options = $q['options'];
                    }
                }

                JobQuestion::create([
                    'job_id' => $job->id,
                    'question' => $q['question'],
                    'type' => $q['type'] ?? 'text',
                    'options' => $options,
                    'is_required' => $q['is_required'] ?? true,
                    'order' => $index,
                ]);
            }
        }

        session()->flash('message', 'Job saved successfully!');
        $this->closeJobForm();
    }

    public function deleteJob($jobId)
    {
        $job = JobListing::findOrFail($jobId);

        if ($job->company_id !== auth()->user()->company->id) {
            abort(403);
        }

        $job->delete();
        session()->flash('message', 'Job deleted successfully.');
    }

    public function addQuestion()
    {
        $this->questions[] = [
            'question' => '',
            'type' => 'text',
            'options' => [],
            'is_required' => true,
        ];
    }

    public function removeQuestion($index)
    {
        unset($this->questions[$index]);
        $this->questions = array_values($this->questions);
    }

    public function closeJobForm()
    {
        $this->showJobForm = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset([
            'editingJobId', 'title', 'description', 'location', 'jobType',
            'experienceLevel', 'salaryMin', 'salaryMax', 'requirements',
            'responsibilities', 'benefits', 'status', 'deadline',
            'positionsAvailable', 'questions'
        ]);
    }

    public function render()
    {
        $company = auth()->user()->company;
        $jobs = $company
            ? JobListing::where('company_id', $company->id)
                ->withCount('applications')
                ->latest()
                ->paginate(10)
            : collect();

        return view('livewire.company.job-management', [
            'jobs' => $jobs,
        ]);
    }
}
