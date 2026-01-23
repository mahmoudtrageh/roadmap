<?php

namespace App\Services;

use App\Models\Roadmap;
use App\Models\RoadmapEnrollment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoadmapService
{
    /**
     * Create a new roadmap.
     */
    public function createRoadmap(array $data): Roadmap
    {
        // Ensure slug is generated if not provided
        if (!isset($data['slug']) && isset($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Set default values
        $data['is_published'] = $data['is_published'] ?? false;
        $data['is_featured'] = $data['is_featured'] ?? false;

        return Roadmap::create($data);
    }

    /**
     * Publish a roadmap (make it visible to students).
     */
    public function publishRoadmap(Roadmap $roadmap): bool
    {
        if ($roadmap->is_published) {
            return false; // Already published
        }

        // Validate that roadmap has tasks before publishing
        if ($roadmap->tasks()->count() === 0) {
            throw new \RuntimeException('Cannot publish a roadmap without tasks.');
        }

        $roadmap->is_published = true;
        return $roadmap->save();
    }

    /**
     * Unpublish a roadmap (hide it from students).
     */
    public function unpublishRoadmap(Roadmap $roadmap): bool
    {
        if (!$roadmap->is_published) {
            return false; // Already unpublished
        }

        $roadmap->is_published = false;
        return $roadmap->save();
    }

    /**
     * Enroll a student in a roadmap.
     */
    public function enrollStudent(User $student, Roadmap $roadmap): RoadmapEnrollment
    {
        // Check if roadmap is published
        if (!$roadmap->is_published) {
            throw new \RuntimeException('Cannot enroll in an unpublished roadmap.');
        }

        // Check if student is already enrolled
        $existingEnrollment = RoadmapEnrollment::where('roadmap_id', $roadmap->id)
            ->where('student_id', $student->id)
            ->first();

        if ($existingEnrollment) {
            throw new \RuntimeException('Student is already enrolled in this roadmap.');
        }

        return RoadmapEnrollment::create([
            'roadmap_id' => $roadmap->id,
            'student_id' => $student->id,
            'started_at' => now(),
            'current_day' => 1,
            'status' => 'in_progress',
        ]);
    }

    /**
     * Unenroll a student from a roadmap.
     */
    public function unenrollStudent(RoadmapEnrollment $enrollment): bool
    {
        // Optionally, you might want to soft delete or mark as cancelled
        // For now, we'll just delete the enrollment
        return $enrollment->delete();
    }

    /**
     * Update roadmap details.
     */
    public function updateRoadmap(Roadmap $roadmap, array $data): bool
    {
        // Update slug if title is changed
        if (isset($data['title']) && $data['title'] !== $roadmap->title) {
            $data['slug'] = Str::slug($data['title']);
        }

        return $roadmap->update($data);
    }

    /**
     * Duplicate a roadmap.
     */
    public function duplicateRoadmap(Roadmap $roadmap, User $creator): Roadmap
    {
        $newRoadmap = $roadmap->replicate();
        $newRoadmap->creator_id = $creator->id;
        $newRoadmap->title = $roadmap->title . ' (Copy)';
        $newRoadmap->slug = Str::slug($newRoadmap->title);
        $newRoadmap->is_published = false;
        $newRoadmap->is_featured = false;
        $newRoadmap->save();

        // Duplicate tasks
        foreach ($roadmap->tasks as $task) {
            $newTask = $task->replicate();
            $newTask->roadmap_id = $newRoadmap->id;
            $newTask->save();
        }

        return $newRoadmap;
    }

    /**
     * Get roadmap statistics.
     */
    public function getRoadmapStats(Roadmap $roadmap): array
    {
        $enrollments = $roadmap->enrollments;
        $totalEnrollments = $enrollments->count();
        $completedEnrollments = $enrollments->where('status', 'completed')->count();
        $inProgressEnrollments = $enrollments->where('status', 'in_progress')->count();

        $averageRating = $roadmap->enrollments()
            ->whereNotNull('overall_rating')
            ->avg('overall_rating');

        return [
            'total_enrollments' => $totalEnrollments,
            'completed_enrollments' => $completedEnrollments,
            'in_progress_enrollments' => $inProgressEnrollments,
            'completion_rate' => $totalEnrollments > 0
                ? round(($completedEnrollments / $totalEnrollments) * 100, 2)
                : 0,
            'average_rating' => $averageRating ? round($averageRating, 2) : null,
            'total_tasks' => $roadmap->tasks()->count(),
            'duration_days' => $roadmap->duration_days,
        ];
    }

    /**
     * Get all published roadmaps.
     */
    public function getPublishedRoadmaps()
    {
        return Roadmap::where('is_published', true)
            ->with('creator')
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get featured roadmaps.
     */
    public function getFeaturedRoadmaps(int $limit = 6)
    {
        return Roadmap::where('is_published', true)
            ->where('is_featured', true)
            ->with('creator')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Search roadmaps by keyword.
     */
    public function searchRoadmaps(string $keyword)
    {
        return Roadmap::where('is_published', true)
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");
            })
            ->with('creator')
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Filter roadmaps by difficulty level.
     */
    public function getRoadmapsByDifficulty(string $difficulty)
    {
        return Roadmap::where('is_published', true)
            ->where('difficulty_level', $difficulty)
            ->with('creator')
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get roadmaps created by a specific user.
     */
    public function getRoadmapsByCreator(User $creator)
    {
        return Roadmap::where('creator_id', $creator->id)
            ->with('creator')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Soft delete a roadmap.
     */
    public function deleteRoadmap(Roadmap $roadmap): bool
    {
        // Check if there are active enrollments
        $activeEnrollments = $roadmap->enrollments()
            ->where('status', 'in_progress')
            ->count();

        if ($activeEnrollments > 0) {
            throw new \RuntimeException('Cannot delete roadmap with active enrollments.');
        }

        return $roadmap->delete();
    }

    /**
     * Restore a soft-deleted roadmap.
     */
    public function restoreRoadmap(int $roadmapId): bool
    {
        $roadmap = Roadmap::onlyTrashed()->findOrFail($roadmapId);
        return $roadmap->restore();
    }
}
