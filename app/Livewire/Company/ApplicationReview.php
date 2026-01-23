<?php

namespace App\Livewire\Company;

use App\Models\JobApplication;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class ApplicationReview extends Component
{
    use WithPagination;

    public $filterStatus = 'all';
    public $selectedApplicationId = null;

    public function mount()
    {
        if (!auth()->user()->isCompany()) {
            abort(403);
        }
    }

    public function viewApplication($applicationId)
    {
        $this->selectedApplicationId = $applicationId;
    }

    public function updateStatus($applicationId, $status)
    {
        $application = JobApplication::findOrFail($applicationId);

        // Verify this application belongs to company's job
        if ($application->jobListing->company_id !== auth()->user()->company->id) {
            abort(403);
        }

        $application->update([
            'status' => $status,
            'reviewed_at' => now(),
        ]);

        session()->flash('message', 'Application status updated successfully.');
    }

    public function closeApplication()
    {
        $this->selectedApplicationId = null;
    }

    public function render()
    {
        $company = auth()->user()->company;

        $query = JobApplication::with(['student', 'jobListing'])
            ->whereHas('jobListing', function($q) use ($company) {
                $q->where('company_id', $company->id);
            });

        if ($this->filterStatus !== 'all') {
            $query->where('status', $this->filterStatus);
        }

        $applications = $query->latest()->paginate(10);

        $selectedApplication = $this->selectedApplicationId
            ? JobApplication::with(['student', 'jobListing.questions'])->find($this->selectedApplicationId)
            : null;

        return view('livewire.company.application-review', [
            'applications' => $applications,
            'selectedApplication' => $selectedApplication,
        ]);
    }
}
