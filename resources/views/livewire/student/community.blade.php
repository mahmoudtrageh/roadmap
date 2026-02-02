<div class="py-12" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between gap-4 flex-wrap">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">💬 Community</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Share your thoughts, ask questions, and help others</p>
            </div>
            <div class="flex items-center gap-3">
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

                <button wire:click="$set('showCreateModal', true)" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition shadow-lg">
                    ✍️ Create Post
                </button>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('message') }}
            </div>
        @endif

        <!-- Category Filter -->
        <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
            <div class="flex flex-wrap gap-2">
                <button wire:click="$set('filterCategory', 'all')" class="px-4 py-2 rounded-lg transition {{ $filterCategory === 'all' ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300' }}">
                    All Posts
                </button>
                <button wire:click="$set('filterCategory', 'question')" class="px-4 py-2 rounded-lg transition {{ $filterCategory === 'question' ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300' }}">
                    ❓ Questions
                </button>
                <button wire:click="$set('filterCategory', 'issue')" class="px-4 py-2 rounded-lg transition {{ $filterCategory === 'issue' ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300' }}">
                    🐛 Issues
                </button>
                <button wire:click="$set('filterCategory', 'tip')" class="px-4 py-2 rounded-lg transition {{ $filterCategory === 'tip' ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300' }}">
                    💡 Tips
                </button>
                <button wire:click="$set('filterCategory', 'achievement')" class="px-4 py-2 rounded-lg transition {{ $filterCategory === 'achievement' ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300' }}">
                    🏆 Achievements
                </button>
                <button wire:click="$set('filterCategory', 'general')" class="px-4 py-2 rounded-lg transition {{ $filterCategory === 'general' ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300' }}">
                    💬 General
                </button>
            </div>
        </div>

        <!-- Posts List -->
        <div class="space-y-4">
            @forelse($posts as $post)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition p-6">
                    <!-- Post Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white font-bold">
                                {{ substr($post->user->name, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">{{ $post->user->name }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $post->created_at->diffForHumans() }}</p>
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

                    <!-- Post Content -->
                    <a href="{{ route('student.community.post', $post->id) }}" class="block mb-4">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2 hover:text-blue-600">{{ $post->title }}</h2>
                        <p class="text-gray-600 dark:text-gray-300 line-clamp-3">{{ $post->content }}</p>
                    </a>

                    <!-- Post Actions -->
                    <div class="flex items-center gap-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <button wire:click="toggleLike({{ $post->id }})" class="flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-blue-600 transition">
                            <span class="text-xl">{{ in_array($post->id, $userLikes) ? '❤️' : '🤍' }}</span>
                            <span class="font-semibold">{{ $post->likes_count }}</span>
                        </button>
                        <a href="{{ route('student.community.post', $post->id) }}" class="flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-blue-600 transition">
                            <span class="text-xl">💬</span>
                            <span class="font-semibold">{{ $post->comments_count }}</span>
                        </a>
                        @if($post->user_id === Auth::id())
                            <button wire:click="deletePost({{ $post->id }})" onclick="return confirm('Delete this post?')" class="ml-auto text-red-600 hover:text-red-700 text-sm">
                                Delete
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-12 text-center">
                    <div class="text-6xl mb-4">💬</div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No Posts Yet!</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Be the first to start a discussion</p>
                    <button wire:click="$set('showCreateModal', true)" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                        Create First Post
                    </button>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $posts->links() }}
        </div>

        <!-- Create Post Modal -->
        @if($showCreateModal)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Create New Post</h3>
                        <button wire:click="$set('showCreateModal', false)" class="text-gray-400 hover:text-gray-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form wire:submit.prevent="createPost" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
                            <select wire:model="category" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="general">💬 General Discussion</option>
                                <option value="question">❓ Question</option>
                                <option value="issue">🐛 Issue/Problem</option>
                                <option value="tip">💡 Tip/Advice</option>
                                <option value="achievement">🏆 Achievement/Success</option>
                            </select>
                            @error('category') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Title</label>
                            <input type="text" wire:model="title" placeholder="What's on your mind?" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Content</label>
                            <textarea wire:model="content" rows="6" placeholder="Share your thoughts, ask questions, or help others..." class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                            @error('content') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex gap-3 pt-4">
                            <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-medium">
                                Post
                            </button>
                            <button type="button" wire:click="$set('showCreateModal', false)" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-300">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
