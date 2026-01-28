<div>
    <!-- Floating Feedback Button -->
    <button
        wire:click="openModal"
        class="fixed left-6 bottom-6 bg-blue-600 hover:bg-blue-700 text-white rounded-full p-4 shadow-lg hover:shadow-xl transition-all duration-300 z-40 group"
        title="Send Feedback"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
        </svg>
        <span class="absolute left-full ml-3 px-3 py-1 bg-gray-900 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
            Send Feedback
        </span>
    </button>

    <!-- Success Toast Notification -->
    @if($submitSuccess)
    <div
        x-data="{ show: true }"
        x-show="show"
        x-init="setTimeout(() => show = false, 3000)"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed top-6 right-6 bg-green-500 text-white px-6 py-4 rounded-lg shadow-xl z-50 flex items-center gap-3"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        <div>
            <p class="font-semibold">Feedback Submitted!</p>
            <p class="text-sm text-green-100">Thank you for helping us improve.</p>
        </div>
    </div>
    @endif

    <!-- Feedback Modal -->
    @if($showModal)
    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 text-white rounded-t-lg">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold">Send Feedback</h2>
                    <button
                        wire:click="closeModal"
                        class="text-white hover:text-gray-200 transition-colors"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <p class="text-blue-100 text-sm mt-1">
                    Help us improve by sharing your thoughts, reporting bugs, or suggesting new features.
                </p>
            </div>

            <!-- Form -->
            <form wire:submit.prevent="submitFeedback" class="p-6 space-y-4">
                <!-- Type Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Feedback Type
                    </label>
                    <div class="grid grid-cols-2 gap-2">
                        <label class="relative flex items-center p-3 border-2 rounded-lg cursor-pointer transition-all {{ $type === 'bug' ? 'border-red-500 bg-red-50 dark:bg-red-900/20' : 'border-gray-200 dark:border-gray-700 hover:border-gray-300' }}">
                            <input
                                type="radio"
                                wire:model.live="type"
                                value="bug"
                                class="sr-only"
                            >
                            <div class="flex items-center gap-2">
                                <div class="text-2xl">🐛</div>
                                <div>
                                    <div class="font-medium text-sm text-gray-900 dark:text-gray-100">Bug Report</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Something isn't working</div>
                                </div>
                            </div>
                        </label>

                        <label class="relative flex items-center p-3 border-2 rounded-lg cursor-pointer transition-all {{ $type === 'feature' ? 'border-green-500 bg-green-50 dark:bg-green-900/20' : 'border-gray-200 dark:border-gray-700 hover:border-gray-300' }}">
                            <input
                                type="radio"
                                wire:model.live="type"
                                value="feature"
                                class="sr-only"
                            >
                            <div class="flex items-center gap-2">
                                <div class="text-2xl">✨</div>
                                <div>
                                    <div class="font-medium text-sm text-gray-900 dark:text-gray-100">Feature Request</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Suggest new features</div>
                                </div>
                            </div>
                        </label>

                        <label class="relative flex items-center p-3 border-2 rounded-lg cursor-pointer transition-all {{ $type === 'improvement' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : 'border-gray-200 dark:border-gray-700 hover:border-gray-300' }}">
                            <input
                                type="radio"
                                wire:model.live="type"
                                value="improvement"
                                class="sr-only"
                            >
                            <div class="flex items-center gap-2">
                                <div class="text-2xl">💡</div>
                                <div>
                                    <div class="font-medium text-sm text-gray-900 dark:text-gray-100">Improvement</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Make it better</div>
                                </div>
                            </div>
                        </label>

                        <label class="relative flex items-center p-3 border-2 rounded-lg cursor-pointer transition-all {{ $type === 'other' ? 'border-purple-500 bg-purple-50 dark:bg-purple-900/20' : 'border-gray-200 dark:border-gray-700 hover:border-gray-300' }}">
                            <input
                                type="radio"
                                wire:model.live="type"
                                value="other"
                                class="sr-only"
                            >
                            <div class="flex items-center gap-2">
                                <div class="text-2xl">💬</div>
                                <div>
                                    <div class="font-medium text-sm text-gray-900 dark:text-gray-100">Other</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">General feedback</div>
                                </div>
                            </div>
                        </label>
                    </div>
                    @error('type')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Subject -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Subject <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        wire:model="subject"
                        placeholder="Brief summary of your feedback"
                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        maxlength="200"
                    >
                    @error('subject')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ strlen($subject) }}/200 characters</p>
                </div>

                <!-- Message -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Message <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        wire:model="message"
                        rows="5"
                        placeholder="Describe your feedback in detail. Include steps to reproduce if reporting a bug."
                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        maxlength="2000"
                    ></textarea>
                    @error('message')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ strlen($message) }}/2000 characters</p>
                </div>

                <!-- Info Box -->
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3">
                    <p class="text-sm text-blue-800 dark:text-blue-200">
                        <strong>Note:</strong> Your feedback will be reviewed by our team. We appreciate your help in making this platform better!
                    </p>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button
                        type="button"
                        wire:click="closeModal"
                        class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 font-medium transition-colors"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors flex items-center gap-2"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Submit Feedback
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
