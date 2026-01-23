<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

        <!-- Roadmap Header -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h1 class="text-3xl font-bold text-gray-900">{{ $roadmap->title }}</h1>
                            @if($roadmap->is_featured)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    ⭐ Featured
                                </span>
                            @endif
                        </div>

                        <p class="text-gray-600 mb-4">{{ $roadmap->description }}</p>

                        <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="font-medium">{{ $roadmap->duration_days }} days</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <span class="font-medium">{{ $roadmap->tasks->count() }} tasks</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($roadmap->difficulty_level === 'beginner') bg-green-100 text-green-800
                                    @elseif($roadmap->difficulty_level === 'intermediate') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($roadmap->difficulty_level) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="ml-6">
                        @if($isEnrolled)
                            <div class="text-center">
                                <span class="block mb-2 text-green-600 font-semibold">✓ Enrolled</span>
                                <a href="{{ route('student.tasks') }}" class="block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">
                                    Go to My Tasks
                                </a>
                            </div>
                        @elseif($isLocked)
                            <div class="text-center">
                                <button disabled class="bg-gray-300 text-gray-500 px-6 py-3 rounded-lg font-medium cursor-not-allowed" title="{{ $lockReason }}">
                                    🔒 Locked
                                </button>
                                <p class="text-xs text-gray-500 mt-2">{{ $lockReason }}</p>
                            </div>
                        @else
                            <button wire:click="enroll" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium">
                                Enroll Now
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Roadmap Curriculum -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Curriculum Overview</h2>

                <div class="space-y-6">
                    @foreach($tasksByDay as $day => $tasks)
                        <div class="border border-gray-200 rounded-lg overflow-hidden">
                            <!-- Day Header -->
                            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-900">Day {{ $day }}</h3>
                                    <span class="text-sm text-gray-600">{{ $tasks->count() }} tasks</span>
                                </div>
                            </div>

                            <!-- Tasks List -->
                            <div class="divide-y divide-gray-200">
                                @foreach($tasks as $task)
                                    <div class="px-6 py-4 hover:bg-gray-50 transition">
                                        <div class="flex items-start gap-4">
                                            <!-- Task Type Icon -->
                                            <div class="flex-shrink-0 mt-1">
                                                @if($task->task_type === 'reading')
                                                    <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                        </svg>
                                                    </div>
                                                @elseif($task->task_type === 'video')
                                                    <div class="w-8 h-8 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                        </svg>
                                                    </div>
                                                @elseif($task->task_type === 'exercise')
                                                    <div class="w-8 h-8 bg-green-100 text-green-600 rounded-full flex items-center justify-center">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                                        </svg>
                                                    </div>
                                                @elseif($task->task_type === 'project')
                                                    <div class="w-8 h-8 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                                        </svg>
                                                    </div>
                                                @else
                                                    <div class="w-8 h-8 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Task Details -->
                                            <div class="flex-1">
                                                <div class="flex items-start justify-between">
                                                    <div>
                                                        <h4 class="font-medium text-gray-900">{{ $task->title }}</h4>
                                                        <p class="text-sm text-gray-600 mt-1">{{ $task->description }}</p>

                                                        <div class="flex items-center gap-4 mt-2 text-xs text-gray-500">
                                                            <span class="flex items-center gap-1">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                </svg>
                                                                {{ $task->estimated_time_minutes }} min
                                                            </span>
                                                            <span class="px-2 py-0.5 bg-gray-100 text-gray-700 rounded">
                                                                {{ $task->category }}
                                                            </span>
                                                            <span class="px-2 py-0.5 bg-indigo-100 text-indigo-700 rounded capitalize">
                                                                {{ str_replace('_', ' ', $task->task_type) }}
                                                            </span>
                                                            @if($task->has_code_submission)
                                                                <span class="text-green-600 font-medium">💻 Code Practice</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Enroll CTA at bottom -->
                @if(!$isEnrolled)
                    <div class="mt-8 text-center py-8 border-t border-gray-200">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Ready to Start?</h3>
                        <p class="text-gray-600 mb-4">Enroll now and begin your learning journey!</p>
                        @if($isLocked)
                            <button disabled class="bg-gray-300 text-gray-500 px-8 py-3 rounded-lg font-medium text-lg cursor-not-allowed" title="{{ $lockReason }}">
                                🔒 Locked
                            </button>
                            <p class="text-sm text-gray-500 mt-2">{{ $lockReason }}</p>
                        @else
                            <button wire:click="enroll" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-medium text-lg">
                                Enroll in This Roadmap
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
