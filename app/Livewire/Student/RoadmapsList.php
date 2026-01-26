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

    public function skipRoadmap($roadmapId)
    {
        $user = Auth::user();

        // Check if already enrolled
        $existingEnrollment = RoadmapEnrollment::where('student_id', $user->id)
            ->where('roadmap_id', $roadmapId)
            ->first();

        if ($existingEnrollment) {
            session()->flash('error', 'You are already enrolled in this roadmap.');
            return;
        }

        // Skipping is always FREE - no subscription required
        // This allows students to skip roadmaps they don't need without paying

        // Create skipped enrollment
        RoadmapEnrollment::create([
            'student_id' => $user->id,
            'roadmap_id' => $roadmapId,
            'started_at' => now(),
            'status' => 'skipped',
        ]);

        session()->flash('message', 'Roadmap skipped successfully!');
    }

    public function enroll($roadmapId)
    {
        $user = Auth::user();

        // Check if already enrolled
        $existingEnrollment = RoadmapEnrollment::where('student_id', $user->id)
            ->where('roadmap_id', $roadmapId)
            ->first();

        if ($existingEnrollment) {
            session()->flash('error', 'You are already enrolled in this roadmap.');
            return;
        }

        // Check subscription requirement (first roadmap is free, 2nd+ requires subscription)
        // Count only non-skipped enrollments
        $totalEnrollmentsCount = RoadmapEnrollment::where('student_id', $user->id)
            ->where('status', '!=', 'skipped')
            ->count();

        // If user already has at least one enrollment, they need an active subscription for additional roadmaps
        if ($totalEnrollmentsCount >= 1) {
            $activeSubscription = \App\Models\Subscription::where('student_id', $user->id)
                ->where('status', 'active')
                ->where('expires_at', '>', now())
                ->first();

            if (!$activeSubscription) {
                session()->flash('error', 'You need an active subscription to enroll in additional roadmaps. The first roadmap is free!');
                return redirect()->route('student.subscription');
            }
        }

        // Get the roadmap with prerequisite
        $roadmap = Roadmap::findOrFail($roadmapId);

        // Check if roadmap has prerequisite
        if ($roadmap->prerequisite_roadmap_id) {
            // Check if user completed or skipped the prerequisite roadmap
            $prerequisiteSatisfied = RoadmapEnrollment::where('student_id', $user->id)
                ->where('roadmap_id', $roadmap->prerequisite_roadmap_id)
                ->whereIn('status', ['completed', 'skipped'])
                ->exists();

            if (!$prerequisiteSatisfied) {
                $prerequisiteRoadmap = Roadmap::find($roadmap->prerequisite_roadmap_id);
                session()->flash('error', 'You must complete or skip "' . $prerequisiteRoadmap->title . '" before enrolling in this roadmap.');
                return;
            }
        }

        // Check if user has any active enrollment
        $activeEnrollment = RoadmapEnrollment::where('student_id', $user->id)
            ->where('status', 'active')
            ->exists();

        if ($activeEnrollment) {
            session()->flash('error', 'You already have an active roadmap. Please complete or pause it before enrolling in a new one.');
            return;
        }

        // Create enrollment
        RoadmapEnrollment::create([
            'student_id' => $user->id,
            'roadmap_id' => $roadmapId,
            'started_at' => now(),
            'status' => 'active',
        ]);

        session()->flash('message', 'Successfully enrolled in the roadmap!');
        return redirect()->route('student.dashboard');
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

        // Get user's enrolled roadmap IDs
        $enrolledRoadmapIds = RoadmapEnrollment::where('student_id', Auth::id())
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
            'completedRoadmapIds' => $completedRoadmapIds,
            'completedOrSkippedRoadmapIds' => $completedOrSkippedRoadmapIds,
            'hasActiveEnrollment' => $hasActiveEnrollment,
        ]);
    }
}
