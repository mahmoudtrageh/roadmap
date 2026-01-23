<div class="container mx-auto px-4 py-8">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Content Management</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Manage all tasks and content quality</p>
        </div>
        <div class="flex gap-3">
            <button wire:click="exportCSV"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export CSV
            </button>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if (session()->has('message'))
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-4 py-3 rounded-lg mb-6">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 px-4 py-3 rounded-lg mb-6">
            {{ session('error') }}
        </div>
    @endif

    {{-- Content Health Dashboard --}}
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg shadow-lg p-6 mb-8 text-white">
        <h2 class="text-2xl font-bold mb-4 flex items-center gap-2">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Content Health Dashboard
        </h2>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4">
                <div class="text-3xl font-bold">{{ $contentHealth['total_tasks'] }}</div>
                <div class="text-sm opacity-90">Total Tasks</div>
            </div>

            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4">
                <div class="text-3xl font-bold text-green-300">{{ $contentHealth['perfect_tasks'] }}</div>
                <div class="text-sm opacity-90">Perfect Tasks</div>
                <div class="text-xs opacity-75 mt-1">{{ round(($contentHealth['perfect_tasks'] / max($contentHealth['total_tasks'], 1)) * 100, 1) }}%</div>
            </div>

            @if($contentHealth['missing_description'] > 0)
            <div class="bg-red-500/20 backdrop-blur-sm rounded-lg p-4 border border-red-300/30">
                <div class="text-3xl font-bold text-red-200">{{ $contentHealth['missing_description'] }}</div>
                <div class="text-sm opacity-90">Missing Description</div>
            </div>
            @endif

            @if($contentHealth['missing_resources'] > 0)
            <div class="bg-orange-500/20 backdrop-blur-sm rounded-lg p-4 border border-orange-300/30">
                <div class="text-3xl font-bold text-orange-200">{{ $contentHealth['missing_resources'] }}</div>
                <div class="text-sm opacity-90">Missing Resources</div>
            </div>
            @endif

            @if($contentHealth['missing_objectives'] > 0)
            <div class="bg-yellow-500/20 backdrop-blur-sm rounded-lg p-4 border border-yellow-300/30">
                <div class="text-3xl font-bold text-yellow-200">{{ $contentHealth['missing_objectives'] }}</div>
                <div class="text-sm opacity-90">Missing Objectives</div>
            </div>
            @endif

            @if($contentHealth['missing_checklists'] > 0)
            <div class="bg-blue-500/20 backdrop-blur-sm rounded-lg p-4 border border-blue-300/30">
                <div class="text-3xl font-bold text-blue-200">{{ $contentHealth['missing_checklists'] }}</div>
                <div class="text-sm opacity-90">Missing Checklists</div>
            </div>
            @endif

            @if($contentHealth['missing_quizzes'] > 0)
            <div class="bg-purple-500/20 backdrop-blur-sm rounded-lg p-4 border border-purple-300/30">
                <div class="text-3xl font-bold text-purple-200">{{ $contentHealth['missing_quizzes'] }}</div>
                <div class="text-sm opacity-90">Missing Quizzes</div>
            </div>
            @endif

            @if($contentHealth['missing_examples'] > 0)
            <div class="bg-pink-500/20 backdrop-blur-sm rounded-lg p-4 border border-pink-300/30">
                <div class="text-3xl font-bold text-pink-200">{{ $contentHealth['missing_examples'] }}</div>
                <div class="text-sm opacity-90">Missing Examples</div>
            </div>
            @endif

            @if($contentHealth['long_tasks'] > 0)
            <div class="bg-amber-500/20 backdrop-blur-sm rounded-lg p-4 border border-amber-300/30">
                <div class="text-3xl font-bold text-amber-200">{{ $contentHealth['long_tasks'] }}</div>
                <div class="text-sm opacity-90">Long Tasks (>120min)</div>
            </div>
            @endif
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Filters & Search</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
            {{-- Search --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                <input type="text"
                       wire:model.live.debounce.300ms="searchTerm"
                       placeholder="Search tasks..."
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
            </div>

            {{-- Roadmap Filter --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Roadmap</label>
                <select wire:model.live="filterRoadmap" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                    <option value="all">All Roadmaps</option>
                    @foreach($roadmaps as $roadmap)
                        <option value="{{ $roadmap->id }}">{{ $roadmap->title }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Type Filter --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type</label>
                <select wire:model.live="filterType" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                    <option value="all">All Types</option>
                    <option value="reading">Reading</option>
                    <option value="video">Video</option>
                    <option value="exercise">Exercise</option>
                    <option value="coding">Coding</option>
                    <option value="project">Project</option>
                    <option value="quiz">Quiz</option>
                </select>
            </div>

            {{-- Difficulty Filter --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Difficulty</label>
                <select wire:model.live="filterDifficulty" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                    <option value="all">All Difficulties</option>
                    <option value="beginner">Beginner</option>
                    <option value="intermediate">Intermediate</option>
                    <option value="advanced">Advanced</option>
                </select>
            </div>
        </div>

        <div class="flex gap-4">
            {{-- Quality Filter --}}
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Quality Issues</label>
                <select wire:model.live="filterQuality" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                    <option value="all">All Tasks</option>
                    <option value="missing_description">Missing Description</option>
                    <option value="missing_resources">Missing Resources</option>
                    <option value="missing_objectives">Missing Objectives</option>
                    <option value="missing_checklists">Missing Checklists</option>
                    <option value="missing_quizzes">Missing Quizzes</option>
                    <option value="missing_examples">Missing Examples</option>
                    <option value="long_tasks">Long Tasks (>120min)</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Bulk Actions --}}
    @if(count($selectedTasks) > 0)
    <div class="bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-200 dark:border-indigo-800 rounded-lg p-4 mb-6">
        <div class="flex items-center gap-4">
            <span class="font-semibold text-indigo-900 dark:text-indigo-200">
                {{ count($selectedTasks) }} task(s) selected
            </span>

            <select wire:model="bulkAction" class="px-3 py-2 border border-indigo-300 dark:border-indigo-700 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-indigo-900/30 dark:text-white">
                <option value="">Choose action...</option>
                <option value="update_difficulty">Update Difficulty</option>
                <option value="update_category">Update Category</option>
                <option value="update_type">Update Type</option>
                <option value="generate_checklists">Generate Checklists</option>
                <option value="generate_quizzes">Generate Quizzes</option>
                <option value="generate_examples">Generate Examples</option>
                <option value="delete">Delete</option>
            </select>

            @if(in_array($bulkAction, ['update_difficulty', 'update_category', 'update_type']))
            <input type="text"
                   wire:model="bulkValue"
                   placeholder="Enter value..."
                   class="px-3 py-2 border border-indigo-300 dark:border-indigo-700 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-indigo-900/30 dark:text-white">
            @endif

            <button wire:click="applyBulkAction"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition">
                Apply
            </button>

            <button wire:click="$set('selectedTasks', [])"
                    class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                Clear Selection
            </button>
        </div>
    </div>
    @endif

    {{-- Tasks Table --}}
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th class="px-4 py-3 text-left">
                            <input type="checkbox"
                                   wire:model.live="selectAll"
                                   wire:click="toggleSelectAll"
                                   class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        </th>
                        <th wire:click="sort('id')" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-800">
                            ID
                            @if($sortBy === 'id')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </th>
                        <th wire:click="sort('title')" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-800">
                            Task
                            @if($sortBy === 'title')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Roadmap</th>
                        <th wire:click="sort('day_number')" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-800">
                            Day
                            @if($sortBy === 'day_number')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Difficulty</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Quality</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($tasks as $task)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                        <td class="px-4 py-3">
                            <input type="checkbox"
                                   wire:model.live="selectedTasks"
                                   value="{{ $task->id }}"
                                   class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $task->id }}</td>
                        <td class="px-4 py-3">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ Str::limit($task->title, 50) }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $task->category }}</div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ $task->roadmap->title ?? 'N/A' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $task->day_number }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200">
                                {{ ucfirst($task->task_type) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            @if($task->difficulty_level)
                            <span class="px-2 py-1 text-xs rounded-full
                                @if($task->difficulty_level === 'beginner') bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200
                                @elseif($task->difficulty_level === 'intermediate') bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-200
                                @else bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-200
                                @endif">
                                {{ ucfirst($task->difficulty_level) }}
                            </span>
                            @else
                            <span class="text-xs text-gray-400">Not set</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-1">
                                @if(!empty($task->description))
                                    <span class="text-green-500" title="Has description">✓</span>
                                @else
                                    <span class="text-red-500" title="Missing description">✗</span>
                                @endif

                                @if(count($task->resources_links ?? []) > 0)
                                    <span class="text-green-500" title="{{ count($task->resources_links) }} resources">R</span>
                                @else
                                    <span class="text-red-500" title="No resources">R</span>
                                @endif

                                @if($task->checklists()->exists())
                                    <span class="text-green-500" title="Has checklist">C</span>
                                @else
                                    <span class="text-gray-400" title="No checklist">C</span>
                                @endif

                                @if($task->quizzes()->exists())
                                    <span class="text-green-500" title="Has quiz">Q</span>
                                @else
                                    <span class="text-gray-400" title="No quiz">Q</span>
                                @endif

                                @if($task->examples()->exists())
                                    <span class="text-green-500" title="Has examples">E</span>
                                @else
                                    <span class="text-gray-400" title="No examples">E</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <a href="/admin/tasks/{{ $task->roadmap_id }}"
                               class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 text-sm">
                                Edit
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                            No tasks found matching your filters.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
            {{ $tasks->links() }}
        </div>
    </div>
</div>
