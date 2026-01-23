<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
        @endif

        @if($activeEnrollment)
        <div class="space-y-6">
            <!-- Header Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">Progress Tracker</h2>
                            <p class="text-gray-600 mt-1">{{ $activeEnrollment->roadmap->title }}</p>
                        </div>
                        <button
                            wire:click="refreshProgress"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                            Refresh Progress
                        </button>
                    </div>

                    <!-- Overall Progress Bar -->
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-700">Overall Progress</span>
                            <span class="text-sm font-semibold text-blue-600">{{ $progressPercentage }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-4">
                            <div
                                class="bg-gradient-to-r from-blue-500 to-blue-600 h-4 rounded-full transition-all duration-500"
                                style="width: {{ $progressPercentage }}%">
                            </div>
                        </div>
                    </div>

                    <!-- Stats Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="bg-blue-50 rounded-lg p-4">
                            <p class="text-sm text-blue-600 font-medium">Current Day</p>
                            <p class="text-2xl font-bold text-blue-900 mt-1">{{ $currentDay }} / {{ $totalDays }}</p>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4">
                            <p class="text-sm text-green-600 font-medium">Completed Tasks</p>
                            <p class="text-2xl font-bold text-green-900 mt-1">{{ $completedTasks }}</p>
                        </div>
                        <div class="bg-orange-50 rounded-lg p-4">
                            <p class="text-sm text-orange-600 font-medium">Remaining Tasks</p>
                            <p class="text-2xl font-bold text-orange-900 mt-1">{{ $remainingTasks }}</p>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-4">
                            <p class="text-sm text-purple-600 font-medium">Total Tasks</p>
                            <p class="text-2xl font-bold text-purple-900 mt-1">{{ $totalTasks }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category Progress -->
            @if(count($categoryProgress) > 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Progress by Category</h3>
                    <div class="space-y-4">
                        @foreach($categoryProgress as $category => $data)
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-medium text-gray-700">{{ ucfirst($category) }}</span>
                                    <span class="text-xs text-gray-500">
                                        ({{ $data['completed'] }} / {{ $data['total'] }} tasks)
                                    </span>
                                </div>
                                <span class="text-sm font-semibold text-gray-900">{{ $data['percentage'] }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div
                                    class="
                                    @if($data['percentage'] >= 75) bg-green-500
                                    @elseif($data['percentage'] >= 50) bg-blue-500
                                    @elseif($data['percentage'] >= 25) bg-yellow-500
                                    @else bg-orange-500
                                    @endif
                                    h-2.5 rounded-full transition-all duration-500"
                                    style="width: {{ $data['percentage'] }}%">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Day-wise Progress -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Day-by-Day Progress</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                        @foreach($dayWiseProgress as $dayData)
                        <div class="border rounded-lg p-4
                            {{ $dayData['is_current'] ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}
                            {{ $dayData['is_completed'] ? 'bg-green-50 border-green-300' : '' }}">

                            <div class="flex items-center justify-between mb-2">
                                <span class="font-semibold text-gray-900">
                                    Day {{ $dayData['day'] }}
                                </span>
                                @if($dayData['is_current'])
                                <span class="bg-blue-600 text-white text-xs px-2 py-0.5 rounded">Current</span>
                                @elseif($dayData['is_completed'])
                                <span class="text-green-600 text-xl">✓</span>
                                @endif
                            </div>

                            <div class="text-sm text-gray-600 mb-2">
                                {{ $dayData['completed_tasks'] }} / {{ $dayData['total_tasks'] }} tasks
                            </div>

                            <!-- Mini Progress Bar -->
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div
                                    class="
                                    {{ $dayData['is_completed'] ? 'bg-green-500' : 'bg-blue-500' }}
                                    h-2 rounded-full transition-all duration-300"
                                    style="width: {{ $dayData['percentage'] }}%">
                                </div>
                            </div>

                            <div class="text-xs text-gray-500 mt-1 text-right">
                                {{ $dayData['percentage'] }}%
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Additional Stats -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Additional Statistics</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Completion Rate -->
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="font-semibold text-gray-700">Task Completion Rate</h4>
                                <span class="text-2xl">📊</span>
                            </div>
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Completed</span>
                                    <span class="font-semibold text-green-600">{{ $completedTasks }}</span>
                                </div>
                                @if(isset($progressStats['in_progress_tasks']))
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">In Progress</span>
                                    <span class="font-semibold text-blue-600">{{ $progressStats['in_progress_tasks'] }}</span>
                                </div>
                                @endif
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Remaining</span>
                                    <span class="font-semibold text-orange-600">{{ $remainingTasks }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Day Progress -->
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="font-semibold text-gray-700">Day Progress</h4>
                                <span class="text-2xl">📅</span>
                            </div>
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Current Day</span>
                                    <span class="font-semibold text-blue-600">{{ $currentDay }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Total Days</span>
                                    <span class="font-semibold text-gray-900">{{ $totalDays }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Days Remaining</span>
                                    <span class="font-semibold text-orange-600">{{ max(0, $totalDays - $currentDay + 1) }}</span>
                                </div>
                                @if(isset($progressStats['days_percentage']))
                                <div class="mt-3">
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div
                                            class="bg-blue-500 h-2 rounded-full"
                                            style="width: {{ $progressStats['days_percentage'] }}%">
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1 text-right">{{ $progressStats['days_percentage'] }}% of days completed</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
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
</div>
