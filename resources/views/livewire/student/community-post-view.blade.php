<div class="py-12" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <!-- Back Button and RTL Toggle -->
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('student.community') }}" class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                <svg class="w-5 h-5 {{ $isRtl ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $isRtl ? 'M14 5l7 7m0 0l-7 7m7-7H3' : 'M10 19l-7-7m0 0l7-7m-7 7h18' }}"></path>
                </svg>
                Back to Community
            </a>

            <!-- RTL/LTR Toggle -->
            <button
                wire:click="toggleDirection"
                class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-medium transition shadow flex items-center gap-2"
                title="Toggle Text Direction"
            >
                @if($isRtl)
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                    </svg>
                    <span>RTL</span>
                @else
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                    </svg>
                    <span>LTR</span>
                @endif
            </button>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('message') }}
            </div>
        @endif

        <!-- Post Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 mb-6">
            <!-- Post Header -->
            <div class="flex items-start justify-between mb-6">
                <div class="flex items-center gap-4">
                    <div class="h-12 w-12 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white font-bold text-lg">
                        {{ substr($post->user->name, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="font-semibold text-lg text-gray-900 dark:text-white">{{ $post->user->name }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $post->created_at->format('M d, Y \a\t H:i') }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    @php
                        $categoryColors = [
                            'question' => 'blue',
                            'issue' => 'red',
                            'tip' => 'green',
                            'achievement' => 'yellow',
                            'general' => 'gray',
                        ];
                        $color = $categoryColors[$post->category] ?? 'gray';
                        $categoryIcons = [
                            'question' => '❓',
                            'issue' => '🐛',
                            'tip' => '💡',
                            'achievement' => '🏆',
                            'general' => '💬',
                        ];
                        $icon = $categoryIcons[$post->category] ?? '💬';
                    @endphp
                    <span class="px-3 py-1 bg-{{ $color }}-100 dark:bg-{{ $color }}-900/30 text-{{ $color }}-700 dark:text-{{ $color }}-300 text-sm rounded-full">
                        {{ $icon }} {{ ucfirst($post->category) }}
                    </span>
                    @if($post->is_resolved)
                        <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-sm rounded-full">
                            ✅ Resolved
                        </span>
                    @endif
                </div>
            </div>

            <!-- Post Title -->
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ $post->title }}</h1>

            <!-- Post Content -->
            <div class="prose dark:prose-invert max-w-none mb-6">
                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $post->content }}</p>
            </div>

            <!-- Post Actions -->
            <div class="flex items-center gap-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                <button wire:click="toggleLike" class="flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-red-600 transition">
                    <span class="text-2xl">{{ $userLikedPost ? '❤️' : '🤍' }}</span>
                    <span class="font-semibold">{{ $post->likes_count }}</span>
                </button>
                <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                    <span class="text-2xl">💬</span>
                    <span class="font-semibold">{{ $post->comments_count }}</span>
                </div>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                Comments ({{ $post->comments_count }})
            </h2>

            <!-- Add Comment Form -->
            <div class="mb-8 bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                <form wire:submit.prevent="addComment">
                    <div class="flex items-start gap-4">
                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <textarea 
                                wire:model="commentContent" 
                                rows="3" 
                                placeholder="Add your comment..." 
                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            ></textarea>
                            @error('commentContent') 
                                <span class="text-red-600 text-sm">{{ $message }}</span> 
                            @enderror
                            <div class="mt-2 flex justify-end">
                                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium transition">
                                    Post Comment
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Comments List -->
            <div class="space-y-4">
                @forelse($post->comments()->latest()->get() as $comment)
                    <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 {{ $comment->is_solution ? 'border-2 border-green-500' : '' }}">
                        <!-- Comment Header -->
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-green-400 to-blue-500 flex items-center justify-center text-white font-bold">
                                    {{ substr($comment->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 dark:text-white">
                                        {{ $comment->user->name }}
                                        @if($comment->user_id === $post->user_id)
                                            <span class="ml-2 px-2 py-0.5 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs rounded-full">
                                                Author
                                            </span>
                                        @endif
                                        @if($comment->is_solution)
                                            <span class="ml-2 px-2 py-0.5 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-xs rounded-full">
                                                ✅ Solution
                                            </span>
                                        @endif
                                    </h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Comment Content -->
                        <p class="text-gray-700 dark:text-gray-300 mb-3 ml-13 whitespace-pre-wrap">{{ $comment->content }}</p>

                        <!-- Comment Actions -->
                        <div class="flex items-center gap-4 ml-13">
                            <button wire:click="toggleCommentLike({{ $comment->id }})" class="flex items-center gap-1 text-gray-600 dark:text-gray-400 hover:text-red-600 transition text-sm">
                                <span>{{ in_array($comment->id, $userLikedComments) ? '❤️' : '🤍' }}</span>
                                <span class="font-semibold">{{ $comment->likes_count }}</span>
                            </button>

                            @if($post->user_id === Auth::id() && !$comment->is_solution && in_array($post->category, ['question', 'issue']))
                                <button wire:click="markAsSolution({{ $comment->id }})" class="text-sm text-green-600 hover:text-green-700 font-medium">
                                    ✓ Mark as Solution
                                </button>
                            @endif

                            @if($comment->user_id === Auth::id())
                                <button wire:click="deleteComment({{ $comment->id }})" onclick="return confirm('Delete this comment?')" class="text-sm text-red-600 hover:text-red-700">
                                    Delete
                                </button>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <p>No comments yet. Be the first to comment!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
