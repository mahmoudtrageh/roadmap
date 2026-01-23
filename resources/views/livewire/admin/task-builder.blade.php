<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Task Builder</h2>
                        <p class="mt-1 text-sm text-gray-600">{{ $roadmap->title }} - {{ $roadmap->tasks->count() }} tasks</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.roadmaps') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg font-medium transition duration-150">
                            Back to Roadmaps
                        </a>
                        <button wire:click="createNew" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition duration-150">
                            Add New Task
                        </button>
                    </div>
                </div>
            </div>
        </div>

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

        <!-- Form Modal -->
        @if ($showForm)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">{{ $isEditing ? 'Edit Task' : 'Create New Task' }}</h3>
                    <form wire:submit="save" class="space-y-4">
                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">Task Title</label>
                            <input type="text" wire:model="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                            @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea wire:model="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                            @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Day, Time, Type, Category -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div>
                                <label for="day_number" class="block text-sm font-medium text-gray-700">Day Number</label>
                                <input type="number" wire:model="day_number" id="day_number" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                                @error('day_number') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="estimated_time_minutes" class="block text-sm font-medium text-gray-700">Time (minutes)</label>
                                <input type="number" wire:model="estimated_time_minutes" id="estimated_time_minutes" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                                @error('estimated_time_minutes') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="task_type" class="block text-sm font-medium text-gray-700">Task Type</label>
                                <select wire:model="task_type" id="task_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="reading">Reading</option>
                                    <option value="video">Video</option>
                                    <option value="exercise">Exercise</option>
                                    <option value="project">Project</option>
                                    <option value="quiz">Quiz</option>
                                </select>
                                @error('task_type') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                                <input type="text" wire:model="category" id="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                                @error('category') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Order -->
                        <div>
                            <label for="order" class="block text-sm font-medium text-gray-700">Order</label>
                            <input type="number" wire:model="order" id="order" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                            @error('order') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Resource Links (Legacy - for backward compatibility) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Resource Links (Legacy)</label>
                            <p class="text-xs text-gray-500 mb-2">Use "Enhanced Resources" below for language-specific resources</p>
                            <div class="mt-2 space-y-2">
                                @foreach($resources_links as $index => $link)
                                    <div class="flex gap-2">
                                        <input type="text" value="{{ $link }}" readonly class="flex-1 rounded-md border-gray-300 bg-gray-50" />
                                        <button type="button" wire:click="removeResourceLink({{ $index }})" class="px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Remove</button>
                                    </div>
                                @endforeach
                                <div class="flex gap-2">
                                    <input type="text" wire:model="resourceLink" placeholder="Enter resource link" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                                    <button type="button" wire:click="addResourceLink" class="px-3 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">Add</button>
                                </div>
                            </div>
                        </div>

                        <!-- Enhanced Resources with Language Support -->
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex items-center justify-between mb-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Enhanced Resources (with Language)</label>
                                    <p class="text-xs text-gray-500">Add resources with language, title, and type</p>
                                </div>
                            </div>

                            <!-- Existing Resources -->
                            @if(count($resources) > 0)
                            <div class="space-y-2 mb-4">
                                @foreach($resources as $index => $resource)
                                <div class="border border-gray-200 rounded-lg p-3 bg-gray-50">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="px-2 py-0.5 bg-{{ $resource['language'] === 'ar' ? 'green' : 'blue' }}-100 text-{{ $resource['language'] === 'ar' ? 'green' : 'blue' }}-700 text-xs font-semibold rounded">
                                                    {{ $resource['language'] === 'ar' ? 'العربية' : 'English' }}
                                                </span>
                                                <span class="px-2 py-0.5 bg-purple-100 text-purple-700 text-xs font-semibold rounded">
                                                    {{ ucfirst($resource['type'] ?? 'article') }}
                                                </span>
                                            </div>
                                            @if(!empty($resource['title']))
                                            <p class="text-sm font-medium text-gray-900 mb-1">{{ $resource['title'] }}</p>
                                            @endif
                                            <p class="text-xs text-gray-600 break-all">{{ $resource['url'] }}</p>
                                        </div>
                                        <button type="button" wire:click="removeResource({{ $index }})" class="px-3 py-1 bg-red-500 text-white text-sm rounded hover:bg-red-600">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif

                            <!-- Add New Resource Form -->
                            <div class="border border-gray-300 rounded-lg p-4 bg-white">
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Resource URL *</label>
                                        <input type="url" wire:model="resourceLink" placeholder="https://example.com/resource" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" />
                                    </div>

                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Resource Title (Optional)</label>
                                        <input type="text" wire:model="resourceTitle" placeholder="e.g., Introduction to HTML" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" />
                                    </div>

                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Language *</label>
                                            <select wire:model="resourceLanguage" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                                <option value="en">English</option>
                                                <option value="ar">Arabic (العربية)</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Type *</label>
                                            <select wire:model="resourceType" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                                <option value="article">Article</option>
                                                <option value="video">Video</option>
                                                <option value="tutorial">Tutorial</option>
                                                <option value="documentation">Documentation</option>
                                                <option value="course">Course</option>
                                                <option value="blog">Blog Post</option>
                                                <option value="youtube">YouTube Channel</option>
                                            </select>
                                        </div>
                                    </div>

                                    <button type="button" wire:click="addResource" class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 font-medium text-sm">
                                        + Add Resource
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Checkboxes -->
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="checkbox" wire:model="has_code_submission" id="has_code_submission" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                                <label for="has_code_submission" class="ml-2 block text-sm text-gray-700">Requires Code Submission</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" wire:model="has_quality_rating" id="has_quality_rating" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                                <label for="has_quality_rating" class="ml-2 block text-sm text-gray-700">Has Quality Rating</label>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-3 pt-4">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition duration-150">
                                {{ $isEditing ? 'Update' : 'Create' }}
                            </button>
                            <button type="button" wire:click="cancelEdit" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg font-medium transition duration-150">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <!-- Filters -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <select wire:model.live="filterDay" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="all">All Days</option>
                            @for ($i = 1; $i <= $roadmap->duration_days; $i++)
                                <option value="{{ $i }}">Day {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <select wire:model.live="filterType" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="all">All Types</option>
                            <option value="reading">Reading</option>
                            <option value="video">Video</option>
                            <option value="exercise">Exercise</option>
                            <option value="project">Project</option>
                            <option value="quiz">Quiz</option>
                        </select>
                    </div>
                    <div>
                        <select wire:model.live="filterCategory" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="all">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}">{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks List -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Day</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Task</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($tasks as $task)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Day {{ $task->day_number }}</td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $task->title }}</div>
                                        <div class="text-sm text-gray-500 flex gap-2 mt-1">
                                            @if($task->has_code_submission)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">Code</span>
                                            @endif
                                            @if($task->has_quality_rating)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">Rated</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ ucfirst($task->task_type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $task->category }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $task->estimated_time_minutes }} min</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $task->order }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex gap-2">
                                            <button wire:click="moveUp({{ $task->id }})" class="text-gray-600 hover:text-gray-900" title="Move Up">↑</button>
                                            <button wire:click="moveDown({{ $task->id }})" class="text-gray-600 hover:text-gray-900" title="Move Down">↓</button>
                                            <button wire:click="edit({{ $task->id }})" class="text-blue-600 hover:text-blue-900">Edit</button>
                                            <button wire:click="duplicate({{ $task->id }})" class="text-green-600 hover:text-green-900">Dup</button>
                                            <button wire:click="delete({{ $task->id }})" onclick="return confirm('Are you sure?')" class="text-red-600 hover:text-red-900">Del</button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">No tasks found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $tasks->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
