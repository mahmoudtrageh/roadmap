<?php

namespace App\Livewire\Student;

use App\Models\ResourceRating;
use App\Models\ResourceComment;
use App\Models\Task;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ResourceReview extends Component
{
    public $taskId;
    public $resourceUrl;
    public $isLocked;
    public $userRating = 0;
    public $newComment = '';
    public $replyTo = null;
    public $replyComment = '';
    public $showRatingModal = false;
    public $showCommentModal = false;

    public function mount($taskId, $resourceUrl, $isLocked = false)
    {
        $this->taskId = $taskId;
        $this->resourceUrl = $resourceUrl;
        $this->isLocked = $isLocked;

        // Load user's existing rating
        $existingRating = ResourceRating::where('task_id', $taskId)
            ->where('user_id', Auth::id())
            ->where('resource_url', $resourceUrl)
            ->first();

        if ($existingRating) {
            $this->userRating = $existingRating->rating;
        }
    }

    public function openRatingModal()
    {
        $this->showRatingModal = true;
    }

    public function closeRatingModal()
    {
        $this->showRatingModal = false;
    }

    public function openCommentModal()
    {
        $this->showCommentModal = true;
    }

    public function closeCommentModal()
    {
        $this->showCommentModal = false;
        $this->newComment = '';
    }

    public function setRating($rating)
    {
        ResourceRating::updateOrCreate(
            [
                'task_id' => $this->taskId,
                'user_id' => Auth::id(),
                'resource_url' => $this->resourceUrl,
            ],
            [
                'rating' => $rating
            ]
        );

        $this->userRating = $rating;
        $this->showRatingModal = false;

        session()->flash('rating-success', 'Rating saved successfully!');
    }

    public function addComment()
    {
        $this->validate([
            'newComment' => 'required|string|max:1000'
        ]);

        ResourceComment::create([
            'task_id' => $this->taskId,
            'user_id' => Auth::id(),
            'resource_url' => $this->resourceUrl,
            'comment' => $this->newComment,
        ]);

        $this->newComment = '';
        $this->showCommentModal = false;

        session()->flash('comment-success', 'Comment added successfully!');
    }

    public function startReply($commentId)
    {
        $this->replyTo = $commentId;
        $this->replyComment = '';
    }

    public function cancelReply()
    {
        $this->replyTo = null;
        $this->replyComment = '';
    }

    public function addReply($parentId)
    {
        $this->validate([
            'replyComment' => 'required|string|max:1000'
        ]);

        ResourceComment::create([
            'task_id' => $this->taskId,
            'user_id' => Auth::id(),
            'resource_url' => $this->resourceUrl,
            'comment' => $this->replyComment,
            'parent_id' => $parentId,
        ]);

        $this->replyTo = null;
        $this->replyComment = '';

        session()->flash('comment-success', 'Reply added successfully!');
    }

    public function deleteComment($commentId)
    {
        $comment = ResourceComment::where('id', $commentId)
            ->where('user_id', Auth::id())
            ->first();

        if ($comment) {
            $comment->delete();
            session()->flash('comment-success', 'Comment deleted successfully!');
        }
    }

    public function render()
    {
        $task = Task::findOrFail($this->taskId);

        // Get average rating for this resource
        $averageRating = ResourceRating::where('task_id', $this->taskId)
            ->where('resource_url', $this->resourceUrl)
            ->avg('rating');

        $ratingCount = ResourceRating::where('task_id', $this->taskId)
            ->where('resource_url', $this->resourceUrl)
            ->count();

        // Get comments (only top-level, replies are loaded via relationship)
        $comments = ResourceComment::where('task_id', $this->taskId)
            ->where('resource_url', $this->resourceUrl)
            ->whereNull('parent_id')
            ->with(['user', 'replies.user'])
            ->latest()
            ->get();

        return view('livewire.student.resource-review', [
            'task' => $task,
            'averageRating' => round($averageRating, 1),
            'ratingCount' => $ratingCount,
            'comments' => $comments,
        ]);
    }
}
