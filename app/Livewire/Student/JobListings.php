<?php

namespace App\Livewire\Student;

use App\Models\JobListing;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class JobListings extends Component
{
    use WithPagination;

    public $search = '';
    public $jobType = 'all';
    public $experienceLevel = 'all';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedJobType()
    {
        $this->resetPage();
    }

    public function updatedExperienceLevel()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = JobListing::with('company')
            ->where('status', 'open')
            ->where(function($q) {
                $q->whereNull('deadline')
                  ->orWhere('deadline', '>=', today());
            });

        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhereHas('company', function($cq) {
                      $cq->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->jobType !== 'all') {
            $query->where('job_type', $this->jobType);
        }

        if ($this->experienceLevel !== 'all') {
            $query->where('experience_level', $this->experienceLevel);
        }

        $jobs = $query->latest()->paginate(10);

        return view('livewire.student.job-listings', [
            'jobs' => $jobs,
        ]);
    }
}
