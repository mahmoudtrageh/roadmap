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

    // Rating properties
    public bool $showRatingModal = false;
    public int $rating = 0;
    public string $review = '';
    public $existingRating = null;

    public function mount($roadmapId): void
    {
        $this->roadmapId = $roadmapId;
        $this->roadmap = Roadmap::with(['tasks' => function($query) {
            $query->orderBy('day_number')->orderBy('order');
        }])->findOrFail($roadmapId);

        // Check if user is enrolled (excluding skipped enrollments)
        $this->enrollment = RoadmapEnrollment::where('student_id', Auth::id())
            ->where('roadmap_id', $roadmapId)
            ->first();

        // User is considered enrolled only if they have an active or completed enrollment
        // Skipped enrollments should be treated as "not enrolled"
        $this->isEnrolled = $this->enrollment !== null && $this->enrollment->status !== 'skipped';

        // Check if roadmap is locked
        $this->checkIfLocked();

        // Load existing rating if user has completed this roadmap
        if ($this->isEnrolled && $this->enrollment->status === 'completed') {
            $this->existingRating = \App\Models\RoadmapRating::where('student_id', Auth::id())
                ->where('roadmap_id', $roadmapId)
                ->first();

            if ($this->existingRating) {
                $this->rating = $this->existingRating->rating;
                $this->review = $this->existingRating->review ?? '';
            }
        }
    }

    private function checkIfLocked(): void
    {
        // Get user's completed or skipped roadmap IDs (skipped roadmaps satisfy prerequisites)
        $completedOrSkippedRoadmapIds = RoadmapEnrollment::where('student_id', Auth::id())
            ->whereIn('status', ['completed', 'skipped'])
            ->pluck('roadmap_id')
            ->toArray();

        // Check if has prerequisite that's not completed or skipped
        if ($this->roadmap->prerequisite_roadmap_id && !in_array($this->roadmap->prerequisite_roadmap_id, $completedOrSkippedRoadmapIds)) {
            $this->isLocked = true;
            $this->lockReason = 'Complete or skip previous roadmap first';
            return;
        }

        // Check if user already has active enrollment (not including current roadmap)
        $this->hasActiveEnrollment = RoadmapEnrollment::where('student_id', Auth::id())
            ->where('roadmap_id', '!=', $this->roadmap->id)
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

    public function skipRoadmap()
    {
        if ($this->isEnrolled) {
            session()->flash('error', 'You are already enrolled in this roadmap.');
            return;
        }

        // Skipping is always FREE - no subscription required
        // This allows students to skip roadmaps they don't need without paying

        // Create skipped enrollment
        RoadmapEnrollment::create([
            'student_id' => Auth::id(),
            'roadmap_id' => $this->roadmapId,
            'started_at' => now(),
            'status' => 'skipped',
        ]);

        session()->flash('message', 'Roadmap skipped successfully! You can now enroll in the next roadmap.');
        return redirect()->route('student.roadmaps');
    }

    public function enroll()
    {
        if ($this->isEnrolled) {
            session()->flash('error', 'You are already enrolled in this roadmap.');
            return;
        }

        // Check subscription requirement (first roadmap is free, 2nd+ requires subscription)
        // Count only non-skipped enrollments
        $totalEnrollmentsCount = RoadmapEnrollment::where('student_id', Auth::id())
            ->where('status', '!=', 'skipped')
            ->count();

        // If user already has at least one enrollment, they need an active subscription for additional roadmaps
        if ($totalEnrollmentsCount >= 1) {
            $activeSubscription = \App\Models\Subscription::where('student_id', Auth::id())
                ->where('status', 'active')
                ->where('expires_at', '>', now())
                ->first();

            if (!$activeSubscription) {
                session()->flash('error', 'You need an active subscription to enroll in additional roadmaps. The first roadmap is free!');
                return redirect()->route('student.subscription');
            }
        }

        // Check if roadmap has prerequisite
        if ($this->roadmap->prerequisite_roadmap_id) {
            $prerequisiteSatisfied = RoadmapEnrollment::where('student_id', Auth::id())
                ->where('roadmap_id', $this->roadmap->prerequisite_roadmap_id)
                ->whereIn('status', ['completed', 'skipped'])
                ->exists();

            if (!$prerequisiteSatisfied) {
                $prerequisiteRoadmap = Roadmap::find($this->roadmap->prerequisite_roadmap_id);
                session()->flash('error', 'You must complete or skip "' . $prerequisiteRoadmap->title . '" before enrolling in this roadmap.');
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

    public function openRatingModal()
    {
        $this->showRatingModal = true;
    }

    public function closeRatingModal()
    {
        $this->showRatingModal = false;
    }

    public function submitRating()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        if (!$this->isEnrolled || $this->enrollment->status !== 'completed') {
            session()->flash('error', 'You must complete this roadmap before rating it.');
            return;
        }

        \App\Models\RoadmapRating::updateOrCreate(
            [
                'student_id' => Auth::id(),
                'roadmap_id' => $this->roadmapId,
            ],
            [
                'rating' => $this->rating,
                'review' => $this->review,
            ]
        );

        session()->flash('message', 'Thank you for your rating!');
        $this->closeRatingModal();
        $this->mount($this->roadmapId); // Reload data
    }

    public function render()
    {
        // Load ratings for display
        $ratings = \App\Models\RoadmapRating::with('student')
            ->where('roadmap_id', $this->roadmapId)
            ->whereNotNull('review')
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.student.roadmap-view', [
            'tasksByDay' => $this->tasksByDay,
            'ratings' => $ratings,
        ]);
    }
}
