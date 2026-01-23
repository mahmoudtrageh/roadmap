<div>
    @if($items && count($items) > 0)
    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 mb-4">
        <!-- Component: {{ get_class($this) }} | ID: {{ $this->getId() }} -->

        <!-- Checklist Header -->
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
                <h4 class="text-base font-semibold text-gray-800 dark:text-gray-200">Quick Start Checklist</h4>
            </div>

            <!-- Progress Badge -->
            <div class="flex items-center gap-2">
                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">
                    {{ count($checkedItems) }}/{{ count($items) }}
                </span>
                <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                    {{ $completionPercentage === 100 ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' :
                       ($completionPercentage >= 50 ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' :
                       'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300') }}">
                    {{ $completionPercentage }}%
                </span>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mb-4">
            <div class="h-2 rounded-full transition-all duration-300
                {{ $completionPercentage === 100 ? 'bg-green-500' : 'bg-blue-500' }}"
                style="width: {{ $completionPercentage }}%">
            </div>
        </div>

        <!-- Checklist Description -->
        @if($description)
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ $description }}</p>
        @endif

        <!-- Checklist Items -->
        <div class="space-y-2">
            @foreach($items as $index => $item)
            <button
                type="button"
                @click="$wire.toggle({{ $index }})"
                @disabled($isLocked)
                class="w-full flex items-start gap-3 p-2 rounded hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-left
                    {{ $isLocked ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer' }}">

                <!-- Checkbox -->
                <div class="flex-shrink-0 mt-0.5">
                    @if(in_array($index, $checkedItems))
                    <div class="w-5 h-5 bg-green-500 border-2 border-green-500 rounded flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    @else
                    <div class="w-5 h-5 border-2 border-gray-300 dark:border-gray-600 rounded
                        {{ !$isLocked ? 'hover:border-blue-400' : '' }}">
                    </div>
                    @endif
                </div>

                <!-- Item Text -->
                <div class="flex-1">
                    <p class="text-sm {{ in_array($index, $checkedItems) ? 'line-through text-gray-500 dark:text-gray-500' : 'text-gray-700 dark:text-gray-300' }}">
                        {{ $item }}
                    </p>
                </div>
            </button>
            @endforeach
        </div>

        <!-- Completion Message -->
        @if($completionPercentage === 100)
        <div class="mt-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-3">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-sm font-medium text-green-800 dark:text-green-300">
                    Awesome! You've completed all checklist items. Ready to mark this task as complete?
                </p>
            </div>
        </div>
        @endif
    </div>
    @endif
</div>
