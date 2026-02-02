<?php

namespace App\Livewire\Student;

use App\Models\StudentResource;
use App\Models\Task;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class StudentResourceBox extends Component
{
    public $taskId;
    public $studentResources;
    public $showAddForm = false;

    // Form fields
    public $url = '';
    public $title = '';
    public $description = '';
    public $type = 'article';

    protected $rules = [
        'url' => 'required|url|max:500',
        'title' => 'required|string|max:200',
        'description' => 'nullable|string|max:500',
        'type' => 'required|in:article,video,tutorial,documentation,course,blog,interactive',
    ];

    public function mount($taskId)
    {
        $this->taskId = $taskId;
        $this->loadResources();
    }

    public function loadResources()
    {
        $this->studentResources = StudentResource::where('task_id', $this->taskId)
            ->where('is_approved', true)
            ->with('student')
            ->orderByDesc('helpful_count')
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($resource) {
                $resource->is_voted_by_me = $resource->isVotedHelpfulBy(Auth::id());
                return $resource;
            });
    }

    public function toggleAddForm()
    {
        $this->showAddForm = !$this->showAddForm;

        if (!$this->showAddForm) {
            $this->resetForm();
        }
    }

    public function submitResource()
    {
        $this->validate();

        StudentResource::create([
            'task_id' => $this->taskId,
            'student_id' => Auth::id(),
            'url' => $this->url,
            'title' => $this->title,
            'description' => $this->description,
            'type' => $this->type,
            'is_approved' => true,
        ]);

        $this->resetForm();
        $this->showAddForm = false;
        $this->loadResources();

        session()->flash('resource_success', 'Thank you! Your resource has been added.');
    }

    public function resetForm()
    {
        $this->url = '';
        $this->title = '';
        $this->description = '';
        $this->type = 'article';
        $this->resetErrorBag();
    }

    public function toggleHelpful($resourceId)
    {
        $resource = StudentResource::find($resourceId);

        if ($resource) {
            $resource->toggleHelpful(Auth::id());
            $this->loadResources();
        }
    }

    public function render()
    {
        return view('livewire.student.student-resource-box');
    }
}
