<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">📝 Manage Exam</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Task: {{ $task->title }}</p>
            </div>
            <a href="{{ route('admin.tasks', ['roadmapId' => $task->roadmap_id]) }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300">
                ← Back to Tasks
            </a>
        </div>

        @if (session()->has('message'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('message') }}
            </div>
        @endif

        <!-- Passing Score -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Exam Settings</h3>
            <div class="flex items-center gap-4">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Passing Score (%):</label>
                <input
                    type="number"
                    wire:model="passingScore"
                    min="0"
                    max="100"
                    class="w-24 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm"
                >
                <button wire:click="updatePassingScore" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                    Update
                </button>
            </div>
        </div>

        <!-- Question Form -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                {{ $editingQuestion ? 'Edit Question' : 'Add New Question' }}
            </h3>

            <form wire:submit.prevent="saveQuestion" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Question</label>
                    <textarea
                        wire:model="questionForm.question"
                        rows="3"
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm"
                        placeholder="Enter the question..."
                    ></textarea>
                    @error('questionForm.question') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Option A</label>
                        <input
                            type="text"
                            wire:model="questionForm.option_a"
                            class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm"
                        >
                        @error('questionForm.option_a') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Option B</label>
                        <input
                            type="text"
                            wire:model="questionForm.option_b"
                            class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm"
                        >
                        @error('questionForm.option_b') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Option C</label>
                        <input
                            type="text"
                            wire:model="questionForm.option_c"
                            class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm"
                        >
                        @error('questionForm.option_c') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Option D</label>
                        <input
                            type="text"
                            wire:model="questionForm.option_d"
                            class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm"
                        >
                        @error('questionForm.option_d') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Correct Answer</label>
                    <select wire:model="questionForm.correct_answer" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm">
                        <option value="0">Option A</option>
                        <option value="1">Option B</option>
                        <option value="2">Option C</option>
                        <option value="3">Option D</option>
                    </select>
                    @error('questionForm.correct_answer') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">
                        {{ $editingQuestion ? 'Update Question' : 'Add Question' }}
                    </button>
                    @if($editingQuestion)
                        <button type="button" wire:click="cancelEdit" class="px-6 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-lg font-medium">
                            Cancel
                        </button>
                    @endif
                </div>
            </form>
        </div>

        <!-- Questions List -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                Questions ({{ count($questions) }})
            </h3>

            @if(count($questions) > 0)
                <div class="space-y-4">
                    @foreach($questions as $index => $question)
                        <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                            <div class="flex items-start justify-between mb-3">
                                <h4 class="font-semibold text-gray-900 dark:text-white">Question {{ $index + 1 }}</h4>
                                <div class="flex gap-2">
                                    <button wire:click="editQuestion({{ $question['id'] }})" class="text-blue-600 hover:text-blue-700 text-sm">
                                        Edit
                                    </button>
                                    <button wire:click="deleteQuestion({{ $question['id'] }})" onclick="return confirm('Delete this question?')" class="text-red-600 hover:text-red-700 text-sm">
                                        Delete
                                    </button>
                                </div>
                            </div>

                            <p class="text-gray-700 dark:text-gray-300 mb-3">{{ $question['question'] }}</p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
                                @foreach($question['options'] as $optionIndex => $option)
                                    <div class="p-2 rounded {{ $optionIndex === $question['correct_answer'] ? 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200 font-semibold' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300' }}">
                                        {{ chr(65 + $optionIndex) }}. {{ $option }}
                                        @if($optionIndex === $question['correct_answer'])
                                            ✓
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                    <p>No questions yet. Add your first question above.</p>
                </div>
            @endif
        </div>
    </div>
</div>
