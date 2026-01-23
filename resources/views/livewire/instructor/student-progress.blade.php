<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-900">Student Progress Tracking</h2>
                <p class="mt-1 text-sm text-gray-600">Monitor student progress and task completions</p>
            </div>
        </div>

        <!-- Details Modal -->
        @if ($showDetails && $selectedEnrollment && $progressStats)
            <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="closeDetails">
                <div class="relative top-10 mx-auto p-5 border w-11/12 max-w-6xl shadow-lg rounded-md bg-white mb-10" wire:click.stop>
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $selectedEnrollment->student->name }}</h3>
                            <p class="text-sm text-gray-600">{{ $selectedEnrollment->roadmap->title }}</p>
                        </div>
                        <button wire:click="closeDetails" class="text-gray-400 hover:text-gray-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Progress Overview -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600">{{ $progressStats['progress_percentage'] }}%</div>
                            <div class="text-sm text-gray-600">Overall Progress</div>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <div class="text-2xl font-bold text-green-600">{{ $progressStats['completed_tasks'] }}/{{ $progressStats['total_tasks'] }}</div>
                            <div class="text-sm text-gray-600">Tasks Completed</div>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <div class="text-2xl font-bold text-purple-600">Day {{ $progressStats['current_day'] }}</div>
                            <div class="text-sm text-gray-600">Current Day</div>
                        </div>
                        <div class="bg-orange-50 p-4 rounded-lg">
                            <div class="text-2xl font-bold text-orange-600">{{ $progressStats['in_progress_tasks'] }}</div>
                            <div class="text-sm text-gray-600">In Progress</div>
                        </div>
                    </div>

                    <!-- Task Completion Chart -->
                    @if($taskCompletionChartData && count($taskCompletionChartData) > 0)
                        <div class="bg-white border rounded-lg p-6 mb-6">
                            <h4 class="text-lg font-semibold text-gray-700 mb-4">Task Completions (Last 30 Days)</h4>
                            <div class="h-64">
                                <div class="flex items-end justify-between h-full space-x-1">
                                    @php
                                        $maxCount = max(array_column($taskCompletionChartData, 'count')) ?: 1;
                                    @endphp
                                    @foreach($taskCompletionChartData as $data)
                                        <div class="flex flex-col items-center flex-1">
                                            <div class="w-full bg-blue-500 rounded-t hover:bg-blue-600 transition-colors relative group"
                                                 style="height: {{ $data['count'] > 0 ? ($data['count'] / $maxCount * 100) : 2 }}%;">
                                                <div class="absolute bottom-full mb-2 hidden group-hover:block bg-gray-800 text-white text-xs rounded py-1 px-2 whitespace-nowrap">
                                                    {{ $data['count'] }} tasks
                                                </div>
                                            </div>
                                            <span class="text-xs text-gray-500 mt-2 transform -rotate-45 origin-top-left">{{ $data['date'] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Category Progress -->
                    @if($categoryProgress && count($categoryProgress) > 0)
                        <div class="bg-white border rounded-lg p-6 mb-6">
                            <h4 class="text-lg font-semibold text-gray-700 mb-4">Progress by Category</h4>
                            <div class="space-y-4">
                                @foreach($categoryProgress as $category => $progress)
                                    <div>
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-sm font-medium text-gray-700">{{ $category }}</span>
                                            <span class="text-sm text-gray-600">{{ $progress['completed'] }}/{{ $progress['total'] }} ({{ $progress['percentage'] }}%)</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: {{ $progress['percentage'] }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Time Spent by Category -->
                    @if($timeSpentChartData && count($timeSpentChartData) > 0)
                        <div class="bg-white border rounded-lg p-6 mb-6">
                            <h4 class="text-lg font-semibold text-gray-700 mb-4">Time Spent by Category</h4>
                            <div class="space-y-3">
                                @php
                                    $totalTime = array_sum(array_column($timeSpentChartData, 'time'));
                                    $colors = ['bg-blue-500', 'bg-green-500', 'bg-purple-500', 'bg-yellow-500', 'bg-red-500', 'bg-indigo-500', 'bg-pink-500'];
                                @endphp
                                @foreach($timeSpentChartData as $index => $data)
                                    <div class="flex items-center">
                                        <div class="w-32 text-sm font-medium text-gray-700">{{ $data['category'] }}</div>
                                        <div class="flex-1 mx-4">
                                            <div class="w-full bg-gray-200 rounded-full h-6">
                                                <div class="{{ $colors[$index % count($colors)] }} h-6 rounded-full flex items-center justify-end pr-2 text-xs text-white font-medium transition-all duration-300"
                                                     style="width: {{ $totalTime > 0 ? ($data['time'] / $totalTime * 100) : 0 }}%">
                                                    @if($totalTime > 0 && ($data['time'] / $totalTime * 100) > 15)
                                                        {{ number_format($data['time'] / 60, 1) }}h
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="w-20 text-sm text-gray-600 text-right">{{ number_format($data['time'] / 60, 1) }}h</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Task List -->
                    <div class="bg-white border rounded-lg p-6">
                        <h4 class="text-lg font-semibold text-gray-700 mb-4">Task Details</h4>
                        <div class="space-y-2 max-h-96 overflow-y-auto">
                            @php
                                $completedTaskIds = $selectedEnrollment->taskCompletions->where('status', 'completed')->pluck('task_id')->toArray();
                                $inProgressTaskIds = $selectedEnrollment->taskCompletions->where('status', 'in_progress')->pluck('task_id')->toArray();
                            @endphp
                            @foreach($selectedEnrollment->roadmap->tasks as $task)
                                <div class="flex items-center justify-between p-3 rounded
                                    @if(in_array($task->id, $completedTaskIds)) bg-green-50
                                    @elseif(in_array($task->id, $inProgressTaskIds)) bg-blue-50
                                    @else bg-gray-50 @endif">
                                    <div class="flex items-center flex-1">
                                        <div class="mr-3">
                                            @if(in_array($task->id, $completedTaskIds))
                                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                            @elseif(in_array($task->id, $inProgressTaskIds))
                                                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <div class="text-sm font-medium text-gray-900">{{ $task->title }}</div>
                                            <div class="text-xs text-gray-500">Day {{ $task->day_number }} - {{ $task->category }}</div>
                                        </div>
                                    </div>
                                    <div class="text-sm text-gray-600">{{ $task->estimated_time_minutes }} min</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Filters -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <input type="text" wire:model.live.debounce.300ms="searchStudent" placeholder="Search by student name..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                    </div>
                    <div>
                        <select wire:model.live="filterRoadmap" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="all">All Roadmaps</option>
                            @foreach($roadmaps as $roadmap)
                                <option value="{{ $roadmap->id }}">{{ $roadmap->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select wire:model.live="filterStatus" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="all">All Status</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                            <option value="paused">Paused</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enrollments List -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Roadmap</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Current Day</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($enrollments as $enrollment)
                                @php
                                    $totalTasks = $enrollment->roadmap->tasks->count();
                                    $progress = $totalTasks > 0 ? round(($enrollment->completed_tasks_count / $totalTasks) * 100) : 0;
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 flex-shrink-0">
                                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                    <span class="text-gray-600 font-medium">{{ substr($enrollment->student->name, 0, 1) }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $enrollment->student->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $enrollment->student->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $enrollment->roadmap->title }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-32 bg-gray-200 rounded-full h-2 mr-2">
                                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $progress }}%"></div>
                                            </div>
                                            <span class="text-sm text-gray-600">{{ $progress }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Day {{ $enrollment->current_day ?? 1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($enrollment->status === 'completed') bg-green-100 text-green-800
                                            @elseif($enrollment->status === 'in_progress') bg-blue-100 text-blue-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($enrollment->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button wire:click="viewDetails({{ $enrollment->id }})" class="text-blue-600 hover:text-blue-900">
                                            View Details
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No enrollments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $enrollments->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
