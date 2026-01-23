<div class="inline-flex items-center gap-3 text-xs text-gray-600 dark:text-gray-400">
    @if ($averageRating > 0)
        <span class="flex items-center gap-1">
            <span class="text-yellow-400">★</span>
            <span class="font-semibold">{{ $averageRating }}</span>
            <span class="text-gray-500 dark:text-gray-500">({{ $ratingCount }})</span>
        </span>
    @endif

    @if (!$isLocked)
        <button wire:click="openRatingModal" class="text-blue-600 dark:text-blue-400 hover:underline">
            {{ $userRating > 0 ? 'Your rating: ' . $userRating . '/5' : 'Rate' }}
        </button>

        <button wire:click="openCommentModal" class="text-blue-600 dark:text-blue-400 hover:underline">
            Comment
            @if ($comments->count() > 0)
                <span class="text-gray-500">({{ $comments->count() }})</span>
            @endif
        </button>

        @if (session()->has('rating-success'))
            <span class="text-green-600 dark:text-green-400">✓ Rated</span>
        @endif

        @if (session()->has('comment-success'))
            <span class="text-green-600 dark:text-green-400">✓ Posted</span>
        @endif
    @endif

    <!-- Rating Modal -->
    @if ($showRatingModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="closeRatingModal">
            <div class="relative top-20 mx-auto p-6 border w-11/12 md:w-96 shadow-lg rounded-lg bg-white dark:bg-gray-800" wire:click.stop>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Rate this Resource</h3>

                <div class="flex justify-center gap-2 mb-6">
                    @for ($i = 1; $i <= 5; $i++)
                        <button
                            wire:click="setRating({{ $i }})"
                            class="text-4xl transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 rounded p-2"
                        >
                            @if ($i <= $userRating)
                                <span class="text-yellow-400">★</span>
                            @else
                                <span class="text-gray-300 dark:text-gray-600 hover:text-yellow-400">☆</span>
                            @endif
                        </button>
                    @endfor
                </div>

                <div class="flex justify-end">
                    <button
                        wire:click="closeRatingModal"
                        class="px-4 py-2 bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-800 dark:text-gray-200 rounded transition-colors"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Comment Modal -->
    @if ($showCommentModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="closeCommentModal">
            <div class="relative top-10 mx-auto p-6 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-lg bg-white dark:bg-gray-800 max-h-[90vh] overflow-y-auto" wire:click.stop>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Comments</h3>

                <!-- Add Comment Form -->
                <div class="mb-6">
                    <textarea
                        wire:model="newComment"
                        rows="3"
                        placeholder="Share your thoughts about this resource..."
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400"
                    ></textarea>
                    @error('newComment')
                        <span class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</span>
                    @enderror

                    <div class="flex gap-2 mt-2">
                        <button
                            wire:click="addComment"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors"
                        >
                            Post Comment
                        </button>
                        <button
                            wire:click="closeCommentModal"
                            class="px-4 py-2 bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-800 dark:text-gray-200 rounded-lg transition-colors"
                        >
                            Close
                        </button>
                    </div>
                </div>

                <hr class="border-gray-200 dark:border-gray-700 mb-4">

                <!-- Comments List -->
                <div class="space-y-4">
                    @forelse ($comments as $comment)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold">
                                        {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                    </div>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <h4 class="font-semibold text-gray-900 dark:text-gray-100">
                                            {{ $comment->user->name }}
                                        </h4>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $comment->created_at->diffForHumans() }}
                                        </span>
                                    </div>

                                    <p class="text-gray-700 dark:text-gray-300 mb-2">
                                        {{ $comment->comment }}
                                    </p>

                                    <div class="flex items-center gap-3 text-sm">
                                        <button
                                            wire:click="startReply({{ $comment->id }})"
                                            class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300"
                                        >
                                            Reply
                                        </button>

                                        @if ($comment->user_id === auth()->id())
                                            <button
                                                wire:click="deleteComment({{ $comment->id }})"
                                                wire:confirm="Are you sure you want to delete this comment?"
                                                class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300"
                                            >
                                                Delete
                                            </button>
                                        @endif
                                    </div>

                                    @if ($replyTo === $comment->id)
                                        <div class="mt-3 pl-4 border-l-2 border-blue-500">
                                            <textarea
                                                wire:model="replyComment"
                                                rows="2"
                                                placeholder="Write a reply..."
                                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 text-sm"
                                            ></textarea>
                                            @error('replyComment')
                                                <span class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</span>
                                            @enderror

                                            <div class="flex gap-2 mt-2">
                                                <button
                                                    wire:click="addReply({{ $comment->id }})"
                                                    class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded transition-colors"
                                                >
                                                    Reply
                                                </button>
                                                <button
                                                    wire:click="cancelReply"
                                                    class="px-3 py-1 bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-800 dark:text-gray-200 text-sm rounded transition-colors"
                                                >
                                                    Cancel
                                                </button>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($comment->replies->count() > 0)
                                        <div class="mt-4 pl-4 border-l-2 border-gray-200 dark:border-gray-700 space-y-3">
                                            @foreach ($comment->replies as $reply)
                                                <div class="flex items-start gap-3">
                                                    <div class="flex-shrink-0">
                                                        <div class="w-8 h-8 bg-gray-400 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                                                            {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                                                        </div>
                                                    </div>

                                                    <div class="flex-1 min-w-0">
                                                        <div class="flex items-center justify-between mb-1">
                                                            <h5 class="font-semibold text-sm text-gray-900 dark:text-gray-100">
                                                                {{ $reply->user->name }}
                                                            </h5>
                                                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                                                {{ $reply->created_at->diffForHumans() }}
                                                            </span>
                                                        </div>

                                                        <p class="text-sm text-gray-700 dark:text-gray-300">
                                                            {{ $reply->comment }}
                                                        </p>

                                                        @if ($reply->user_id === auth()->id())
                                                            <button
                                                                wire:click="deleteComment({{ $reply->id }})"
                                                                wire:confirm="Are you sure you want to delete this reply?"
                                                                class="mt-1 text-xs text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300"
                                                            >
                                                                Delete
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-center py-8">
                            No comments yet. Be the first to share your thoughts!
                        </p>
                    @endforelse
                </div>
            </div>
        </div>
    @endif
</div>
