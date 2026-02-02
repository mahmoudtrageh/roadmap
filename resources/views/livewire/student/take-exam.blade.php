<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">📝 {{ $task->title }} - Exam</h1>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">
                        Attempt {{ $attemptNumber }} of 2 | Passing Score: {{ $exam->passing_score }}%
                    </p>
                </div>
                <button wire:click="backToTasks" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300">
                    ← Back to Tasks
                </button>
            </div>

            <!-- Flash Messages -->
            @if (session()->has('message'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('message') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ session('error') }}
                </div>
            @endif

            @if($previousAttempts->count() > 0 && !$showResults)
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <h3 class="font-semibold text-blue-900 dark:text-blue-100 mb-2">Previous Attempts:</h3>
                    @foreach($previousAttempts as $attempt)
                        <div class="flex items-center justify-between text-sm {{ $attempt->passed ? 'text-green-700 dark:text-green-400' : 'text-red-700 dark:text-red-400' }}">
                            <span>Attempt {{ $attempt->attempt_number }}: {{ number_format($attempt->score, 2) }}%</span>
                            <span class="font-semibold">{{ $attempt->passed ? '✅ Passed' : '❌ Failed' }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        @if(!$showResults)
            <!-- Exam Questions -->
            <form wire:submit.prevent="submitExam" class="space-y-6">
                @foreach($questions as $index => $question)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                            Question {{ $index + 1 }} of {{ $questions->count() }}
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $question->question }}</p>

                        <div class="space-y-3">
                            @foreach($question->options as $optionIndex => $option)
                                <label class="flex items-center p-3 border-2 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition {{ isset($answers[$question->id]) && $answers[$question->id] == $optionIndex ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-gray-200 dark:border-gray-700' }}">
                                    <input
                                        type="radio"
                                        wire:model="answers.{{ $question->id }}"
                                        value="{{ $optionIndex }}"
                                        class="mr-3 text-blue-600"
                                    >
                                    <span class="text-gray-700 dark:text-gray-300">{{ $option }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <button
                        type="submit"
                        class="w-full px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition"
                        @if(count($answers) < $questions->count()) disabled @endif
                    >
                        Submit Exam
                    </button>
                    @if(count($answers) < $questions->count())
                        <p class="text-center text-sm text-gray-500 dark:text-gray-400 mt-2">
                            Please answer all questions before submitting
                        </p>
                    @endif
                </div>
            </form>
        @else
            <!-- Results -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
                <div class="text-center mb-8">
                    <div class="text-6xl mb-4">
                        {{ $currentAttempt->passed ? '🎉' : '😔' }}
                    </div>
                    <h2 class="text-3xl font-bold {{ $currentAttempt->passed ? 'text-green-600' : 'text-red-600' }} mb-2">
                        {{ $currentAttempt->passed ? 'Congratulations! You Passed!' : 'Keep Trying!' }}
                    </h2>
                    <p class="text-5xl font-bold text-gray-900 dark:text-white mb-4">
                        {{ number_format($currentAttempt->score, 2) }}%
                    </p>
                    <p class="text-gray-600 dark:text-gray-400">
                        Passing Score: {{ $exam->passing_score }}%
                    </p>
                </div>

                <!-- Answer Review -->
                <div class="space-y-4 mb-8">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Review Your Answers:</h3>
                    @foreach($questions as $index => $question)
                        @php
                            $userAnswer = $currentAttempt->answers[$question->id] ?? null;
                            $isCorrect = $userAnswer !== null && (int)$userAnswer === $question->correct_answer;
                        @endphp
                        <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 border-2 {{ $isCorrect ? 'border-green-500' : 'border-red-500' }}">
                            <div class="flex items-start justify-between mb-2">
                                <h4 class="font-semibold text-gray-900 dark:text-white">Question {{ $index + 1 }}</h4>
                                <span class="text-lg">{{ $isCorrect ? '✅' : '❌' }}</span>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300 mb-3">{{ $question->question }}</p>

                            <div class="space-y-2">
                                @foreach($question->options as $optionIndex => $option)
                                    <div class="p-2 rounded {{ $optionIndex === $question->correct_answer ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200' : ($userAnswer == $optionIndex ? 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-200' : 'text-gray-600 dark:text-gray-400') }}">
                                        {{ $option }}
                                        @if($optionIndex === $question->correct_answer)
                                            <span class="font-semibold">(Correct Answer)</span>
                                        @elseif($userAnswer == $optionIndex)
                                            <span class="font-semibold">(Your Answer)</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Actions -->
                <div class="flex gap-4">
                    @if(!$currentAttempt->passed && $attemptNumber < 2)
                        <button wire:click="retryExam" class="flex-1 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold">
                            🔄 Retry Exam (Attempt {{ $attemptNumber + 1 }} of 2)
                        </button>
                    @endif
                    <button wire:click="backToTasks" class="flex-1 px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-semibold">
                        Back to Tasks
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>
