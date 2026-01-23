<div>
    @if($totalHints > 0)
    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6 mb-4">
        <!-- Header -->
        <div class="flex items-center gap-2 mb-4">
            <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
            </svg>
            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Need Help?</h4>
            <span class="ml-auto text-sm text-gray-600 dark:text-gray-400">
                {{ $hintsRevealed }}/{{ $totalHints }} hints revealed
            </span>
        </div>

        @if($introduction)
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ $introduction }}</p>
        @endif

        @if(session()->has('question-submitted'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4">
            {{ session('question-submitted') }}
        </div>
        @endif

        <!-- Hints List -->
        <div class="space-y-3 mb-4">
            @foreach($hints as $index => $hint)
            @php
                $isRevealed = $index < $hintsRevealed;
                $level = $hint['level'] ?? ($index + 1);
            @endphp

            <div class="border border-gray-200 dark:border-gray-600 rounded-lg overflow-hidden">
                <div class="flex items-center gap-3 p-4 {{ $isRevealed ? 'bg-amber-50 dark:bg-amber-900/20' : 'bg-gray-50 dark:bg-gray-700/50' }}">
                    @if($isRevealed)
                    <!-- Revealed Hint -->
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-amber-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                            {{ $level }}
                        </div>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-800 dark:text-gray-200">{{ $hint['text'] }}</p>
                    </div>
                    @else
                    <!-- Locked Hint -->
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Hint {{ $level }} (not yet revealed)</p>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Reveal Next Hint Button -->
        @if($hintsRevealed < $totalHints)
        <div class="flex justify-center mb-4">
            <button
                type="button"
                @click="$wire.revealNextHint()"
                class="px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
                <span>Reveal Next Hint ({{ $hintsRevealed + 1 }}/{{ $totalHints }})</span>
            </button>
        </div>
        @else
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 mb-4 text-center">
            <p class="text-sm text-green-800 dark:text-green-300 font-medium">
                ✓ All hints revealed! You've got this!
            </p>
        </div>
        @endif

        <!-- Previous Questions & Answers -->
        @if(count($studentQuestions) > 0)
        <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mb-4">
            <h5 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-3">Your Questions</h5>
            <div class="space-y-3">
                @foreach($studentQuestions as $q)
                <div class="bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg p-3">
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

        <!-- Ask Question Section -->
        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
            @if(!$showQuestionForm)
            <button
                type="button"
                @click="$wire.toggleQuestionForm()"
                class="w-full px-4 py-3 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:border-amber-400 dark:hover:border-amber-500 hover:text-amber-600 dark:hover:text-amber-400 transition-colors flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="font-medium">Still stuck? Ask a Question</span>
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
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                        placeholder="Describe what you're struggling with... (minimum 10 characters)"></textarea>
                    @error('question')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button
                        type="button"
                        @click="$wire.submitQuestion()"
                        class="flex-1 px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg transition-colors">
                        Submit Question
                    </button>
                    <button
                        type="button"
                        @click="$wire.toggleQuestionForm()"
                        class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg transition-colors">
                        Cancel
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>
