<div>
    @if($questions && count($questions) > 0)
    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6 mb-4">
        <!-- Quiz Header -->
        <div class="flex items-center gap-2 mb-4">
            <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Self-Assessment Quiz</h4>
        </div>

        @if($introduction)
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ $introduction }}</p>
        @endif

        @if(session()->has('quiz-error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4">
            {{ session('quiz-error') }}
        </div>
        @endif

        @if(!$showResults)
        <!-- Quiz Questions -->
        <div class="space-y-6">
            @foreach($questions as $qIndex => $question)
            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                <p class="font-medium text-gray-800 dark:text-gray-200 mb-3">
                    {{ $qIndex + 1 }}. {{ $question['question'] }}
                </p>

                <div class="space-y-2">
                    @foreach($question['options'] as $oIndex => $option)
                    <button
                        type="button"
                        @click="$wire.selectAnswer({{ $qIndex }}, {{ $oIndex }})"
                        @disabled($isLocked)
                        class="w-full text-left px-4 py-3 rounded-lg border-2 transition-all
                            {{ $answers[$qIndex] === $oIndex
                                ? 'border-purple-500 bg-purple-50 dark:bg-purple-900/20'
                                : 'border-gray-300 dark:border-gray-600 hover:border-purple-300' }}
                            {{ $isLocked ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer' }}">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0">
                                @if($answers[$qIndex] === $oIndex)
                                <div class="w-5 h-5 bg-purple-500 border-2 border-purple-500 rounded-full flex items-center justify-center">
                                    <div class="w-2 h-2 bg-white rounded-full"></div>
                                </div>
                                @else
                                <div class="w-5 h-5 border-2 border-gray-400 dark:border-gray-500 rounded-full"></div>
                                @endif
                            </div>
                            <span class="text-gray-700 dark:text-gray-300">{{ $option }}</span>
                        </div>
                    </button>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <!-- Submit Button -->
        <div class="mt-6 flex justify-end">
            <button
                type="button"
                @click="$wire.submitQuiz()"
                @disabled($isLocked)
                class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors
                    {{ $isLocked ? 'opacity-50 cursor-not-allowed' : '' }}">
                Submit Quiz
            </button>
        </div>

        @else
        <!-- Quiz Results -->
        <div class="space-y-4">
            <!-- Score Card -->
            <div class="bg-gradient-to-r {{ $passed ? 'from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20' : 'from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20' }} border {{ $passed ? 'border-green-200 dark:border-green-800' : 'border-orange-200 dark:border-orange-800' }} rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        @if($passed)
                        <svg class="w-12 h-12 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h5 class="text-xl font-bold text-green-800 dark:text-green-300">Congratulations!</h5>
                            <p class="text-sm text-green-700 dark:text-green-400">You passed the quiz!</p>
                        </div>
                        @else
                        <svg class="w-12 h-12 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h5 class="text-xl font-bold text-orange-800 dark:text-orange-300">Keep Trying!</h5>
                            <p class="text-sm text-orange-700 dark:text-orange-400">Review the material and try again.</p>
                        </div>
                        @endif
                    </div>

                    <div class="text-center">
                        <div class="text-4xl font-bold {{ $passed ? 'text-green-600 dark:text-green-400' : 'text-orange-600 dark:text-orange-400' }}">
                            {{ $score }}%
                        </div>
                        <p class="text-sm {{ $passed ? 'text-green-700 dark:text-green-400' : 'text-orange-700 dark:text-orange-400' }}">
                            {{ $correctCount }}/{{ $totalQuestions }} correct
                        </p>
                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                            Passing: {{ $passingScore }}%
                        </p>
                    </div>
                </div>
            </div>

            <!-- Question Review -->
            <div class="space-y-4">
                @foreach($questions as $qIndex => $question)
                @php
                    $studentAnswer = $answers[$qIndex] ?? null;
                    $correctAnswer = $question['correct_answer'] ?? 0;
                    $isCorrect = $studentAnswer === $correctAnswer;
                @endphp

                <div class="border {{ $isCorrect ? 'border-green-200 dark:border-green-800' : 'border-red-200 dark:border-red-800' }} rounded-lg p-4">
                    <div class="flex items-start gap-2 mb-2">
                        @if($isCorrect)
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        @else
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        @endif
                        <p class="font-medium text-gray-800 dark:text-gray-200">
                            {{ $qIndex + 1 }}. {{ $question['question'] }}
                        </p>
                    </div>

                    <div class="ml-7 space-y-2">
                        @foreach($question['options'] as $oIndex => $option)
                        <div class="flex items-center gap-2 text-sm">
                            @if($oIndex === $correctAnswer)
                            <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 rounded font-medium">
                                ✓ Correct
                            </span>
                            @elseif($oIndex === $studentAnswer && !$isCorrect)
                            <span class="px-2 py-1 bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 rounded font-medium">
                                ✗ Your answer
                            </span>
                            @else
                            <span class="w-20"></span>
                            @endif
                            <span class="text-gray-700 dark:text-gray-300">{{ $option }}</span>
                        </div>
                        @endforeach

                        @if(isset($question['explanation']))
                        <div class="mt-3 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded">
                            <p class="text-sm text-blue-900 dark:text-blue-300">
                                <span class="font-semibold">Explanation:</span> {{ $question['explanation'] }}
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Retake Button -->
            <div class="flex justify-end gap-3 mt-6">
                <button
                    type="button"
                    @click="$wire.retakeQuiz()"
                    @disabled($isLocked)
                    class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors
                        {{ $isLocked ? 'opacity-50 cursor-not-allowed' : '' }}">
                    Retake Quiz
                </button>
            </div>
        </div>
        @endif
    </div>
    @endif
</div>
