<?php

namespace App\Livewire\Admin;

use App\Models\Roadmap;
use App\Services\RoadmapService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class RoadmapBuilder extends Component
{
    use WithFileUploads, WithPagination;

    #[Validate('required|string|max:255')]
    public $title = '';

    #[Validate('nullable|string')]
    public $description = '';

    #[Validate('required|integer|min:1')]
    public $duration_days = 30;

    #[Validate('required|in:beginner,intermediate,advanced')]
    public $difficulty_level = 'beginner';

    #[Validate('boolean')]
    public $is_featured = false;

    #[Validate('nullable|image|max:2048')]
    public $image;

    public $roadmapId = null;
    public $isEditing = false;
    public $showForm = false;
    public $searchTerm = '';
    public $filterStatus = 'all';
    public $filterDifficulty = 'all';

    protected RoadmapService $roadmapService;

    public function boot(RoadmapService $roadmapService): void
    {
        $this->roadmapService = $roadmapService;
    }

    public function mount(): void
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function getRoadmapsProperty()
    {
        $query = Roadmap::with(['creator', 'tasks'])
            ->withCount('enrollments');

        if ($this->searchTerm) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $this->searchTerm . '%');
            });
        }

        if ($this->filterStatus !== 'all') {
            $query->where('is_published', $this->filterStatus === 'published');
        }

        if ($this->filterDifficulty !== 'all') {
            $query->where('difficulty_level', $this->filterDifficulty);
        }

        return $query->latest()->paginate(10);
    }

    public function createNew(): void
    {
        $this->reset(['title', 'description', 'duration_days', 'difficulty_level', 'is_featured', 'image', 'roadmapId', 'isEditing']);
        $this->showForm = true;
    }

    public function edit($roadmapId): void
    {
        $roadmap = Roadmap::findOrFail($roadmapId);

        $this->roadmapId = $roadmap->id;
        $this->title = $roadmap->title;
        $this->description = $roadmap->description;
        $this->duration_days = $roadmap->duration_days;
        $this->difficulty_level = $roadmap->difficulty_level;
        $this->is_featured = $roadmap->is_featured;
        $this->isEditing = true;
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate();

        try {
            $data = [
                'title' => $this->title,
                'description' => $this->description,
                'duration_days' => $this->duration_days,
                'difficulty_level' => $this->difficulty_level,
                'is_featured' => $this->is_featured,
            ];

            if ($this->image) {
                $imagePath = $this->image->store('roadmaps', 'public');
                $data['image_path'] = $imagePath;
            }

            if ($this->isEditing) {
                $roadmap = Roadmap::findOrFail($this->roadmapId);

                // Delete old image if new one is uploaded
                if ($this->image && $roadmap->image_path) {
                    Storage::disk('public')->delete($roadmap->image_path);
                }

                $this->roadmapService->updateRoadmap($roadmap, $data);
                session()->flash('message', 'Roadmap updated successfully.');
            } else {
                $data['creator_id'] = Auth::id();
                $this->roadmapService->createRoadmap($data);
                session()->flash('message', 'Roadmap created successfully.');
            }

            $this->reset(['title', 'description', 'duration_days', 'difficulty_level', 'is_featured', 'image', 'roadmapId', 'isEditing', 'showForm']);
            $this->resetPage();
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function cancelEdit(): void
    {
        $this->reset(['title', 'description', 'duration_days', 'difficulty_level', 'is_featured', 'image', 'roadmapId', 'isEditing', 'showForm']);
    }

    public function togglePublish($roadmapId): void
    {
        try {
            $roadmap = Roadmap::findOrFail($roadmapId);

            if ($roadmap->is_published) {
                $this->roadmapService->unpublishRoadmap($roadmap);
                session()->flash('message', 'Roadmap unpublished successfully.');
            } else {
                $this->roadmapService->publishRoadmap($roadmap);
                session()->flash('message', 'Roadmap published successfully.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function delete($roadmapId): void
    {
        try {
            $roadmap = Roadmap::findOrFail($roadmapId);

            // Delete image if exists
            if ($roadmap->image_path) {
                Storage::disk('public')->delete($roadmap->image_path);
            }

            $this->roadmapService->deleteRoadmap($roadmap);
            session()->flash('message', 'Roadmap deleted successfully.');
            $this->resetPage();
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function duplicate($roadmapId): void
    {
        try {
            $roadmap = Roadmap::findOrFail($roadmapId);
            $this->roadmapService->duplicateRoadmap($roadmap, Auth::user());
            session()->flash('message', 'Roadmap duplicated successfully.');
            $this->resetPage();
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function updatedSearchTerm(): void
    {
        $this->resetPage();
    }

    public function updatedFilterStatus(): void
    {
        $this->resetPage();
    }

    public function updatedFilterDifficulty(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.roadmap-builder', [
            'roadmaps' => $this->roadmaps,
        ]);
    }
}
