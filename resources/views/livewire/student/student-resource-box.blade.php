<div>
    @if(session()->has('resource_success'))
    <div class="mb-4 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded">
        {{ session('resource_success') }}
    </div>
    @endif

    <!-- Header -->
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
            <span>Community Resources</span>
            <span class="text-sm font-normal text-gray-500 dark:text-gray-400">({{ $studentResources->count() }})</span>
        </h3>
        <button wire:click="toggleAddForm"
                class="px-3 py-1.5 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors flex items-center gap-1">
            <span>{{ $showAddForm ? '✕ Cancel' : '+ Add Resource' }}</span>
        </button>
    </div>

    <!-- Add Resource Form -->
    @if($showAddForm)
    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 mb-4 border border-gray-200 dark:border-gray-600">
        <h4 class="font-medium text-gray-900 dark:text-white mb-3">Share a Helpful Resource</h4>

        <form wire:submit.prevent="submitResource" class="space-y-3">
            <!-- URL -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Resource URL <span class="text-red-500">*</span>
                </label>
                <input type="url"
                       wire:model="url"
                       placeholder="https://..."
                       class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('url') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Title -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Title <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       wire:model="title"
                       placeholder="e.g., Great Tutorial on Laravel"
                       class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Type <span class="text-red-500">*</span>
                </label>
                <select wire:model="type"
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="article">Article</option>
                    <option value="video">Video</option>
                    <option value="tutorial">Tutorial</option>
                    <option value="documentation">Documentation</option>
                    <option value="course">Course</option>
                    <option value="blog">Blog Post</option>
                    <option value="interactive">Interactive</option>
                </select>
                @error('type') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Description (optional)
                </label>
                <textarea wire:model="description"
                          rows="2"
                          placeholder="Why is this resource helpful?"
                          class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex gap-2">
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors text-sm font-medium">
                    Share Resource
                </button>
                <button type="button"
                        wire:click="toggleAddForm"
                        class="px-4 py-2 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-300 rounded-lg transition-colors text-sm font-medium">
                    Cancel
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- Resources List -->
    @if($studentResources->count() > 0)
    <div class="space-y-3">
        @foreach($studentResources as $resource)
        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700 hover:border-blue-300 dark:hover:border-blue-600 transition-colors">
            <div class="flex items-start gap-3">
                <!-- Icon based on type -->
                <div class="text-2xl flex-shrink-0">
                    @if($resource->type === 'video')
                        🎥
                    @elseif($resource->type === 'article')
                        📄
                    @elseif($resource->type === 'tutorial')
                        📝
                    @elseif($resource->type === 'documentation')
                        📘
                    @elseif($resource->type === 'course')
                        🎓
                    @elseif($resource->type === 'blog')
                        ✍️
                    @elseif($resource->type === 'interactive')
                        💻
                    @else
                        📖
                    @endif
                </div>

                <div class="flex-1 min-w-0">
                    <!-- Title and Link -->
                    <a href="{{ $resource->url }}"
                       target="_blank"
                       class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium hover:underline">
                        {{ $resource->title }}
                    </a>

                    <!-- Description -->
                    @if($resource->description)
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $resource->description }}</p>
                    @endif

                    <!-- Meta Info -->
                    <div class="flex items-center gap-3 mt-2 text-xs text-gray-500 dark:text-gray-400">
                        <span class="px-2 py-0.5 bg-gray-100 dark:bg-gray-700 rounded">{{ ucfirst($resource->type) }}</span>
                        <span>Shared by {{ $resource->student->name }}</span>
                        <span>{{ $resource->created_at->diffForHumans() }}</span>
                    </div>
                </div>

                <!-- Helpful Button -->
                <div class="flex-shrink-0">
                    <button wire:click="toggleHelpful({{ $resource->id }})"
                            class="flex items-center gap-1 px-3 py-1.5 rounded-lg transition-colors {{ $resource->is_voted_by_me ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-600' }}">
                        <span>{{ $resource->is_voted_by_me ? '👍' : '👍🏻' }}</span>
                        <span class="text-sm font-medium">{{ $resource->helpful_count }}</span>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-8 text-center border border-dashed border-gray-300 dark:border-gray-600">
        <div class="text-4xl mb-2">📚</div>
        <p class="text-gray-600 dark:text-gray-400 text-sm">
            No community resources yet. Be the first to share a helpful resource!
        </p>
    </div>
    @endif
</div>
