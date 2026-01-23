<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class UserManagement extends Component
{
    use WithPagination;

    #[Validate('required|string|max:255')]
    public $name = '';

    #[Validate('required|email|unique:users,email')]
    public $email = '';

    #[Validate('required|string|min:8')]
    public $password = '';

    #[Validate('required|in:admin,instructor,student')]
    public $role = 'student';

    public $userId = null;
    public $isEditing = false;
    public $showForm = false;
    public $searchTerm = '';
    public $filterRole = 'all';
    public $selectedUserId = null;
    public $showStats = false;

    public function mount(): void
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function getUsersProperty()
    {
        $query = User::withCount([
            'enrollments',
            'taskCompletions',
            'codeSubmissions',
            'codeReviews'
        ]);

        if ($this->searchTerm) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $this->searchTerm . '%');
            });
        }

        if ($this->filterRole !== 'all') {
            $query->where('role', $this->filterRole);
        }

        return $query->latest()->paginate(15);
    }

    public function createNew(): void
    {
        $this->reset(['name', 'email', 'password', 'role', 'userId', 'isEditing']);
        $this->showForm = true;
    }

    public function edit($userId): void
    {
        $user = User::findOrFail($userId);

        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->password = '';
        $this->isEditing = true;
        $this->showForm = true;
    }

    public function save(): void
    {
        if ($this->isEditing) {
            $this->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $this->userId,
                'password' => 'nullable|string|min:8',
                'role' => 'required|in:admin,instructor,student',
            ]);
        } else {
            $this->validate();
        }

        try {
            $data = [
                'name' => $this->name,
                'email' => $this->email,
                'role' => $this->role,
            ];

            if (!empty($this->password)) {
                $data['password'] = Hash::make($this->password);
            }

            if ($this->isEditing) {
                $user = User::findOrFail($this->userId);
                $user->update($data);
                session()->flash('message', 'User updated successfully.');
            } else {
                $data['password'] = Hash::make($this->password);
                User::create($data);
                session()->flash('message', 'User created successfully.');
            }

            $this->reset(['name', 'email', 'password', 'role', 'userId', 'isEditing', 'showForm']);
            $this->resetPage();
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function cancelEdit(): void
    {
        $this->reset(['name', 'email', 'password', 'role', 'userId', 'isEditing', 'showForm']);
    }

    public function changeRole($userId, $newRole): void
    {
        try {
            $user = User::findOrFail($userId);

            // Prevent changing own role
            if ($user->id === Auth::id()) {
                session()->flash('error', 'You cannot change your own role.');
                return;
            }

            $user->role = $newRole;
            $user->save();

            session()->flash('message', 'User role updated successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function delete($userId): void
    {
        try {
            $user = User::findOrFail($userId);

            // Prevent deleting own account
            if ($user->id === Auth::id()) {
                session()->flash('error', 'You cannot delete your own account.');
                return;
            }

            $user->delete();
            session()->flash('message', 'User deleted successfully.');
            $this->resetPage();
        } catch (\Exception $e) {
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    public function viewStats($userId): void
    {
        $this->selectedUserId = $userId;
        $this->showStats = true;
    }

    public function closeStats(): void
    {
        $this->selectedUserId = null;
        $this->showStats = false;
    }

    public function getSelectedUserProperty()
    {
        if (!$this->selectedUserId) {
            return null;
        }

        return User::with([
            'enrollments.roadmap',
            'taskCompletions' => function ($query) {
                $query->where('status', 'completed');
            },
            'achievements.achievement'
        ])
            ->withCount([
                'enrollments',
                'taskCompletions',
                'codeSubmissions',
                'achievements'
            ])
            ->findOrFail($this->selectedUserId);
    }

    public function getUserStatsProperty()
    {
        if (!$this->selectedUserId) {
            return null;
        }

        $user = User::withTrashed()->findOrFail($this->selectedUserId);

        $completedTasks = $user->taskCompletions()
            ->where('status', 'completed')
            ->count();

        $totalTimeSpent = $user->taskCompletions()
            ->sum('time_spent_minutes');

        $completedEnrollments = $user->enrollments()
            ->where('status', 'completed')
            ->count();

        $inProgressEnrollments = $user->enrollments()
            ->where('status', 'in_progress')
            ->count();

        $codeSubmissions = $user->codeSubmissions()->count();

        $reviewedSubmissions = $user->codeSubmissions()
            ->whereHas('codeReviews')
            ->count();

        return [
            'completed_tasks' => $completedTasks,
            'total_time_spent' => $totalTimeSpent,
            'completed_enrollments' => $completedEnrollments,
            'in_progress_enrollments' => $inProgressEnrollments,
            'code_submissions' => $codeSubmissions,
            'reviewed_submissions' => $reviewedSubmissions,
            'current_streak' => $user->current_streak ?? 0,
            'longest_streak' => $user->longest_streak ?? 0,
        ];
    }

    public function updatedSearchTerm(): void
    {
        $this->resetPage();
    }

    public function updatedFilterRole(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.user-management', [
            'users' => $this->users,
            'selectedUser' => $this->selectedUser,
            'userStats' => $this->userStats,
        ]);
    }
}
