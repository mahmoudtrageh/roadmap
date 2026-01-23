<?php

namespace App\Livewire\Admin;

use App\Models\Roadmap;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class ContentManagement extends Component
{
    use WithPagination;

    // Filters
    public $searchTerm = '';
    public $filterRoadmap = 'all';
    public $filterDay = 'all';
    public $filterType = 'all';
    public $filterDifficulty = 'all';
    public $filterQuality = 'all';
    public $sortBy = 'day_number';
    public $sortDirection = 'asc';

    // Bulk edit
    public $selectedTasks = [];
    public $selectAll = false;
    public $bulkAction = '';
    public $bulkValue = '';

    // Quick edit
    public $editingTaskId = null;
    public $editField = '';
    public $editValue = '';

    public function mount(): void
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function getTasksProperty()
    {
        $query = Task::with(['roadmap', 'checklists', 'quizzes', 'examples', 'hints']);

        // Search
        if (!empty($this->searchTerm)) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('category', 'like', '%' . $this->searchTerm . '%');
            });
        }

        // Filters
        if ($this->filterRoadmap !== 'all') {
            $query->where('roadmap_id', $this->filterRoadmap);
        }

        if ($this->filterDay !== 'all') {
            $query->where('day_number', $this->filterDay);
        }

        if ($this->filterType !== 'all') {
            $query->where('task_type', $this->filterType);
        }

        if ($this->filterDifficulty !== 'all') {
            $query->where('difficulty_level', $this->filterDifficulty);
        }

        // Quality filters
        if ($this->filterQuality === 'missing_description') {
            $query->whereNull('description')->orWhere('description', '');
        } elseif ($this->filterQuality === 'missing_resources') {
            $query->where(function($q) {
                $q->whereNull('resources_links')
                  ->orWhereJsonLength('resources_links', 0);
            });
        } elseif ($this->filterQuality === 'missing_objectives') {
            $query->where(function($q) {
                $q->whereNull('learning_objectives')
                  ->orWhereJsonLength('learning_objectives', 0);
            });
        } elseif ($this->filterQuality === 'missing_checklists') {
            $query->whereDoesntHave('checklists');
        } elseif ($this->filterQuality === 'missing_quizzes') {
            $query->whereDoesntHave('quizzes');
        } elseif ($this->filterQuality === 'missing_examples') {
            $query->whereDoesntHave('examples');
        } elseif ($this->filterQuality === 'long_tasks') {
            $query->where('estimated_time_minutes', '>', 120);
        }

        // Sorting
        $query->orderBy($this->sortBy, $this->sortDirection);

        return $query->paginate(20);
    }

    public function getRoadmapsProperty()
    {
        return Roadmap::all();
    }

    public function getContentHealthProperty()
    {
        $totalTasks = Task::count();

        return [
            'total_tasks' => $totalTasks,
            'missing_description' => Task::whereNull('description')->orWhere('description', '')->count(),
            'missing_resources' => Task::where(function($q) {
                $q->whereNull('resources_links')->orWhereJsonLength('resources_links', 0);
            })->count(),
            'missing_objectives' => Task::where(function($q) {
                $q->whereNull('learning_objectives')->orWhereJsonLength('learning_objectives', 0);
            })->count(),
            'missing_checklists' => Task::whereDoesntHave('checklists')->count(),
            'missing_quizzes' => Task::whereDoesntHave('quizzes')->count(),
            'missing_examples' => Task::whereIn('task_type', ['coding', 'exercise', 'project'])
                ->whereDoesntHave('examples')->count(),
            'long_tasks' => Task::where('estimated_time_minutes', '>', 120)->count(),
            'perfect_tasks' => $totalTasks - Task::where(function($q) {
                $q->whereNull('description')
                  ->orWhere('description', '')
                  ->orWhereNull('resources_links')
                  ->orWhereJsonLength('resources_links', 0)
                  ->orWhereNull('learning_objectives')
                  ->orWhereJsonLength('learning_objectives', 0);
            })->count(),
        ];
    }

    public function sort($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function toggleSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedTasks = $this->tasks->pluck('id')->toArray();
        } else {
            $this->selectedTasks = [];
        }
    }

    public function applyBulkAction()
    {
        if (empty($this->selectedTasks) || empty($this->bulkAction)) {
            session()->flash('error', 'Please select tasks and an action.');
            return;
        }

        try {
            $tasks = Task::whereIn('id', $this->selectedTasks);

            switch ($this->bulkAction) {
                case 'update_difficulty':
                    if (!empty($this->bulkValue)) {
                        $tasks->update(['difficulty_level' => $this->bulkValue]);
                        session()->flash('message', count($this->selectedTasks) . ' tasks updated.');
                    }
                    break;

                case 'update_category':
                    if (!empty($this->bulkValue)) {
                        $tasks->update(['category' => $this->bulkValue]);
                        session()->flash('message', count($this->selectedTasks) . ' tasks updated.');
                    }
                    break;

                case 'update_type':
                    if (!empty($this->bulkValue)) {
                        $tasks->update(['task_type' => $this->bulkValue]);
                        session()->flash('message', count($this->selectedTasks) . ' tasks updated.');
                    }
                    break;

                case 'generate_checklists':
                    foreach ($this->selectedTasks as $taskId) {
                        \Artisan::call('tasks:generate-checklists', ['--task' => $taskId]);
                    }
                    session()->flash('message', 'Checklists generated for ' . count($this->selectedTasks) . ' tasks.');
                    break;

                case 'generate_quizzes':
                    foreach ($this->selectedTasks as $taskId) {
                        \Artisan::call('tasks:generate-quizzes', ['--task' => $taskId]);
                    }
                    session()->flash('message', 'Quizzes generated for ' . count($this->selectedTasks) . ' tasks.');
                    break;

                case 'generate_examples':
                    foreach ($this->selectedTasks as $taskId) {
                        \Artisan::call('tasks:generate-examples', ['--task' => $taskId, '--force' => true]);
                    }
                    session()->flash('message', 'Examples generated for ' . count($this->selectedTasks) . ' tasks.');
                    break;

                case 'delete':
                    $tasks->delete();
                    session()->flash('message', count($this->selectedTasks) . ' tasks deleted.');
                    break;

                default:
                    session()->flash('error', 'Invalid bulk action.');
            }

            $this->selectedTasks = [];
            $this->selectAll = false;
            $this->bulkAction = '';
            $this->bulkValue = '';
            $this->resetPage();
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function startQuickEdit($taskId, $field, $currentValue)
    {
        $this->editingTaskId = $taskId;
        $this->editField = $field;
        $this->editValue = $currentValue ?? '';
    }

    public function saveQuickEdit()
    {
        if ($this->editingTaskId && $this->editField) {
            try {
                $task = Task::findOrFail($this->editingTaskId);
                $task->update([$this->editField => $this->editValue]);
                session()->flash('message', 'Task updated successfully.');
                $this->cancelQuickEdit();
            } catch (\Exception $e) {
                session()->flash('error', 'Error: ' . $e->getMessage());
            }
        }
    }

    public function cancelQuickEdit()
    {
        $this->editingTaskId = null;
        $this->editField = '';
        $this->editValue = '';
    }

    public function exportCSV()
    {
        $tasks = Task::with('roadmap')->get();

        $filename = 'tasks_export_' . now()->format('Y-m-d_His') . '.csv';
        $filepath = storage_path('app/' . $filename);

        $file = fopen($filepath, 'w');

        // Headers
        fputcsv($file, [
            'ID',
            'Roadmap',
            'Title',
            'Day',
            'Order',
            'Type',
            'Category',
            'Difficulty',
            'Est. Time (min)',
            'Has Description',
            'Resource Count',
            'Has Objectives',
            'Has Skills',
            'Has Checklist',
            'Has Quiz',
            'Has Examples',
            'Has Hints',
        ]);

        // Data
        foreach ($tasks as $task) {
            fputcsv($file, [
                $task->id,
                $task->roadmap->title ?? 'N/A',
                $task->title,
                $task->day_number,
                $task->order,
                $task->task_type,
                $task->category,
                $task->difficulty_level,
                $task->estimated_time_minutes,
                !empty($task->description) ? 'Yes' : 'No',
                count($task->resources_links ?? []),
                !empty($task->learning_objectives) ? 'Yes' : 'No',
                !empty($task->skills_gained) ? 'Yes' : 'No',
                $task->checklists()->exists() ? 'Yes' : 'No',
                $task->quizzes()->exists() ? 'Yes' : 'No',
                $task->examples()->exists() ? 'Yes' : 'No',
                $task->hints()->exists() ? 'Yes' : 'No',
            ]);
        }

        fclose($file);

        return response()->download($filepath)->deleteFileAfterSend(true);
    }

    public function updatedSearchTerm()
    {
        $this->resetPage();
    }

    public function updatedFilterRoadmap()
    {
        $this->resetPage();
    }

    public function updatedFilterDay()
    {
        $this->resetPage();
    }

    public function updatedFilterType()
    {
        $this->resetPage();
    }

    public function updatedFilterDifficulty()
    {
        $this->resetPage();
    }

    public function updatedFilterQuality()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.content-management', [
            'tasks' => $this->tasks,
            'roadmaps' => $this->roadmaps,
            'contentHealth' => $this->contentHealth,
        ]);
    }
}
