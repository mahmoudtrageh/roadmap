<?php

namespace App\Livewire\Admin;

use App\Models\Roadmap;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class TaskBuilder extends Component
{
    use WithPagination;

    public $roadmapId;
    public $roadmap;

    #[Validate('required|string|max:255')]
    public $title = '';

    #[Validate('nullable|string')]
    public $description = '';

    #[Validate('required|integer|min:1')]
    public $day_number = 1;

    #[Validate('required|integer|min:1')]
    public $estimated_time_minutes = 60;

    #[Validate('required|in:reading,video,exercise,project,quiz')]
    public $task_type = 'reading';

    #[Validate('required|string|max:100')]
    public $category = 'General';

    #[Validate('required|integer|min:0')]
    public $order = 0;

    #[Validate('nullable|array')]
    public $resources_links = [];

    #[Validate('nullable|array')]
    public $resources = [];

    public $resourceLink = '';
    public $resourceTitle = '';
    public $resourceLanguage = 'en';
    public $resourceType = 'article';
    public $editingResourceIndex = null;
    public $showResourceModal = false;

    #[Validate('boolean')]
    public $has_code_submission = false;

    #[Validate('boolean')]
    public $has_quality_rating = false;

    public $taskId = null;
    public $isEditing = false;
    public $showForm = false;
    public $filterDay = 'all';
    public $filterType = 'all';
    public $filterCategory = 'all';

    public function mount($roadmapId): void
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $this->roadmapId = $roadmapId;
        $this->roadmap = Roadmap::with('tasks')->findOrFail($roadmapId);
    }

    public function getTasksProperty()
    {
        $query = Task::where('roadmap_id', $this->roadmapId);

        if ($this->filterDay !== 'all') {
            $query->where('day_number', $this->filterDay);
        }

        if ($this->filterType !== 'all') {
            $query->where('task_type', $this->filterType);
        }

        if ($this->filterCategory !== 'all') {
            $query->where('category', $this->filterCategory);
        }

        return $query->orderBy('day_number')->orderBy('order')->paginate(15);
    }

    public function getCategoriesProperty()
    {
        return Task::where('roadmap_id', $this->roadmapId)
            ->distinct()
            ->pluck('category')
            ->toArray();
    }

    public function createNew(): void
    {
        $this->reset(['title', 'description', 'day_number', 'estimated_time_minutes', 'task_type', 'category', 'order', 'resources_links', 'resources', 'resourceLink', 'resourceTitle', 'resourceLanguage', 'resourceType', 'has_code_submission', 'has_quality_rating', 'taskId', 'isEditing']);

        // Set default order to be after the last task
        $lastTask = Task::where('roadmap_id', $this->roadmapId)->orderBy('order', 'desc')->first();
        $this->order = $lastTask ? $lastTask->order + 1 : 0;

        $this->showForm = true;
    }

    public function edit($taskId): void
    {
        $task = Task::findOrFail($taskId);

        $this->taskId = $task->id;
        $this->title = $task->title;
        $this->description = $task->description;
        $this->day_number = $task->day_number;
        $this->estimated_time_minutes = $task->estimated_time_minutes;
        $this->task_type = $task->task_type;
        $this->category = $task->category;
        $this->order = $task->order;
        $this->resources_links = $task->resources_links ?? [];
        $this->resources = $task->resources ?? [];
        $this->has_code_submission = $task->has_code_submission;
        $this->has_quality_rating = $task->has_quality_rating;
        $this->isEditing = true;
        $this->showForm = true;
    }

    public function addResourceLink(): void
    {
        if (!empty($this->resourceLink)) {
            $this->resources_links[] = $this->resourceLink;
            $this->resourceLink = '';
        }
    }

    public function removeResourceLink($index): void
    {
        unset($this->resources_links[$index]);
        $this->resources_links = array_values($this->resources_links);
    }

    public function addResource(): void
    {
        if (!empty($this->resourceLink)) {
            $this->resources[] = [
                'url' => $this->resourceLink,
                'title' => $this->resourceTitle,
                'language' => $this->resourceLanguage,
                'type' => $this->resourceType,
            ];

            // Reset form fields
            $this->resourceLink = '';
            $this->resourceTitle = '';
            $this->resourceLanguage = 'en';
            $this->resourceType = 'article';
        }
    }

    public function removeResource($index): void
    {
        unset($this->resources[$index]);
        $this->resources = array_values($this->resources);
    }

    public function editResource($index): void
    {
        if (isset($this->resources[$index])) {
            $resource = $this->resources[$index];
            $this->resourceLink = $resource['url'] ?? '';
            $this->resourceTitle = $resource['title'] ?? '';
            $this->resourceLanguage = $resource['language'] ?? 'en';
            $this->resourceType = $resource['type'] ?? 'article';
            $this->editingResourceIndex = $index;
            $this->showResourceModal = true;
        }
    }

    public function updateResource(): void
    {
        if ($this->editingResourceIndex !== null && isset($this->resources[$this->editingResourceIndex])) {
            $this->resources[$this->editingResourceIndex] = [
                'url' => $this->resourceLink,
                'title' => $this->resourceTitle,
                'language' => $this->resourceLanguage,
                'type' => $this->resourceType,
            ];

            $this->closeResourceModal();
        }
    }

    public function openResourceModal(): void
    {
        $this->resourceLink = '';
        $this->resourceTitle = '';
        $this->resourceLanguage = 'en';
        $this->resourceType = 'article';
        $this->editingResourceIndex = null;
        $this->showResourceModal = true;
    }

    public function closeResourceModal(): void
    {
        $this->resourceLink = '';
        $this->resourceTitle = '';
        $this->resourceLanguage = 'en';
        $this->resourceType = 'article';
        $this->editingResourceIndex = null;
        $this->showResourceModal = false;
    }

    public function saveResourceFromModal(): void
    {
        if ($this->editingResourceIndex !== null) {
            $this->updateResource();
        } else {
            $this->addResource();
            $this->closeResourceModal();
        }
    }

    public function moveResourceUp($index): void
    {
        if ($index > 0 && isset($this->resources[$index])) {
            $temp = $this->resources[$index];
            $this->resources[$index] = $this->resources[$index - 1];
            $this->resources[$index - 1] = $temp;
        }
    }

    public function moveResourceDown($index): void
    {
        if ($index < count($this->resources) - 1 && isset($this->resources[$index])) {
            $temp = $this->resources[$index];
            $this->resources[$index] = $this->resources[$index + 1];
            $this->resources[$index + 1] = $temp;
        }
    }

    public function duplicateResource($index): void
    {
        if (isset($this->resources[$index])) {
            $resource = $this->resources[$index];
            $resource['title'] = ($resource['title'] ?? '') . ' (Copy)';
            $this->resources[] = $resource;
        }
    }

    public function bulkChangeLanguage($language): void
    {
        foreach ($this->resources as &$resource) {
            $resource['language'] = $language;
        }
        session()->flash('message', 'All resources updated to ' . ($language === 'ar' ? 'Arabic' : 'English'));
    }

    public function save(): void
    {
        $this->validate();

        try {
            $data = [
                'roadmap_id' => $this->roadmapId,
                'title' => $this->title,
                'description' => $this->description,
                'day_number' => $this->day_number,
                'estimated_time_minutes' => $this->estimated_time_minutes,
                'task_type' => $this->task_type,
                'category' => $this->category,
                'order' => $this->order,
                'resources_links' => $this->resources_links,
                'resources' => $this->resources,
                'has_code_submission' => $this->has_code_submission,
                'has_quality_rating' => $this->has_quality_rating,
            ];

            if ($this->isEditing) {
                $task = Task::findOrFail($this->taskId);
                $task->update($data);
                session()->flash('message', 'Task updated successfully.');
            } else {
                Task::create($data);
                session()->flash('message', 'Task created successfully.');
            }

            $this->reset(['title', 'description', 'day_number', 'estimated_time_minutes', 'task_type', 'category', 'order', 'resources_links', 'resources', 'resourceLink', 'resourceTitle', 'resourceLanguage', 'resourceType', 'has_code_submission', 'has_quality_rating', 'taskId', 'isEditing', 'showForm']);
            $this->roadmap = Roadmap::with('tasks')->findOrFail($this->roadmapId);
            $this->resetPage();
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function cancelEdit(): void
    {
        $this->reset(['title', 'description', 'day_number', 'estimated_time_minutes', 'task_type', 'category', 'order', 'resources_links', 'resources', 'resourceLink', 'resourceTitle', 'resourceLanguage', 'resourceType', 'has_code_submission', 'has_quality_rating', 'taskId', 'isEditing', 'showForm']);
    }

    public function delete($taskId): void
    {
        try {
            $task = Task::findOrFail($taskId);
            $task->delete();
            session()->flash('message', 'Task deleted successfully.');
            $this->roadmap = Roadmap::with('tasks')->findOrFail($this->roadmapId);
            $this->resetPage();
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function moveUp($taskId): void
    {
        $task = Task::findOrFail($taskId);
        $previousTask = Task::where('roadmap_id', $this->roadmapId)
            ->where('day_number', $task->day_number)
            ->where('order', '<', $task->order)
            ->orderBy('order', 'desc')
            ->first();

        if ($previousTask) {
            $tempOrder = $task->order;
            $task->order = $previousTask->order;
            $previousTask->order = $tempOrder;
            $task->save();
            $previousTask->save();
        }
    }

    public function moveDown($taskId): void
    {
        $task = Task::findOrFail($taskId);
        $nextTask = Task::where('roadmap_id', $this->roadmapId)
            ->where('day_number', $task->day_number)
            ->where('order', '>', $task->order)
            ->orderBy('order', 'asc')
            ->first();

        if ($nextTask) {
            $tempOrder = $task->order;
            $task->order = $nextTask->order;
            $nextTask->order = $tempOrder;
            $task->save();
            $nextTask->save();
        }
    }

    public function duplicate($taskId): void
    {
        try {
            $task = Task::findOrFail($taskId);
            $newTask = $task->replicate();
            $newTask->title = $task->title . ' (Copy)';
            $newTask->order = Task::where('roadmap_id', $this->roadmapId)->max('order') + 1;
            $newTask->save();
            session()->flash('message', 'Task duplicated successfully.');
            $this->roadmap = Roadmap::with('tasks')->findOrFail($this->roadmapId);
            $this->resetPage();
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function updatedFilterDay(): void
    {
        $this->resetPage();
    }

    public function updatedFilterType(): void
    {
        $this->resetPage();
    }

    public function updatedFilterCategory(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.task-builder', [
            'tasks' => $this->tasks,
            'categories' => $this->categories,
        ]);
    }
}
