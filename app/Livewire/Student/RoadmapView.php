<?php

namespace App\Livewire\Student;

use App\Models\Roadmap;
use App\Models\RoadmapEnrollment;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class RoadmapView extends Component
{
    public $roadmapId;
    public $roadmap;
    public $isEnrolled = false;
    public $enrollment = null;
    public $isLocked = false;
    public $lockReason = '';
    public $hasActiveEnrollment = false;

    public function mount($roadmapId): void
    {
        $this->roadmapId = $roadmapId;
        $this->roadmap = Roadmap::with(['tasks' => function($query) {
            $query->orderBy('day_number')->orderBy('order');
        }])->findOrFail($roadmapId);

        // Check if user is enrolled
        $this->enrollment = RoadmapEnrollment::where('student_id', Auth::id())
            ->where('roadmap_id', $roadmapId)
            ->first();

        $this->isEnrolled = $this->enrollment !== null;

        // Check if roadmap is locked
        $this->checkIfLocked();
    }

    private function checkIfLocked(): void
    {
        // Get user's completed roadmap IDs
        $completedRoadmapIds = RoadmapEnrollment::where('student_id', Auth::id())
            ->where('status', 'completed')
            ->pluck('roadmap_id')
            ->toArray();

        // Check if has prerequisite that's not completed
        if ($this->roadmap->prerequisite_roadmap_id && !in_array($this->roadmap->prerequisite_roadmap_id, $completedRoadmapIds)) {
            $this->isLocked = true;
            $this->lockReason = 'Complete previous roadmap first';
            return;
        }

        // Check if user already has active enrollment
        $this->hasActiveEnrollment = RoadmapEnrollment::where('student_id', Auth::id())
            ->where('status', 'active')
            ->exists();

        if ($this->hasActiveEnrollment && !$this->isEnrolled) {
            $this->isLocked = true;
            $this->lockReason = 'Complete active roadmap first';
        }
    }

    public function getTasksByDayProperty()
    {
        return $this->roadmap->tasks->groupBy('day_number');
    }

    public function enroll()
    {
        if ($this->isEnrolled) {
            session()->flash('error', 'You are already enrolled in this roadmap.');
            return;
        }

        // Check if roadmap has prerequisite
        if ($this->roadmap->prerequisite_roadmap_id) {
            $prerequisiteCompleted = RoadmapEnrollment::where('student_id', Auth::id())
                ->where('roadmap_id', $this->roadmap->prerequisite_roadmap_id)
                ->where('status', 'completed')
                ->exists();

            if (!$prerequisiteCompleted) {
                $prerequisiteRoadmap = Roadmap::find($this->roadmap->prerequisite_roadmap_id);
                session()->flash('error', 'You must complete "' . $prerequisiteRoadmap->title . '" before enrolling in this roadmap.');
                return;
            }
        }

        // Check if user has any active enrollment
        $activeEnrollment = RoadmapEnrollment::where('student_id', Auth::id())
            ->where('status', 'active')
            ->exists();

        if ($activeEnrollment) {
            session()->flash('error', 'You already have an active roadmap. Please complete or pause it before enrolling in a new one.');
            return;
        }

        RoadmapEnrollment::create([
            'student_id' => Auth::id(),
            'roadmap_id' => $this->roadmapId,
            'started_at' => now(),
            'status' => 'active',
        ]);

        session()->flash('message', 'Successfully enrolled! Start your journey now.');
        return redirect()->route('student.tasks');
    }

    public function render()
    {
        return view('livewire.student.roadmap-view', [
            'tasksByDay' => $this->tasksByDay,
        ]);
    }
}
