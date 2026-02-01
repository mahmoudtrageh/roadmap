<?php

namespace App\Livewire\Student;

use App\Models\Roadmap;
use App\Models\RoadmapEnrollment;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class RoadmapsList extends Component
{
    public $searchTerm = '';
    public $filterDifficulty = 'all';

    // Skip functionality removed

    public function enroll($roadmapId)
    {
        $user = Auth::user();

        // Check if roadmap requires enrollment
        $roadmap = Roadmap::find($roadmapId);
        if ($roadmap && !$roadmap->requires_enrollment) {
            // Roadmaps that don't require enrollment should be accessed directly
            return redirect()->route('student.tasks', ['roadmapId' => $roadmapId]);
        }

        // Check if already enrolled
        $existingEnrollment = RoadmapEnrollment::where('student_id', $user->id)
            ->where('roadmap_id', $roadmapId)
            ->first();

        // If already enrolled and NOT skipped, show error
        if ($existingEnrollment && $existingEnrollment->status !== 'skipped') {
            session()->flash('error', 'You are already enrolled in this roadmap.');
            return;
        }

        // Check subscription requirement (first 2 roadmaps are free: Translation + 1 technical, rest require subscription)
        // UNLESS user has lifetime access
        if (!$user->has_lifetime_access) {
            // Count only non-skipped enrollments
            $totalEnrollmentsCount = RoadmapEnrollment::where('student_id', $user->id)
                ->where('status', '!=', 'skipped')
                ->count();

            // If user already has 2 or more enrollments, they need an active subscription for additional roadmaps
            if ($totalEnrollmentsCount >= 2) {
                $activeSubscription = \App\Models\Subscription::where('student_id', $user->id)
                    ->where('status', 'active')
                    ->where('expires_at', '>', now())
                    ->first();

                if (!$activeSubscription) {
                    session()->flash('error', 'You need an active subscription to enroll in additional roadmaps. The first 2 roadmaps are free (Translation + one technical roadmap)!');
                    return redirect()->route('student.subscription');
                }
            }
        }

        // Check if user has any active (incomplete) enrollments
        $hasActiveEnrollment = RoadmapEnrollment::where('student_id', $user->id)
            ->where('status', 'active')
            ->exists();

        if ($hasActiveEnrollment) {
            session()->flash('error', 'Please complete your current roadmap before enrolling in a new one.');
            return;
        }

        // If there's a skipped enrollment, update it instead of creating new
        if ($existingEnrollment && $existingEnrollment->status === 'skipped') {
            $existingEnrollment->status = 'active';
            $existingEnrollment->started_at = now();
            $existingEnrollment->save();
        } else {
            // Create new enrollment
            RoadmapEnrollment::create([
                'student_id' => $user->id,
                'roadmap_id' => $roadmapId,
                'started_at' => now(),
                'status' => 'active',
            ]);
        }

        session()->flash('message', 'Successfully enrolled in the roadmap!');
        return redirect()->route('student.tasks', ['roadmapId' => $roadmapId]);
    }

    public function render()
    {
        $query = Roadmap::where('is_published', true)
            ->withCount('tasks');

        if (!empty($this->searchTerm)) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $this->searchTerm . '%');
            });
        }

        if ($this->filterDifficulty !== 'all') {
            $query->where('difficulty_level', $this->filterDifficulty);
        }

        // Order by order column to show proper learning progression
        $roadmaps = $query->orderBy('order')->orderBy('created_at')->get();

        // Get user's enrolled roadmap IDs (active or completed, NOT skipped)
        $enrolledRoadmapIds = RoadmapEnrollment::where('student_id', Auth::id())
            ->whereIn('status', ['active', 'completed'])
            ->pluck('roadmap_id')
            ->toArray();

        // Get user's skipped roadmap IDs
        $skippedRoadmapIds = RoadmapEnrollment::where('student_id', Auth::id())
            ->where('status', 'skipped')
            ->pluck('roadmap_id')
            ->toArray();

        // Get user's completed roadmap IDs
        $completedRoadmapIds = RoadmapEnrollment::where('student_id', Auth::id())
            ->where('status', 'completed')
            ->pluck('roadmap_id')
            ->toArray();

        // Get user's completed OR skipped roadmap IDs (for prerequisite checking)
        $completedOrSkippedRoadmapIds = RoadmapEnrollment::where('student_id', Auth::id())
            ->whereIn('status', ['completed', 'skipped'])
            ->pluck('roadmap_id')
            ->toArray();

        // Check if user has active enrollment
        $hasActiveEnrollment = RoadmapEnrollment::where('student_id', Auth::id())
            ->where('status', 'active')
            ->exists();

        return view('livewire.student.roadmaps-list', [
            'roadmaps' => $roadmaps,
            'enrolledRoadmapIds' => $enrolledRoadmapIds,
            'skippedRoadmapIds' => $skippedRoadmapIds,
            'completedRoadmapIds' => $completedRoadmapIds,
            'completedOrSkippedRoadmapIds' => $completedOrSkippedRoadmapIds,
            'hasActiveEnrollment' => $hasActiveEnrollment,
        ]);
    }
}
