<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
        @endif

        @if($activeEnrollment)
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <!-- Header -->
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">{{ $activeEnrollment->roadmap->title }}</h2>
                    <p class="text-gray-600 mt-1">Day {{ $currentDay }} of {{ $activeEnrollment->roadmap->duration_days }}</p>
                </div>

                <!-- Day Navigation -->
                <div class="flex items-center gap-2 mb-6 overflow-x-auto pb-2">
                    @for($day = 1; $day <= $activeEnrollment->roadmap->duration_days; $day++)
                    @php
                        $isAccessible = $accessibleDays[$day] ?? false;
                        $isCompleted = $completedDays[$day] ?? false;
                    @endphp

                    @if($isAccessible)
                        @if($isCompleted)
                            <button
                                wire:click="changeDay({{ $day }})"
                                class="px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap
                                    {{ $day === $currentDay
                                        ? 'bg-green-600 text-white'
                                        : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                                ✓ Day {{ $day }}
                            </button>
                        @else
                            <button
                                wire:click="changeDay({{ $day }})"
                                class="px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap
                                    {{ $day === $currentDay
                                        ? 'bg-blue-600 text-white'
                                        : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                Day {{ $day }}
                            </button>
                        @endif
                    @else
                        <button
                            disabled
                            title="Complete all tasks in Day {{ $day - 1 }} first"
                            class="px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap bg-gray-200 text-gray-400 cursor-not-allowed">
                            🔒 Day {{ $day }}
                        </button>
                    @endif
                    @endfor
                </div>

                <!-- Tasks List -->
                @if(count($tasks) > 0)
                <div class="space-y-4">
                    @foreach($tasks as $task)
                    <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow
                        {{ $task['status'] === 'completed' ? 'bg-green-50 border-green-200' : '' }}
                        {{ $task['status'] === 'in_progress' ? 'bg-blue-50 border-blue-200' : '' }}
                        {{ $task['status'] === 'skipped' ? 'bg-gray-100 border-gray-300' : '' }}
                        {{ $task['is_locked'] ? 'opacity-60 bg-gray-50' : '' }}">

                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <!-- Task Header -->
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $task['title'] }}</h3>

                                    <!-- Status Badge -->
                                    @if($task['status'] === 'completed')
                                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                        ✓ Completed
                                    </span>
                                    @elseif($task['status'] === 'in_progress')
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                        ⏳ In Progress
                                    </span>
                                    @elseif($task['status'] === 'skipped')
                                    <span class="bg-gray-100 text-gray-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                        ⏭ Skipped
                                    </span>
                                    @endif
                                </div>

                                <!-- Task Description -->
                                <p class="text-gray-600 mb-3">{{ $task['description'] }}</p>

                                <!-- Learning Objectives -->
                                @if(!empty($task['learning_objectives']))
                                <div class="mb-3">
                                    <p class="text-sm font-semibold text-gray-700 mb-1 flex items-center gap-1">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Learning Objectives:
                                    </p>
                                    <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                                        @foreach($task['learning_objectives'] as $objective)
                                        <li>{{ $objective }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                <!-- Prerequisites (if any) -->
                                @if(!empty($task['missing_prerequisites']))
                                <div class="mb-3 bg-red-50 border border-red-200 rounded-lg p-3">
                                    <p class="text-sm font-semibold text-red-800 mb-2 flex items-center gap-1">
                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                        🔒 Prerequisites Required:
                                    </p>
                                    <p class="text-xs text-red-700 mb-2">You must complete these tasks first:</p>
                                    <ul class="space-y-1">
                                        @foreach($task['missing_prerequisites'] as $prereq)
                                        <li class="text-sm text-red-900 flex items-center gap-2">
                                            <span class="font-medium">→ Day {{ $prereq['day_number'] }}:</span>
                                            <span>{{ $prereq['title'] }}</span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @elseif(!empty($task['prerequisites']) && $task['prerequisites_met'])
                                <div class="mb-3 bg-green-50 border border-green-200 rounded-lg p-3">
                                    <p class="text-sm font-semibold text-green-800 mb-1 flex items-center gap-1">
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                        ✓ All Prerequisites Complete
                                    </p>
                                </div>
                                @endif

                                <!-- Recommended Tasks (if any) -->
                                @if(!empty($task['recommended_tasks_info']))
                                <div class="mb-3 bg-blue-50 border border-blue-200 rounded-lg p-3">
                                    <p class="text-sm font-semibold text-blue-800 mb-2 flex items-center gap-1">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        💡 Recommended to Complete First:
                                    </p>
                                    <p class="text-xs text-blue-700 mb-2">These tasks will help you succeed (not required):</p>
                                    <ul class="space-y-1">
                                        @foreach($task['recommended_tasks_info'] as $rec)
                                        <li class="text-sm flex items-center gap-2
                                            {{ $rec['is_completed'] ? 'text-green-700' : 'text-blue-900' }}">
                                            @if($rec['is_completed'])
                                            <span class="text-green-600">✓</span>
                                            @else
                                            <span class="text-blue-600">○</span>
                                            @endif
                                            <span class="font-medium">Day {{ $rec['day_number'] }}:</span>
                                            <span>{{ $rec['title'] }}</span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                <!-- Success Criteria -->
                                @if(!empty($task['success_criteria']) && !$task['is_locked'])
                                <div class="mb-3">
                                    <p class="text-sm font-semibold text-gray-700 mb-1 flex items-center gap-1">
                                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                        </svg>
                                        Success Criteria:
                                    </p>
                                    <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                                        @foreach($task['success_criteria'] as $criteria)
                                        <li>{{ $criteria }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif


                                <!-- Task Meta Information -->
                                <div class="flex flex-wrap gap-4 text-sm text-gray-500 mb-3">
                                    <div class="flex items-center gap-1">
                                        <span class="font-medium">Type:</span>
                                        <span class="bg-purple-100 text-purple-800 px-2 py-0.5 rounded text-xs">
                                            {{ ucfirst($task['task_type']) }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <span class="font-medium">Category:</span>
                                        <span class="bg-indigo-100 text-indigo-800 px-2 py-0.5 rounded text-xs">
                                            {{ ucfirst($task['category']) }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="font-medium">Estimated:</span>
                                        <span class="{{ $task['estimated_time_minutes'] > 120 ? 'text-orange-600 font-semibold' : '' }}">
                                            {{ $task['estimated_time_minutes'] }} min
                                        </span>
                                        @if($task['estimated_time_minutes'] > 120)
                                        <span class="text-xs text-orange-600">(Long task)</span>
                                        @endif
                                    </div>
                                    @if(isset($task['actual_avg_time_minutes']) && $task['actual_avg_time_minutes'] > 0)
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <span class="font-medium">Others completed in:</span>
                                        <span class="text-blue-600 font-semibold">{{ $task['actual_avg_time_minutes'] }} min avg</span>
                                        @php
                                            $diff = $task['actual_avg_time_minutes'] - $task['estimated_time_minutes'];
                                            $diffPercent = $task['estimated_time_minutes'] > 0 ? round(($diff / $task['estimated_time_minutes']) * 100) : 0;
                                        @endphp
                                        @if(abs($diffPercent) > 20)
                                        <span class="text-xs {{ $diff > 0 ? 'text-orange-600' : 'text-green-600' }}">
                                            ({{ $diff > 0 ? '+' : '' }}{{ $diffPercent }}%)
                                        </span>
                                        @endif
                                    </div>
                                    @endif
                                    @if($task['time_spent_minutes'])
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="font-medium">Your time:</span>
                                        <span class="text-green-600 font-semibold">{{ $task['time_spent_minutes'] }} min</span>
                                    </div>
                                    @endif
                                </div>

                                <!-- Task Quality Ratings -->
                                @if($task['has_quality_rating'])
                                <div class="mb-3 bg-gradient-to-r from-yellow-50 to-amber-50 dark:from-yellow-900/20 dark:to-amber-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-3">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-2">
                                                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                                <h5 class="text-sm font-semibold text-gray-800 dark:text-gray-200">Task Quality Ratings</h5>
                                            </div>

                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                <!-- Average Rating from All Students -->
                                                @if($task['avg_quality_rating'])
                                                <div class="flex items-center gap-2">
                                                    <div class="flex items-center gap-1">
                                                        <span class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $task['avg_quality_rating'] }}</span>
                                                        <span class="text-sm text-gray-600 dark:text-gray-400">/10</span>
                                                    </div>
                                                    <div class="flex flex-col">
                                                        <div class="flex items-center gap-1">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                @if($i <= round($task['avg_quality_rating'] / 2))
                                                                    <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                                    </svg>
                                                                @else
                                                                    <svg class="w-4 h-4 text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                                    </svg>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                        <span class="text-xs text-gray-600 dark:text-gray-400">
                                                            Based on {{ $task['rating_count'] }} {{ $task['rating_count'] === 1 ? 'rating' : 'ratings' }}
                                                        </span>
                                                    </div>
                                                </div>
                                                @else
                                                <div class="flex items-center gap-2 text-gray-500 dark:text-gray-400">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    <span class="text-sm">No ratings yet</span>
                                                </div>
                                                @endif

                                                <!-- User's Own Rating -->
                                                @if($task['quality_rating'])
                                                <div class="flex items-center gap-2 pl-3 border-l-2 border-blue-300 dark:border-blue-700">
                                                    <div class="flex items-center gap-1">
                                                        <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $task['quality_rating'] }}</span>
                                                        <span class="text-sm text-gray-600 dark:text-gray-400">/10</span>
                                                    </div>
                                                    <div class="flex flex-col">
                                                        <div class="flex items-center gap-1">
                                                            @for($i = 1; $i <= 5; $i++)
                                                                @if($i <= round($task['quality_rating'] / 2))
                                                                    <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                                    </svg>
                                                                @else
                                                                    <svg class="w-4 h-4 text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                                    </svg>
                                                                @endif
                                                            @endfor
                                                        </div>
                                                        <span class="text-xs text-gray-600 dark:text-gray-400">Your rating</span>
                                                    </div>
                                                </div>
                                                @elseif($task['status'] === 'completed')
                                                <div class="flex items-center gap-2 pl-3 border-l-2 border-gray-300 dark:border-gray-600 text-gray-500 dark:text-gray-400">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                    <span class="text-sm">You haven't rated this task yet</span>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- Code Submission Required Badge -->
                                @if($task['has_code_submission'])
                                <div class="mb-3">
                                    @if($task['code_submitted'])
                                    <div class="inline-flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 px-3 py-1.5 rounded-lg text-sm font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Code Submitted
                                    </div>
                                    @else
                                    <div class="inline-flex items-center gap-2 bg-orange-50 border border-orange-200 text-orange-700 px-3 py-1.5 rounded-lg text-sm font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                        </svg>
                                        Code Submission Required - Use Submit Button
                                    </div>
                                    @endif
                                </div>
                                @endif

                                <!-- Resources -->
                                @php
                                    // Get new structured resources with language support
                                    $newResources = $task['resources'] ?? [];
                                    $legacyResources = $task['resources_links'] ?? [];

                                    // Group new resources by language
                                    $englishResources = [];
                                    $arabicResources = [];

                                    if (is_array($newResources) && count($newResources) > 0) {
                                        foreach ($newResources as $resource) {
                                            if (isset($resource['language'])) {
                                                if ($resource['language'] === 'ar') {
                                                    $arabicResources[] = $resource;
                                                } else {
                                                    $englishResources[] = $resource;
                                                }
                                            }
                                        }
                                    }

                                    $hasAnyResources = count($englishResources) > 0 || count($arabicResources) > 0 || count($legacyResources) > 0;
                                @endphp

                                @if($hasAnyResources)
                                <div class="mb-3">
                                    <p class="text-sm font-medium text-gray-700 mb-3 flex items-center gap-2">
                                        📚 Learning Resources
                                        @if(count($englishResources) > 0 && count($arabicResources) > 0)
                                        <span class="text-xs text-gray-500">({{ count($englishResources) }} English, {{ count($arabicResources) }} Arabic)</span>
                                        @endif
                                    </p>

                                    <!-- English Resources Section -->
                                    @if(count($englishResources) > 0)
                                    <div class="mb-4">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="px-2 py-0.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-semibold rounded">
                                                🇬🇧 English
                                            </span>
                                            <span class="text-xs text-gray-500">{{ count($englishResources) }} resource(s)</span>
                                        </div>
                                        <div class="space-y-2 pl-3 border-l-2 border-blue-200 dark:border-blue-800">
                                            @foreach($englishResources as $index => $resource)
                                            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-3 hover:shadow-sm transition-shadow">
                                                <a href="{{ $resource['url'] }}" target="_blank" class="flex items-start gap-2 group">
                                                    <span class="text-lg flex-shrink-0">
                                                        @if($resource['type'] === 'youtube')
                                                            🎥
                                                        @elseif($resource['type'] === 'video')
                                                            📹
                                                        @elseif($resource['type'] === 'documentation')
                                                            📘
                                                        @elseif($resource['type'] === 'tutorial')
                                                            📝
                                                        @elseif($resource['type'] === 'course')
                                                            🎓
                                                        @elseif($resource['type'] === 'blog')
                                                            ✍️
                                                        @else
                                                            📖
                                                        @endif
                                                    </span>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-blue-600 dark:text-blue-400 group-hover:text-blue-700 dark:group-hover:text-blue-300 group-hover:underline">
                                                            {{ $resource['title'] ?: 'Learning Resource' }}
                                                        </p>
                                                        @if(!empty($resource['title']))
                                                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate mt-0.5">
                                                            {{ $resource['url'] }}
                                                        </p>
                                                        @endif
                                                    </div>
                                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Arabic Resources Section -->
                                    @if(count($arabicResources) > 0)
                                    <div class="mb-4">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="px-2 py-0.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-semibold rounded">
                                                🇸🇦 العربية
                                            </span>
                                            <span class="text-xs text-gray-500">{{ count($arabicResources) }} مصدر</span>
                                        </div>
                                        <div class="space-y-2 pl-3 border-l-2 border-green-200 dark:border-green-800">
                                            @foreach($arabicResources as $index => $resource)
                                            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-3 hover:shadow-sm transition-shadow">
                                                <a href="{{ $resource['url'] }}" target="_blank" class="flex items-start gap-2 group" dir="rtl">
                                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                    </svg>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-green-600 dark:text-green-400 group-hover:text-green-700 dark:group-hover:text-green-300 group-hover:underline">
                                                            {{ $resource['title'] ?: 'مصدر تعليمي' }}
                                                        </p>
                                                        @if(!empty($resource['title']))
                                                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate mt-0.5" dir="ltr">
                                                            {{ $resource['url'] }}
                                                        </p>
                                                        @endif
                                                    </div>
                                                    <span class="text-lg flex-shrink-0">
                                                        @if($resource['type'] === 'youtube')
                                                            🎥
                                                        @elseif($resource['type'] === 'video')
                                                            📹
                                                        @elseif($resource['type'] === 'documentation')
                                                            📘
                                                        @elseif($resource['type'] === 'tutorial')
                                                            📝
                                                        @elseif($resource['type'] === 'course')
                                                            🎓
                                                        @elseif($resource['type'] === 'blog')
                                                            ✍️
                                                        @else
                                                            📖
                                                        @endif
                                                    </span>
                                                </a>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Legacy Resources (Old Format) -->
                                    @if(is_array($legacyResources) && count($legacyResources) > 0)
                                    <div class="flex flex-col gap-1.5">
                                        @php
                                            $sortedResources = collect($task['resources_links'])->map(function($resource) {
                                                $url = is_array($resource) ? ($resource['url'] ?? '') : $resource;
                                                $title = is_array($resource) ? ($resource['title'] ?? null) : null;

                                                // Auto-generate title from URL if not provided
                                                if (!$title) {
                                                    if (strpos($url, 'developer.mozilla.org') !== false || strpos($url, 'mdn.') !== false) {
                                                        $title = 'MDN Documentation';
                                                    } elseif (strpos($url, 'w3schools.com') !== false) {
                                                        $title = 'W3Schools Tutorial';
                                                    } elseif (strpos($url, 'javascript.info') !== false) {
                                                        $title = 'JavaScript.info';
                                                    } elseif (strpos($url, 'youtube.com') !== false || strpos($url, 'youtu.be') !== false) {
                                                        $title = 'Video Tutorial';
                                                    } elseif (strpos($url, 'github.com') !== false) {
                                                        $title = 'GitHub Repository';
                                                    } elseif (strpos($url, 'reactjs.org') !== false || strpos($url, 'react.dev') !== false) {
                                                        $title = 'React Official Docs';
                                                    } elseif (strpos($url, 'laravel.com') !== false) {
                                                        $title = 'Laravel Documentation';
                                                    } elseif (strpos($url, 'tailwindcss.com') !== false) {
                                                        $title = 'Tailwind CSS Docs';
                                                    } elseif (strpos($url, 'css-tricks.com') !== false) {
                                                        $title = 'CSS-Tricks Guide';
                                                    } else {
                                                        // Extract domain name as fallback
                                                        $domain = parse_url($url, PHP_URL_HOST);
                                                        $title = ucfirst(str_replace(['www.', '.com', '.org', '.io'], '', $domain ?? 'Resource'));
                                                    }
                                                }

                                                // Determine type and icon
                                                $type = 'article';
                                                $icon = '📖';
                                                $color = 'text-blue-600 hover:text-blue-800';

                                                if (strpos($url, 'youtube.com') !== false || strpos($url, 'youtu.be') !== false) {
                                                    $type = 'video';
                                                    $icon = '🎥';
                                                    $color = 'text-red-600 hover:text-red-800';
                                                } elseif (strpos($url, 'github.com') !== false) {
                                                    $type = 'github';
                                                    $icon = '💻';
                                                    $color = 'text-gray-700 hover:text-gray-900';
                                                } elseif (strpos($url, 'codepen.io') !== false || strpos($url, 'jsfiddle') !== false || strpos($url, 'codesandbox') !== false) {
                                                    $type = 'demo';
                                                    $icon = '🔧';
                                                    $color = 'text-green-600 hover:text-green-800';
                                                }

                                                return [
                                                    'url' => $url,
                                                    'title' => $title,
                                                    'type' => $type,
                                                    'icon' => $icon,
                                                    'color' => $color,
                                                    'priority' => $type === 'video' ? 1 : ($type === 'demo' ? 2 : ($type === 'github' ? 3 : 4))
                                                ];
                                            })->sortBy('priority');
                                        @endphp

                                        @foreach($sortedResources as $index => $resource)
                                        @php
                                            // Get rating data for this resource
                                            $resourceRatings = \App\Models\ResourceRating::where('task_id', $task['id'])
                                                ->where('resource_index', $index)
                                                ->get();
                                            $avgRating = $resourceRatings->count() > 0 ? round($resourceRatings->avg('rating'), 1) : null;
                                            $ratingCount = $resourceRatings->count();
                                            $isHighlyRated = $avgRating >= 4.0 && $ratingCount >= 3;
                                            $isPoorlyRated = $avgRating < 3.0 && $ratingCount >= 3;
                                        @endphp
                                        <div class="mb-3 bg-gray-50 dark:bg-gray-900 border {{ $isHighlyRated ? 'border-yellow-400 dark:border-yellow-500' : 'border-gray-200 dark:border-gray-700' }} rounded-lg p-3 {{ $isHighlyRated ? 'ring-2 ring-yellow-200 dark:ring-yellow-800' : '' }}">
                                            <div class="flex items-start justify-between gap-2 mb-2">
                                                <div class="flex-1">
                                                    <a href="{{ $resource['url'] }}"
                                                       target="_blank"
                                                       class="inline-flex items-center text-sm {{ $resource['color'] }} hover:underline font-medium">
                                                        <span class="mr-1.5">{{ $resource['icon'] }}</span>
                                                        <span>{{ $resource['title'] }}</span>
                                                        <svg class="w-3 h-3 ml-1 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                        </svg>
                                                    </a>
                                                    @if($isHighlyRated)
                                                    <div class="mt-1">
                                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-gradient-to-r from-yellow-100 to-amber-100 dark:from-yellow-900/40 dark:to-amber-900/40 text-yellow-800 dark:text-yellow-300 text-xs font-semibold rounded-full border border-yellow-300 dark:border-yellow-700">
                                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                            </svg>
                                                            Highly Rated
                                                        </span>
                                                    </div>
                                                    @endif
                                                </div>
                                                @if($avgRating)
                                                <div class="flex items-center gap-1 text-sm">
                                                    <span class="font-semibold {{ $isHighlyRated ? 'text-yellow-600 dark:text-yellow-400' : ($isPoorlyRated ? 'text-orange-600 dark:text-orange-400' : 'text-gray-700 dark:text-gray-300') }}">
                                                        {{ $avgRating }}
                                                    </span>
                                                    <svg class="w-4 h-4 {{ $isHighlyRated ? 'text-yellow-500' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">({{ $ratingCount }})</span>
                                                </div>
                                                @endif
                                            </div>

                                            @php
                                                $resType = is_array($resource) ? ($resource['type'] ?? null) : null;
                                                $resDifficulty = is_array($resource) ? ($resource['difficulty'] ?? null) : null;
                                                $resTime = is_array($resource) ? ($resource['estimated_time'] ?? null) : null;
                                                $resFree = is_array($resource) ? ($resource['is_free'] ?? true) : true;
                                            @endphp

                                            @if($resType || $resDifficulty || $resTime)
                                            <div class="flex flex-wrap items-center gap-2 mb-2 text-xs">
                                                @if($resType)
                                                <span class="px-2 py-0.5 rounded bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300">
                                                    {{ ucfirst($resType) }}
                                                </span>
                                                @endif

                                                @if($resDifficulty)
                                                <span class="px-2 py-0.5 rounded
                                                    {{ $resDifficulty === 'beginner' ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : '' }}
                                                    {{ $resDifficulty === 'intermediate' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300' : '' }}
                                                    {{ $resDifficulty === 'advanced' ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' : '' }}">
                                                    {{ ucfirst($resDifficulty) }}
                                                </span>
                                                @endif

                                                @if($resTime)
                                                <span class="px-2 py-0.5 rounded bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300">
                                                    ~{{ $resTime }} min
                                                </span>
                                                @endif

                                                @if($resFree)
                                                <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-700 dark:bg-emerald-900 dark:text-emerald-300">
                                                    Free
                                                </span>
                                                @endif
                                            </div>
                                            @endif

                                            @livewire('student.resource-review', ['taskId' => $task['id'], 'resourceUrl' => $resource['url'], 'isLocked' => $task['is_locked']], key('resource-review-' . $task['id'] . '-' . $index))
                                        </div>
                                        @endforeach

                                        @php
                                            // Check if any resources are poorly rated
                                            $hasPoorlyRatedResources = false;
                                            $taskResources = $task['resources_links'] ?? [];
                                            $resourceCount = count($taskResources);
                                            foreach($taskResources as $idx => $res) {
                                                $ratings = \App\Models\ResourceRating::where('task_id', $task['id'])
                                                    ->where('resource_index', $idx)
                                                    ->get();
                                                if ($ratings->count() >= 3 && $ratings->avg('rating') < 3.0) {
                                                    $hasPoorlyRatedResources = true;
                                                    break;
                                                }
                                            }
                                        @endphp

                                        @if($hasPoorlyRatedResources || $resourceCount < 2)
                                        <div class="mt-3 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                                            <div class="flex items-start gap-2">
                                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <div class="flex-1">
                                                    <p class="text-sm font-semibold text-blue-900 dark:text-blue-300 mb-1">
                                                        {{ $hasPoorlyRatedResources ? 'Looking for better resources?' : 'Need more learning materials?' }}
                                                    </p>
                                                    <p class="text-xs text-blue-800 dark:text-blue-200">
                                                        {{ $hasPoorlyRatedResources
                                                            ? 'Some resources have lower ratings. Feel free to search for alternatives or suggest better ones!'
                                                            : 'This task could benefit from more resources. Know a good tutorial? Let us know!' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    @endif
                                    <!-- End Legacy Resources -->

                                </div>
                                @endif
                                <!-- End All Resources -->

                                <!-- Ask Question -->
                                @if(!$task['is_locked'])
                                    <livewire:student.question-box
                                        :taskId="$task['id']"
                                        :enrollmentId="$activeEnrollment->id"
                                        :key="'question-box-' . $task['id']"
                                    />
                                @endif

                                <!-- Quick Tips -->
                                @if(!empty($task['quick_tips']) && !$task['is_locked'])
                                <div class="mb-3 bg-blue-50 border border-blue-200 rounded-lg p-3">
                                    <p class="text-sm font-semibold text-blue-800 mb-1 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                        </svg>
                                        Quick Tips:
                                    </p>
                                    <p class="text-sm text-blue-700">{{ $task['quick_tips'] }}</p>
                                </div>
                                @endif

                                <!-- Common Mistakes -->
                                @if(!empty($task['common_mistakes']) && !$task['is_locked'])
                                <div class="mb-3 bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                                    <p class="text-sm font-semibold text-yellow-800 mb-1 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                        Common Mistakes to Avoid:
                                    </p>
                                    <p class="text-sm text-yellow-700">{{ $task['common_mistakes'] }}</p>
                                </div>
                                @endif


                                <!-- Self Notes Display -->
                                @if($task['self_notes'])
                                <div class="bg-white border border-gray-200 rounded-lg p-3">
                                    <p class="text-sm font-medium text-gray-700 mb-1">Notes:</p>
                                    <p class="text-sm text-gray-600">{{ $task['self_notes'] }}</p>
                                </div>
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            <div class="ml-4 flex flex-col gap-2">
                                @if($task['is_locked'])
                                    <div class="text-center">
                                        <div class="bg-gray-300 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap">
                                            🔒 Locked
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Complete previous task</p>
                                    </div>
                                @else
                                    @if($task['has_code_submission'])
                                    <a
                                        href="{{ route('student.code-editor', ['taskId' => $task['id']]) }}"
                                        class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap text-center">
                                        💻 Submit
                                    </a>
                                    @endif

                                    @if($task['status'] === 'skipped')
                                    <button
                                        wire:click="completeTask({{ $task['id'] }})"
                                        @if($task['has_code_submission'] && !$task['code_submitted']) disabled @endif
                                        wire:loading.attr="disabled"
                                        wire:loading.class="opacity-50 cursor-not-allowed"
                                        class="bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap">
                                        <span wire:loading.remove wire:target="completeTask({{ $task['id'] }})">
                                            @if($task['has_code_submission'] && !$task['code_submitted'])
                                                Submit Code First
                                            @else
                                                Complete Now
                                            @endif
                                        </span>
                                        <span wire:loading wire:target="completeTask({{ $task['id'] }})">
                                            Loading...
                                        </span>
                                    </button>
                                    @elseif($task['status'] === 'completed')
                                    <button
                                        wire:click="completeTask({{ $task['id'] }})"
                                        wire:loading.attr="disabled"
                                        wire:loading.class="opacity-50 cursor-not-allowed"
                                        class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap">
                                        <span wire:loading.remove wire:target="completeTask({{ $task['id'] }})">
                                            Edit
                                        </span>
                                        <span wire:loading wire:target="completeTask({{ $task['id'] }})">
                                            Loading...
                                        </span>
                                    </button>
                                    @else
                                    <button
                                        wire:click="completeTask({{ $task['id'] }})"
                                        @if($task['has_code_submission'] && !$task['code_submitted']) disabled @endif
                                        wire:loading.attr="disabled"
                                        wire:loading.class="opacity-50 cursor-not-allowed"
                                        class="bg-green-600 hover:bg-green-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap">
                                        <span wire:loading.remove wire:target="completeTask({{ $task['id'] }})">
                                            @if($task['has_code_submission'] && !$task['code_submitted'])
                                                Submit Code First
                                            @else
                                                Complete
                                            @endif
                                        </span>
                                        <span wire:loading wire:target="completeTask({{ $task['id'] }})">
                                            Loading...
                                        </span>
                                    </button>
                                    @endif

                                    @if($task['status'] !== 'skipped' && $task['status'] !== 'completed')
                                    <button
                                        wire:click="skipTask({{ $task['id'] }})"
                                        wire:loading.attr="disabled"
                                        wire:loading.class="opacity-50 cursor-not-allowed"
                                        class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap">
                                        <span wire:loading.remove wire:target="skipTask({{ $task['id'] }})">
                                            Skip
                                        </span>
                                        <span wire:loading wire:target="skipTask({{ $task['id'] }})">
                                            Loading...
                                        </span>
                                    </button>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12">
                    <p class="text-gray-500 text-lg">No tasks scheduled for Day {{ $currentDay }}</p>
                </div>
                @endif
            </div>
        </div>
        @else
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-center">
                <p class="text-gray-600 text-lg mb-4">You don't have an active roadmap enrollment.</p>
                <a href="{{ route('student.roadmaps') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">
                    Browse Roadmaps
                </a>
            </div>
        </div>
        @endif
    </div>

    <!-- Completion Modal -->
    @if($showCompletionModal)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="closeCompletionModal">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-lg bg-white" wire:click.stop>
            <div class="mt-3">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    {{ $status === 'completed' ? 'Complete Task' : ($status === 'in_progress' ? 'Start Task' : 'Skip Task') }}
                </h3>

                <form wire:submit.prevent="updateTaskStatus">
                    <!-- Time Spent -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Time Spent (minutes) <span class="text-gray-400 text-xs">(optional)</span>
                        </label>
                        <input
                            type="number"
                            wire:model="timeSpentMinutes"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter time spent in minutes (optional)"
                            min="0">
                        @error('timeSpentMinutes')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Quality Rating (only for completed status) -->
                    @if($status === 'completed')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Quality Rating (1-10)
                        </label>
                        <div class="flex gap-2">
                            @for($i = 1; $i <= 10; $i++)
                            <button
                                type="button"
                                wire:click="$set('qualityRating', {{ $i }})"
                                class="w-10 h-10 rounded-lg border-2 font-semibold transition-colors
                                    {{ $qualityRating === $i
                                        ? 'bg-yellow-500 border-yellow-600 text-white'
                                        : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50' }}">
                                {{ $i }}
                            </button>
                            @endfor
                        </div>
                        @error('qualityRating')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    @endif

                    <!-- Self Notes -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Notes / Reflections
                        </label>
                        <textarea
                            wire:model="selfNotes"
                            rows="4"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Add your notes, reflections, or key learnings..."></textarea>
                        @error('selfNotes')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end gap-3 mt-6">
                        <button
                            type="button"
                            wire:click="closeCompletionModal"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg font-medium">
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
