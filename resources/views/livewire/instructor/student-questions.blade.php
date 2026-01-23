<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Student Questions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session()->has('message'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('message') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Filters -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status Filter</label>
                        <select wire:model.live="filterStatus" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                            <option value="all">All Questions</option>
                            <option value="pending">Pending</option>
                            <option value="answered">Answered</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search Student</label>
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="searchStudent"
                            placeholder="Student name or email..."
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                        >
                    </div>
                </div>
            </div>

            <!-- Questions List -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        Student Questions
                        <span class="text-sm font-normal text-gray-600 dark:text-gray-400">
                            ({{ $questions->total() }} total)
                        </span>
                    </h3>

                    @if($questions->count() > 0)
                        <div class="space-y-4">
                            @foreach($questions as $question)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 {{ $question->status === 'pending' ? 'bg-yellow-50 dark:bg-yellow-900/10' : 'bg-gray-50 dark:bg-gray-900/50' }}">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex-1">
                                            <!-- Student Info -->
                                            <div class="flex items-center gap-2 mb-2">
                                                <span class="font-semibold text-gray-900 dark:text-white">
                                                    {{ $question->student->name }}
                                                </span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $question->created_at->diffForHumans() }}
                                                </span>
                                                @if($question->status === 'pending')
                                                    <span class="px-2 py-1 bg-yellow-200 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 text-xs font-semibold rounded">
                                                        Pending
                                                    </span>
                                                @else
                                                    <span class="px-2 py-1 bg-green-200 dark:bg-green-900 text-green-800 dark:text-green-200 text-xs font-semibold rounded">
                                                        Answered
                                                    </span>
                                                @endif
                                                @if($question->is_public)
                                                    <span class="px-2 py-1 bg-blue-200 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-xs font-semibold rounded">
                                                        Public
                                                    </span>
                                                @endif
                                            </div>

                                            <!-- Task Info -->
                                            <div class="text-xs text-gray-600 dark:text-gray-400 mb-2">
                                                <span class="font-medium">Task:</span> {{ $question->task->title ?? 'N/A' }}
                                                @if($question->task && $question->task->roadmap)
                                                    <span class="ml-2">
                                                        <span class="font-medium">Roadmap:</span> {{ $question->task->roadmap->title }}
                                                    </span>
                                                @endif
                                            </div>

                                            <!-- Question -->
                                            <div class="text-sm text-gray-800 dark:text-gray-200 mb-2">
                                                <span class="font-medium">Question:</span>
                                                <p class="mt-1">{{ $question->question }}</p>
                                            </div>

                                            <!-- Answer (if exists) -->
                                            @if($question->answer)
                                                <div class="mt-3 pl-4 border-l-4 border-green-500">
                                                    <span class="text-xs font-medium text-gray-700 dark:text-gray-300">Answer:</span>
                                                    <p class="text-sm text-gray-800 dark:text-gray-200 mt-1">{{ $question->answer }}</p>
                                                    @if($question->answeredByUser)
                                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                            Answered by {{ $question->answeredByUser->name }} on {{ $question->answered_at->format('M d, Y') }}
                                                        </p>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex flex-col gap-2">
                                            <button
                                                wire:click="viewQuestion({{ $question->id }})"
                                                class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded transition"
                                            >
                                                {{ $question->answer ? 'Edit Answer' : 'Answer' }}
                                            </button>
                                            @if($question->status === 'pending')
                                                <button
                                                    wire:click="markAsAnswered({{ $question->id }})"
                                                    class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-sm rounded transition"
                                                >
                                                    Mark Done
                                                </button>
                                            @endif
                                            <button
                                                wire:click="deleteQuestion({{ $question->id }})"
                                                wire:confirm="Are you sure you want to delete this question?"
                                                class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-sm rounded transition"
                                            >
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $questions->links() }}
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p>No questions found</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Answer Form Modal -->
    @if($showAnswerForm && $selectedQuestion)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Answer Question</h3>

                    <!-- Question Details -->
                    <div class="mb-4 p-4 bg-gray-50 dark:bg-gray-900 rounded-lg">
                        <div class="mb-2">
                            <span class="font-semibold text-gray-900 dark:text-white">Student:</span>
                            <span class="text-gray-700 dark:text-gray-300">{{ $selectedQuestion->student->name }}</span>
                        </div>
                        <div class="mb-2">
                            <span class="font-semibold text-gray-900 dark:text-white">Task:</span>
                            <span class="text-gray-700 dark:text-gray-300">{{ $selectedQuestion->task->title ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-900 dark:text-white">Question:</span>
                            <p class="text-gray-700 dark:text-gray-300 mt-1">{{ $selectedQuestion->question }}</p>
                        </div>
                    </div>

                    <!-- Answer Form -->
                    <form wire:submit.prevent="submitAnswer">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Your Answer *
                            </label>
                            <textarea
                                wire:model="answer"
                                rows="6"
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                                placeholder="Type your answer here..."
                            ></textarea>
                            @error('answer')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="flex items-center">
                                <input
                                    type="checkbox"
                                    wire:model="isPublic"
                                    class="rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900"
                                >
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                    Make this answer public (visible to other students)
                                </span>
                            </label>
                        </div>

                        <div class="flex justify-end gap-3">
                            <button
                                type="button"
                                wire:click="closeAnswerForm"
                                class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition"
                            >
                                Submit Answer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
