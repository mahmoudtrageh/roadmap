<?php

namespace App\Livewire\Student;

use App\Models\CommunityPost;
use App\Models\CommunityLike;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class Community extends Component
{
    use WithPagination;

    public $title = '';
    public $content = '';
    public $category = 'general';
    public $filterCategory = 'all';
    public $showCreateModal = false;
    public $isRtl = false;

    protected $rules = [
        'title' => 'required|string|min:5|max:255',
        'content' => 'required|string|min:10',
        'category' => 'required|in:general,issue,question,achievement,tip',
    ];

    public function createPost()
    {
        $this->validate();

        CommunityPost::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'content' => $this->content,
            'category' => $this->category,
        ]);

        $this->reset(['title', 'content', 'category', 'showCreateModal']);
        $this->category = 'general';

        session()->flash('message', 'Post created successfully!');
    }

    public function toggleLike($postId)
    {
        $post = CommunityPost::find($postId);

        if (!$post) {
            return;
        }

        $existingLike = CommunityLike::where('user_id', Auth::id())
            ->where('likeable_type', CommunityPost::class)
            ->where('likeable_id', $postId)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            $post->decrement('likes_count');
        } else {
            CommunityLike::create([
                'user_id' => Auth::id(),
                'likeable_type' => CommunityPost::class,
                'likeable_id' => $postId,
            ]);
            $post->increment('likes_count');
        }
    }

    public function deletePost($postId)
    {
        $post = CommunityPost::find($postId);

        if ($post && $post->user_id === Auth::id()) {
            $post->delete();
            session()->flash('message', 'Post deleted successfully!');
        }
    }

    public function toggleDirection()
    {
        $this->isRtl = !$this->isRtl;
    }

    public function render()
    {
        $query = CommunityPost::with(['user', 'comments'])
            ->withCount('comments');

        if ($this->filterCategory !== 'all') {
            $query->where('category', $this->filterCategory);
        }

        $posts = $query->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get user's likes
        $userLikes = CommunityLike::where('user_id', Auth::id())
            ->where('likeable_type', CommunityPost::class)
            ->pluck('likeable_id')
            ->toArray();

        return view('livewire.student.community', [
            'posts' => $posts,
            'userLikes' => $userLikes,
        ]);
    }
}
