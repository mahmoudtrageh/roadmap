<?php

namespace App\Livewire\Student;

use App\Models\User;
use App\Models\TaskCompletion;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class AchievementBoard extends Component
{
    public $leaderboard = [];
    public $myStats = [];
    public $myRank = 0;

    public function mount()
    {
        $this->loadLeaderboard();
    }

    public function loadLeaderboard()
    {
        // Get all students with their points
        $students = User::where('role', 'student')
            ->withCount([
                'taskCompletions as completed_tasks' => function ($query) {
                    $query->where('status', 'completed');
                },
            ])
            ->with([
                'enrollments' => function ($query) {
                    $query->where('status', 'completed');
                }
            ])
            ->get()
            ->map(function ($student) {
                // Calculate points
                $completedTasks = $student->completed_tasks;
                $completedRoadmaps = $student->enrollments->count();

                // Points calculation:
                // - 10 points per completed task
                // - 100 points per completed roadmap
                $points = ($completedTasks * 10) + ($completedRoadmaps * 100);

                return [
                    'id' => $student->id,
                    'name' => $student->name,
                    'email' => $student->email,
                    'completed_tasks' => $completedTasks,
                    'completed_roadmaps' => $completedRoadmaps,
                    'points' => $points,
                    'is_me' => $student->id === Auth::id(),
                ];
            })
            ->sortByDesc('points')
            ->values();

        // Add rank
        $rank = 1;
        $this->leaderboard = $students->map(function ($student) use (&$rank) {
            $student['rank'] = $rank;

            if ($student['is_me']) {
                $this->myRank = $rank;
                $this->myStats = $student;
            }

            $rank++;
            return $student;
        })->toArray();
    }

    public function render()
    {
        return view('livewire.student.achievement-board');
    }
}
