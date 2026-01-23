<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Welcome Section for First-Time Users -->
        @if($overallProgress == 0 && $totalTasks == 0)
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-lg shadow-lg p-8 mb-6 text-white">
            <div class="flex items-start gap-6">
                <div class="text-6xl">👋</div>
                <div class="flex-1">
                    <h2 class="text-3xl font-bold mb-3">Welcome to Your Learning Journey!</h2>
                    <p class="text-blue-100 text-lg mb-4">
                        You're about to embark on an exciting path to mastering programming. Here's how to get started:
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                        <div class="bg-white/10 backdrop-blur rounded-lg p-4">
                            <div class="text-3xl mb-2">1️⃣</div>
                            <h3 class="font-semibold text-lg mb-1">Enroll in a Roadmap</h3>
                            <p class="text-blue-100 text-sm">Choose a learning path that matches your goals</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur rounded-lg p-4">
                            <div class="text-3xl mb-2">2️⃣</div>
                            <h3 class="font-semibold text-lg mb-1">Complete Tasks Daily</h3>
                            <p class="text-blue-100 text-sm">Work through tasks at your own pace, one step at a time</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur rounded-lg p-4">
                            <div class="text-3xl mb-2">3️⃣</div>
                            <h3 class="font-semibold text-lg mb-1">Track Your Progress</h3>
                            <p class="text-blue-100 text-sm">Watch your skills grow as you complete each task</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('student.roadmaps') }}" class="inline-block bg-white text-blue-600 hover:bg-blue-50 px-6 py-3 rounded-lg font-semibold shadow-md transition-colors">
                            Browse Roadmaps →
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Study Tips for New Users -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
                Study Tips for Success
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex gap-3">
                    <div class="text-2xl">⏰</div>
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-1">Set a Daily Schedule</h4>
                        <p class="text-sm text-gray-600">Dedicate specific time each day for learning. Consistency is key!</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="text-2xl">🎯</div>
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-1">Focus on Understanding</h4>
                        <p class="text-sm text-gray-600">Don't rush. Take time to truly understand each concept before moving on.</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="text-2xl">💪</div>
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-1">Practice, Practice, Practice</h4>
                        <p class="text-sm text-gray-600">Hands-on coding is essential. Type out examples instead of copying.</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="text-2xl">❓</div>
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-1">Use the Help Features</h4>
                        <p class="text-sm text-gray-600">Stuck? Use hints, ask questions, and review resources.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Platform Features Guide -->
        <div class="bg-gradient-to-br from-purple-50 to-indigo-50 dark:from-purple-900/20 dark:to-indigo-900/20 rounded-lg border border-purple-200 dark:border-purple-800 p-6 mb-6">
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                How to Use This Platform
            </h3>
            <div class="space-y-3">
                <div class="flex gap-3 items-start">
                    <div class="flex-shrink-0 w-8 h-8 bg-purple-600 text-white rounded-full flex items-center justify-center font-bold text-sm">✓</div>
                    <div>
                        <h4 class="font-semibold text-gray-800 dark:text-gray-200">Interactive Checklists</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Each task has a step-by-step checklist to guide you through completion</p>
                    </div>
                </div>
                <div class="flex gap-3 items-start">
                    <div class="flex-shrink-0 w-8 h-8 bg-purple-600 text-white rounded-full flex items-center justify-center font-bold text-sm">?</div>
                    <div>
                        <h4 class="font-semibold text-gray-800 dark:text-gray-200">Self-Assessment Quizzes</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Test your understanding with quizzes and get instant feedback</p>
                    </div>
                </div>
                <div class="flex gap-3 items-start">
                    <div class="flex-shrink-0 w-8 h-8 bg-purple-600 text-white rounded-full flex items-center justify-center font-bold text-sm">💻</div>
                    <div>
                        <h4 class="font-semibold text-gray-800 dark:text-gray-200">Code Examples</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Learn from progressive examples (beginner to advanced) with one-click copy</p>
                    </div>
                </div>
                <div class="flex gap-3 items-start">
                    <div class="flex-shrink-0 w-8 h-8 bg-purple-600 text-white rounded-full flex items-center justify-center font-bold text-sm">💡</div>
                    <div>
                        <h4 class="font-semibold text-gray-800 dark:text-gray-200">Progressive Hints</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">If you're stuck, reveal hints one at a time or ask a question for help</p>
                    </div>
                </div>
                <div class="flex gap-3 items-start">
                    <div class="flex-shrink-0 w-8 h-8 bg-purple-600 text-white rounded-full flex items-center justify-center font-bold text-sm">⭐</div>
                    <div>
                        <h4 class="font-semibold text-gray-800 dark:text-gray-200">Rate Resources</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Help others by rating learning resources - highly rated ones are highlighted</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Student Dashboard</h2>

                <!-- Quick Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <!-- Tasks Completed Today -->
                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm font-medium">Completed Today</p>
                                <p class="text-3xl font-bold mt-2">{{ $tasksCompletedToday }}</p>
                                <p class="text-green-100 text-xs mt-1">tasks</p>
                            </div>
                            <div class="text-4xl">✓</div>
                        </div>
                    </div>

                    <!-- Overall Progress -->
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-sm font-medium">Overall Progress</p>
                                <p class="text-3xl font-bold mt-2">{{ $overallProgress }}%</p>
                                <p class="text-purple-100 text-xs mt-1">completed</p>
                            </div>
                            <div class="text-4xl">📊</div>
                        </div>
                    </div>

                    <!-- Total Time Spent -->
                    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-orange-100 text-sm font-medium">Total Time Spent</p>
                                <p class="text-3xl font-bold mt-2">{{ floor($totalTimeSpent / 60) }}</p>
                                <p class="text-orange-100 text-xs mt-1">hours</p>
                            </div>
                            <div class="text-4xl">⏱️</div>
                        </div>
                    </div>
                </div>

                <!-- Active Enrollment -->
                @if($activeEnrollment && $activeEnrollment->roadmap)
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6 mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Active Roadmap</h3>
                    <div class="flex items-start justify-between">
                        <div>
                            <a href="{{ route('student.roadmap.view', ['roadmapId' => $activeEnrollment->roadmap->id]) }}" class="text-xl font-bold text-gray-900 dark:text-gray-100 hover:text-blue-600">
                                {{ $activeEnrollment->roadmap->title }}
                            </a>
                            <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $activeEnrollment->roadmap->description }}</p>
                            <div class="flex items-center gap-4 mt-4">
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    Day {{ $activeEnrollment->current_day ?? 1 }} of {{ $activeEnrollment->roadmap->duration_days }}
                                </span>
                                <span class="text-sm text-gray-600 dark:text-gray-400">•</span>
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $progressStats['completed_tasks'] ?? 0 }} / {{ $progressStats['total_tasks'] ?? 0 }} tasks completed
                                </span>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('student.roadmap.view', ['roadmapId' => $activeEnrollment->roadmap->id]) }}" class="bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 px-4 py-2 rounded-lg text-sm font-medium">
                                View Roadmap
                            </a>
                            <a href="{{ route('student.tasks') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                View Tasks
                            </a>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mt-4">
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $overallProgress }}%"></div>
                        </div>
                    </div>

                    <!-- What to Expect - Show for early progress (< 10%) -->
                    @if($overallProgress < 10 && $overallProgress > 0)
                    <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                        <h4 class="font-semibold text-blue-900 dark:text-blue-300 mb-2 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            What to Expect on This Journey
                        </h4>
                        <ul class="space-y-2 text-sm text-blue-800 dark:text-blue-200">
                            <li class="flex items-start gap-2">
                                <span class="text-blue-600">•</span>
                                <span><strong>Sequential Learning:</strong> Tasks unlock one at a time to ensure you build on solid foundations</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-blue-600">•</span>
                                <span><strong>Time Estimates:</strong> Each task shows estimated time, but learn at your own pace</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-blue-600">•</span>
                                <span><strong>Multiple Resources:</strong> Use different learning materials to find what works best for you</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-blue-600">•</span>
                                <span><strong>It's Okay to Struggle:</strong> Challenges mean you're learning! Use hints and ask questions when stuck</span>
                            </li>
                        </ul>
                    </div>
                    @endif
                </div>

                <!-- Today's Focus & Recommended Next Step -->
                @php
                    // Get next task to work on
                    $nextTask = \App\Models\Task::where('roadmap_id', $activeEnrollment->roadmap->id)
                        ->whereDoesntHave('taskCompletions', function($q) use ($activeEnrollment) {
                            $q->where('student_id', auth()->id())
                              ->where('enrollment_id', $activeEnrollment->id)
                              ->where('status', 'completed');
                        })
                        ->orderBy('day_number')
                        ->orderBy('order')
                        ->first();

                    // Get tasks started but not completed (in progress)
                    $inProgressTasks = \App\Models\Task::where('roadmap_id', $activeEnrollment->roadmap->id)
                        ->whereHas('taskCompletions', function($q) use ($activeEnrollment) {
                            $q->where('student_id', auth()->id())
                              ->where('enrollment_id', $activeEnrollment->id)
                              ->where('status', 'in_progress');
                        })
                        ->orderBy('day_number')
                        ->orderBy('order')
                        ->limit(3)
                        ->get();
                @endphp

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Today's Focus -->
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Today's Focus
                        </h3>

                        @if($nextTask)
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
                            <p class="text-xs text-blue-600 dark:text-blue-400 font-semibold mb-2">RECOMMENDED NEXT STEP</p>
                            <h4 class="font-bold text-gray-900 dark:text-gray-100 mb-2">{{ $nextTask->title }}</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 line-clamp-2">{{ $nextTask->description }}</p>
                            <div class="flex items-center gap-3 text-xs text-gray-600 dark:text-gray-400 mb-3">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    ~{{ $nextTask->estimated_time_minutes }} min
                                </span>
                                <span>•</span>
                                <span class="px-2 py-0.5 rounded bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300">
                                    {{ ucfirst($nextTask->task_type) }}
                                </span>
                            </div>
                            <a href="{{ route('student.tasks') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-700">
                                Start Now
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                        @else
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <div class="text-4xl mb-2">🎉</div>
                            <p class="font-semibold">All tasks completed!</p>
                            <p class="text-sm">Great work on finishing this roadmap!</p>
                        </div>
                        @endif
                    </div>

                    <!-- Tasks Needing Attention -->
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Tasks in Progress
                        </h3>

                        @if($inProgressTasks->count() > 0)
                        <div class="space-y-3">
                            @foreach($inProgressTasks as $task)
                            <div class="bg-orange-50 dark:bg-orange-900/20 rounded-lg p-3 border border-orange-200 dark:border-orange-800">
                                <h4 class="font-semibold text-gray-900 dark:text-gray-100 text-sm mb-1">{{ $task->title }}</h4>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mb-2">Day {{ $task->day_number }}</p>
                                <a href="{{ route('student.tasks') }}" class="text-xs font-semibold text-orange-600 dark:text-orange-400 hover:text-orange-700">
                                    Continue →
                                </a>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            <div class="text-4xl mb-2">✨</div>
                            <p class="text-sm">No tasks in progress</p>
                            <p class="text-xs">Start your next task to see it here!</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Motivational Message -->
                @php
                    $motivationalMessages = [
                        [
                            'condition' => $overallProgress >= 0 && $overallProgress < 5,
                            'icon' => '🚀',
                            'title' => 'Great Start!',
                            'message' => 'Every expert was once a beginner. You\'ve taken the first step - keep going!',
                            'color' => 'blue'
                        ],
                        [
                            'condition' => $overallProgress >= 5 && $overallProgress < 25,
                            'icon' => '💪',
                            'title' => 'Building Momentum!',
                            'message' => 'You\'re making solid progress. Consistency is the key to success!',
                            'color' => 'green'
                        ],
                        [
                            'condition' => $overallProgress >= 25 && $overallProgress < 50,
                            'icon' => '🔥',
                            'title' => 'You\'re on Fire!',
                            'message' => 'Quarter way through! Your dedication is paying off. Keep it up!',
                            'color' => 'orange'
                        ],
                        [
                            'condition' => $overallProgress >= 50 && $overallProgress < 75,
                            'icon' => '⭐',
                            'title' => 'Halfway There!',
                            'message' => 'Amazing work! You\'ve completed half the journey. The finish line is in sight!',
                            'color' => 'purple'
                        ],
                        [
                            'condition' => $overallProgress >= 75 && $overallProgress < 100,
                            'icon' => '🏆',
                            'title' => 'Almost There!',
                            'message' => 'You\'re in the final stretch! Finish strong - you\'ve got this!',
                            'color' => 'yellow'
                        ],
                        [
                            'condition' => $overallProgress == 100,
                            'icon' => '🎉',
                            'title' => 'Congratulations!',
                            'message' => 'You\'ve completed this roadmap! Your hard work and dedication have paid off. Time to celebrate and tackle new challenges!',
                            'color' => 'green'
                        ],
                    ];

                    $currentMessage = collect($motivationalMessages)->first(function($msg) use ($overallProgress) {
                        return $msg['condition'];
                    });
                @endphp

                @if($currentMessage)
                <div class="bg-gradient-to-r from-{{ $currentMessage['color'] }}-50 to-{{ $currentMessage['color'] }}-100 dark:from-{{ $currentMessage['color'] }}-900/20 dark:to-{{ $currentMessage['color'] }}-800/20 border border-{{ $currentMessage['color'] }}-200 dark:border-{{ $currentMessage['color'] }}-800 rounded-lg p-6 mb-8">
                    <div class="flex items-start gap-4">
                        <div class="text-5xl">{{ $currentMessage['icon'] }}</div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-{{ $currentMessage['color'] }}-900 dark:text-{{ $currentMessage['color'] }}-300 mb-2">
                                {{ $currentMessage['title'] }}
                            </h3>
                            <p class="text-{{ $currentMessage['color'] }}-800 dark:text-{{ $currentMessage['color'] }}-200">
                                {{ $currentMessage['message'] }}
                            </p>
                        </div>
                    </div>
                </div>
                @endif
                @else
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-8">
                    <p class="text-yellow-800">You don't have an active roadmap. Start your learning journey by enrolling in a roadmap!</p>
                    <a href="{{ route('student.roadmaps') }}" class="inline-block mt-3 bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        Browse Roadmaps
                    </a>
                </div>
                @endif

                <!-- Stats Summary -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Task Statistics -->
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Task Statistics</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 dark:text-gray-400">Tasks Completed</span>
                                <span class="font-semibold text-green-600 dark:text-green-400">{{ $totalTasks }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 dark:text-gray-400">Tasks Skipped</span>
                                <span class="font-semibold text-orange-600 dark:text-orange-400">{{ $totalSkipped }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 dark:text-gray-400">Total Done</span>
                                <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $totalTasks + $totalSkipped }}</span>
                            </div>
                            @if($activeEnrollment && !empty($progressStats))
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 dark:text-gray-400">In Progress</span>
                                <span class="font-semibold text-blue-600 dark:text-blue-400">{{ $progressStats['in_progress_tasks'] }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 dark:text-gray-400">Remaining</span>
                                <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $progressStats['remaining_tasks'] }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Learning Time -->
                    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Learning Time</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 dark:text-gray-400">Total Hours</span>
                                <span class="font-semibold text-gray-900 dark:text-gray-100">{{ floor($totalTimeSpent / 60) }}h {{ $totalTimeSpent % 60 }}m</span>
                            </div>
                            @if($activeEnrollment && !empty($progressStats))
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 dark:text-gray-400">Average per Task</span>
                                <span class="font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $totalTasks > 0 ? round($totalTimeSpent / $totalTasks) : 0 }} min
                                </span>
                            </div>
                            @endif
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 dark:text-gray-400">Tasks Completed</span>
                                <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $totalTasks }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Job Board Section -->
        @if(count($recentJobs) > 0)
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Career Opportunities</h2>
                    <a href="{{ route('student.jobs') }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
                        View All Jobs →
                    </a>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    @foreach($recentJobs as $job)
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-5 hover:shadow-md transition-shadow bg-white dark:bg-gray-800">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-start gap-4">
                                    @if(isset($job['company']['logo']) && $job['company']['logo'])
                                    <img src="{{ Storage::url($job['company']['logo']) }}" alt="{{ $job['company']['name'] }}" class="w-16 h-16 rounded-lg object-cover">
                                    @else
                                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-2xl">
                                        {{ substr($job['company']['name'] ?? 'C', 0, 1) }}
                                    </div>
                                    @endif

                                    <div class="flex-1">
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">
                                            {{ $job['title'] }}
                                        </h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                            {{ $job['company']['name'] ?? 'Company' }}
                                            @if($job['location'])
                                            <span class="mx-2">•</span>
                                            <span>{{ $job['location'] }}</span>
                                            @endif
                                        </p>

                                        <div class="flex flex-wrap items-center gap-2 mb-3">
                                            <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-semibold rounded-full">
                                                {{ ucfirst(str_replace('_', ' ', $job['job_type'])) }}
                                            </span>
                                            <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 text-xs font-semibold rounded-full">
                                                {{ ucfirst($job['experience_level']) }} Level
                                            </span>
                                            @if($job['salary_min'] && $job['salary_max'])
                                            <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-semibold rounded-full">
                                                ${{ number_format($job['salary_min']) }} - ${{ number_format($job['salary_max']) }}
                                            </span>
                                            @endif
                                        </div>

                                        <p class="text-sm text-gray-700 dark:text-gray-300 line-clamp-2">
                                            {{ $job['description'] }}
                                        </p>

                                        @if($job['deadline'])
                                        <p class="text-xs text-orange-600 dark:text-orange-400 mt-2">
                                            ⏰ Apply before {{ \Carbon\Carbon::parse($job['deadline'])->format('M d, Y') }}
                                        </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col gap-2">
                                <a href="{{ route('student.job.view', $job['id']) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors text-center">
                                    View Details
                                </a>
                                @php
                                    $hasApplied = \App\Models\JobApplication::where('job_id', $job['id'])
                                        ->where('student_id', auth()->id())
                                        ->exists();
                                @endphp
                                @if($hasApplied)
                                <span class="px-4 py-2 bg-green-100 text-green-700 text-sm font-medium rounded-lg text-center">
                                    Applied ✓
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-6 text-center">
                    <a href="{{ route('student.jobs') }}" class="inline-block px-6 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium rounded-lg transition-colors">
                        Browse All {{ \App\Models\JobListing::where('status', 'open')->count() }} Open Positions
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
