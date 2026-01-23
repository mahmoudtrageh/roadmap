<div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6 mb-4">
    <!-- Header -->
    <div class="flex items-center gap-2 mb-4">
        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Questions & Answers</h4>
    </div>

    @if(session()->has('question-submitted'))
    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded-lg mb-4">
        {{ session('question-submitted') }}
    </div>
    @endif

    <!-- My Questions -->
    @if(count($myQuestions) > 0)
    <div class="mb-4">
        <h5 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-3 flex items-center gap-2">
            <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
            Your Questions
        </h5>
        <div class="space-y-3">
            @foreach($myQuestions as $q)
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg p-3">
                <div class="flex items-start justify-between gap-2 mb-2">
                    <div class="flex-1">
                        <p class="text-sm text-gray-800 dark:text-gray-200 mb-1">{{ $q['question'] }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Asked {{ \Carbon\Carbon::parse($q['created_at'])->diffForHumans() }}
                        </p>
                    </div>
                    @if($q['status'] === 'pending')
                    <span class="px-2 py-1 bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 text-xs font-semibold rounded">
                        Pending
                    </span>
                    @else
                    <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 text-xs font-semibold rounded">
                        Answered
                    </span>
                    @endif
                </div>

                @if($q['answer'])
                <div class="mt-2 pl-3 border-l-4 border-green-500">
                    <p class="text-xs font-semibold text-green-700 dark:text-green-400 mb-1">Answer:</p>
                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $q['answer'] }}</p>
                    @if(isset($q['answered_by_user']))
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        - {{ $q['answered_by_user']['name'] ?? 'Instructor' }}
                    </p>
                    @endif
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Public Questions from Other Students -->
    @if(count($publicQuestions) > 0)
    <div class="mb-4">
        <h5 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-3 flex items-center gap-2">
            <span class="w-2 h-2 bg-purple-500 rounded-full"></span>
            Community Q&A
        </h5>
        <div class="space-y-3">
            @foreach($publicQuestions as $q)
            <div class="bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg p-3">
                <div class="flex items-start justify-between gap-2 mb-2">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-semibold text-purple-600 dark:text-purple-400">
                                {{ $q['student']['name'] ?? 'Student' }}
                            </span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                • {{ \Carbon\Carbon::parse($q['created_at'])->diffForHumans() }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-800 dark:text-gray-200 mb-1">{{ $q['question'] }}</p>
                    </div>
                    <span class="px-2 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 text-xs font-semibold rounded">
                        Public
                    </span>
                </div>

                @if($q['answer'])
                <div class="mt-2 pl-3 border-l-4 border-purple-500">
                    <p class="text-xs font-semibold text-purple-700 dark:text-purple-400 mb-1">Answer:</p>
                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $q['answer'] }}</p>
                    @if(isset($q['answered_by_user']))
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        - {{ $q['answered_by_user']['name'] ?? 'Instructor' }}
                    </p>
                    @endif
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Ask Question Section -->
    <div class="{{ (count($myQuestions) > 0 || count($publicQuestions) > 0) ? 'border-t border-gray-200 dark:border-gray-700 pt-4' : '' }}">
        @if(!$showQuestionForm)
        <button
            type="button"
            wire:click="toggleQuestionForm"
            class="w-full px-4 py-3 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:border-blue-400 dark:hover:border-blue-500 hover:text-blue-600 dark:hover:text-blue-400 transition-colors flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-medium">Ask a Question</span>
        </button>
        @else
        <div class="space-y-3">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    What do you need help with?
                </label>
                <textarea
                    wire:model="question"
                    rows="4"
                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                    placeholder="Describe what you're struggling with... (minimum 10 characters)"></textarea>
                @error('question')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button
                    type="button"
                    wire:click="submitQuestion"
                    class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                    Submit Question
                </button>
                <button
                    type="button"
                    wire:click="toggleQuestionForm"
                    class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg transition-colors">
                    Cancel
                </button>
            </div>
        </div>
        @endif
    </div>
</div>
