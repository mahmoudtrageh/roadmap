<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-900">Code Review Queue</h2>
                <p class="mt-1 text-sm text-gray-600">Review and provide feedback on student code submissions</p>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Review Modal -->
        @if ($showReviewForm && $selectedSubmission)
            <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="closeReviewForm">
                <div class="relative top-10 mx-auto p-5 border w-11/12 max-w-6xl shadow-lg rounded-md bg-white" wire:click.stop>
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">Code Review</h3>
                            <p class="text-sm text-gray-600">{{ $selectedSubmission->student->name }} - {{ $selectedSubmission->taskCompletion->task->title }}</p>
                        </div>
                        <button wire:click="closeReviewForm" class="text-gray-400 hover:text-gray-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                        <!-- File Display -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-sm font-medium text-gray-700">{{ ucfirst($selectedSubmission->language) }}</span>
                                <span class="text-xs text-gray-500">Submitted {{ $selectedSubmission->created_at->diffForHumans() }}</span>
                            </div>

                            <div class="bg-white border border-gray-200 rounded-lg p-6">
                                <div class="flex items-start gap-4">
                                    <div class="flex-shrink-0">
                                        <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-semibold text-gray-900 mb-1">Submitted File</h4>
                                        <p class="text-sm text-gray-600 break-words">{{ $selectedSubmission->original_filename ?? 'submission.' . $selectedSubmission->language }}</p>

                                        @if($selectedSubmission->submission_notes)
                                            <div class="mt-4 pt-4 border-t border-gray-200">
                                                <h5 class="text-xs font-semibold text-gray-700 mb-2">Student Notes:</h5>
                                                <p class="text-sm text-gray-600">{{ $selectedSubmission->submission_notes }}</p>
                                            </div>
                                        @endif

                                        <div class="mt-4">
                                            <button wire:click="downloadSubmission({{ $selectedSubmission->id }})"
                                               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-150">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                                </svg>
                                                Download File
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Review Form -->
                        <div>
                            <form wire:submit="submitReview" class="space-y-4">
                                <!-- Rating -->
                                <div>
                                    <label for="rating" class="block text-sm font-medium text-gray-700">Rating (1-10)</label>
                                    <div class="flex items-center gap-2 mt-2">
                                        <input type="range" wire:model.live="rating" id="rating" min="1" max="10" class="flex-1" />
                                        <span class="text-2xl font-bold text-blue-600 w-12 text-center">{{ $rating }}</span>
                                    </div>
                                    @error('rating') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Status -->
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Decision</label>
                                    <select wire:model="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="approved">✅ Approve - Great Work!</option>
                                        <option value="needs_revision">📝 Needs Revision - Requires Changes</option>
                                    </select>
                                    @error('status') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Feedback -->
                                <div>
                                    <label for="feedback" class="block text-sm font-medium text-gray-700">Feedback</label>
                                    <textarea wire:model="feedback" id="feedback" rows="8" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Provide detailed feedback..."></textarea>
                                    @error('feedback') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <!-- Actions -->
                                <div class="flex gap-3 pt-4">
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition duration-150">
                                        Submit Review
                                    </button>
                                    <button type="button" wire:click="closeReviewForm" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg font-medium transition duration-150">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Previous Reviews -->
                    @if($selectedSubmission->codeReviews->count() > 0)
                        <div class="border-t pt-4">
                            <h4 class="text-lg font-semibold text-gray-700 mb-3">Previous Reviews</h4>
                            <div class="space-y-3">
                                @foreach($selectedSubmission->codeReviews as $review)
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <span class="font-medium text-gray-900">{{ $review->reviewer->name }}</span>
                                                <span class="text-sm text-gray-500 ml-2">Rating: {{ $review->rating }}/10</span>
                                            </div>
                                            <span class="text-xs text-gray-500">{{ $review->reviewed_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-sm text-gray-700">{{ $review->feedback }}</p>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium mt-2
                                            @if($review->status === 'approved') bg-green-100 text-green-800
                                            @elseif($review->status === 'needs_revision') bg-yellow-100 text-yellow-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst(str_replace('_', ' ', $review->status)) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Filters -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <input type="text" wire:model.live.debounce.300ms="searchStudent" placeholder="Search by student name..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                    </div>
                    <div>
                        <select wire:model.live="filterStatus" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="submitted">⏳ Awaiting Review</option>
                            <option value="approved">✅ Approved</option>
                            <option value="needs_revision">📝 Needs Revision</option>
                            <option value="all">All Status</option>
                        </select>
                    </div>
                    <div>
                        <select wire:model.live="filterLanguage" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="all">All Languages</option>
                            @foreach($languages as $lang)
                                <option value="{{ $lang }}">{{ ucfirst($lang) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submissions List -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="space-y-4">
                    @forelse ($submissions as $submission)
                        <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $submission->taskCompletion->task->title }}</h3>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ ucfirst($submission->language) }}
                                        </span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                            @if($submission->submission_status === 'approved') bg-green-100 text-green-800
                                            @elseif($submission->submission_status === 'needs_revision') bg-yellow-100 text-yellow-800
                                            @else bg-blue-100 text-blue-800 @endif">
                                            {{ ucfirst(str_replace('_', ' ', $submission->submission_status)) }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-2">
                                        Roadmap: {{ $submission->taskCompletion->task->roadmap->title }}
                                    </p>
                                    <div class="flex items-center gap-4 text-sm text-gray-500">
                                        <span>Student: {{ $submission->student->name }}</span>
                                        <span>Submitted: {{ $submission->created_at->diffForHumans() }}</span>
                                        @if($submission->codeReviews->count() > 0)
                                            <span class="text-green-600">{{ $submission->codeReviews->count() }} review(s)</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex gap-2 ml-4">
                                    <button wire:click="viewSubmission({{ $submission->id }})" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-150">
                                        Review
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 text-gray-500">
                            No code submissions found.
                        </div>
                    @endforelse
                </div>
                <div class="mt-6">
                    {{ $submissions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
