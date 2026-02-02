<?php

namespace App\Livewire\Student;

use App\Models\CommunityPost;
use App\Models\CommunityComment;
use App\Models\CommunityLike;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class CommunityPostView extends Component
{
    public $postId;
    public $post;
    public $commentContent = '';
    public $isRtl = false;

    protected $rules = [
        'commentContent' => 'required|string|min:2',
    ];

    public function mount($postId)
    {
        $this->postId = $postId;
        $this->loadPost();
    }

    public function loadPost()
    {
        $this->post = CommunityPost::with(['user', 'comments.user', 'comments.likes'])
            ->withCount('comments')
            ->findOrFail($this->postId);
    }

    public function toggleLike()
    {
        $existingLike = CommunityLike::where('user_id', Auth::id())
            ->where('likeable_type', CommunityPost::class)
            ->where('likeable_id', $this->postId)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            $this->post->decrement('likes_count');
        } else {
            CommunityLike::create([
                'user_id' => Auth::id(),
                'likeable_type' => CommunityPost::class,
                'likeable_id' => $this->postId,
            ]);
            $this->post->increment('likes_count');
        }

        $this->loadPost();
    }

    public function toggleCommentLike($commentId)
    {
        $comment = CommunityComment::find($commentId);

        if (!$comment) {
            return;
        }

        $existingLike = CommunityLike::where('user_id', Auth::id())
            ->where('likeable_type', CommunityComment::class)
            ->where('likeable_id', $commentId)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            $comment->decrement('likes_count');
        } else {
            CommunityLike::create([
                'user_id' => Auth::id(),
                'likeable_type' => CommunityComment::class,
                'likeable_id' => $commentId,
            ]);
            $comment->increment('likes_count');
        }

        $this->loadPost();
    }

    public function addComment()
    {
        $this->validate();

        CommunityComment::create([
            'post_id' => $this->postId,
            'user_id' => Auth::id(),
            'content' => $this->commentContent,
        ]);

        $this->post->increment('comments_count');

        $this->reset('commentContent');
        $this->loadPost();

        session()->flash('message', 'Comment added successfully!');
    }

    public function deleteComment($commentId)
    {
        $comment = CommunityComment::find($commentId);

        if ($comment && $comment->user_id === Auth::id()) {
            $comment->delete();
            $this->post->decrement('comments_count');
            $this->loadPost();
            session()->flash('message', 'Comment deleted successfully!');
        }
    }

    public function markAsSolution($commentId)
    {
        if ($this->post->user_id !== Auth::id()) {
            return;
        }

        // Unmark all other solutions
        CommunityComment::where('post_id', $this->postId)
            ->update(['is_solution' => false]);

        // Mark this comment as solution
        $comment = CommunityComment::find($commentId);
        if ($comment) {
            $comment->update(['is_solution' => true]);

            // Mark post as resolved
            $this->post->update(['is_resolved' => true]);

            $this->loadPost();
            session()->flash('message', 'Marked as solution!');
        }
    }

    public function toggleDirection()
    {
        $this->isRtl = !$this->isRtl;
    }

    public function render()
    {
        // Get user's likes for post
        $userLikedPost = CommunityLike::where('user_id', Auth::id())
            ->where('likeable_type', CommunityPost::class)
            ->where('likeable_id', $this->postId)
            ->exists();

        // Get user's likes for comments
        $userLikedComments = CommunityLike::where('user_id', Auth::id())
            ->where('likeable_type', CommunityComment::class)
            ->whereIn('likeable_id', $this->post->comments->pluck('id'))
            ->pluck('likeable_id')
            ->toArray();

        return view('livewire.student.community-post-view', [
            'userLikedPost' => $userLikedPost,
            'userLikedComments' => $userLikedComments,
        ]);
    }
}
