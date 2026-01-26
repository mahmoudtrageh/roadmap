<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-900">Browse Roadmaps</h2>
                <p class="mt-1 text-sm text-gray-600">Choose a learning path and start your journey</p>
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

        <!-- Filters -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <input type="text" wire:model.live.debounce.300ms="searchTerm" placeholder="Search roadmaps..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                    </div>
                    <div>
                        <select wire:model.live="filterDifficulty" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="all">All Difficulties</option>
                            <option value="beginner">Beginner</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="advanced">Advanced</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Learning Path Info -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-2">📚 Your Learning Journey</h3>
            <p class="text-blue-800 text-sm mb-3">
                Follow these 8 roadmaps in order to go from complete beginner to senior developer in <strong>8-9 months</strong> with flexible daily study.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
                <div class="bg-white rounded p-2 border border-blue-100">
                    <div class="font-semibold text-blue-900 mb-1">🟢 Light Days (1-2 hrs)</div>
                    <div class="text-blue-700">Reading & simple exercises</div>
                </div>
                <div class="bg-white rounded p-2 border border-blue-100">
                    <div class="font-semibold text-blue-900 mb-1">🟡 Standard Days (2-3 hrs)</div>
                    <div class="text-blue-700">Practice tasks & coding</div>
                </div>
                <div class="bg-white rounded p-2 border border-blue-100">
                    <div class="font-semibold text-blue-900 mb-1">🔴 Project Days (3-4 hrs)</div>
                    <div class="text-blue-700">Build real applications</div>
                </div>
            </div>
        </div>

        <!-- Roadmaps Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            @forelse ($roadmaps as $roadmap)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    @if ($roadmap->image_path)
                        <img src="{{ Storage::url($roadmap->image_path) }}" alt="{{ $roadmap->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-blue-400 to-indigo-600"></div>
                    @endif

                    <div class="p-6">
                        <div class="flex items-start justify-between mb-2">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    @if($roadmap->order)
                                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 text-white text-sm font-bold">
                                            {{ $roadmap->order }}
                                        </span>
                                    @endif
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $roadmap->title }}</h3>
                                </div>
                            </div>
                            @if ($roadmap->is_featured)
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">⭐ Start Here</span>
                            @endif
                        </div>

                        <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $roadmap->description }}</p>

                        <div class="flex items-center gap-4 mb-4 text-sm text-gray-500">
                            <span class="inline-flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $roadmap->duration_days }} days
                            </span>
                            <span class="inline-flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                {{ $roadmap->tasks_count }} tasks
                            </span>
                        </div>

                        <div class="mb-4 flex items-center justify-between">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($roadmap->difficulty_level === 'beginner') bg-green-100 text-green-800
                                @elseif($roadmap->difficulty_level === 'intermediate') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($roadmap->difficulty_level) }}
                            </span>
                            @if($roadmap->rating_count > 0)
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="text-sm font-medium text-gray-700">{{ number_format($roadmap->average_rating, 1) }}</span>
                                <span class="text-xs text-gray-500">({{ $roadmap->rating_count }})</span>
                            </div>
                            @endif
                        </div>

                        <a href="{{ route('student.roadmap.view', ['roadmapId' => $roadmap->id]) }}" class="block w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg font-medium transition duration-150 mb-2">
                            View Details
                        </a>

                        @php
                            $isLocked = false;
                            $lockReason = '';

                            // Check if has prerequisite that's not completed or skipped
                            if ($roadmap->prerequisite_roadmap_id && !in_array($roadmap->prerequisite_roadmap_id, $completedOrSkippedRoadmapIds)) {
                                $isLocked = true;
                                $lockReason = 'Complete or skip previous roadmap first';
                            }

                            // Check if user already has active enrollment
                            if ($hasActiveEnrollment && !in_array($roadmap->id, $enrolledRoadmapIds)) {
                                $isLocked = true;
                                $lockReason = 'Complete active roadmap first';
                            }
                        @endphp

                        @if (in_array($roadmap->id, $enrolledRoadmapIds))
                            <span class="block w-full text-center bg-green-100 text-green-700 px-4 py-2 rounded-lg font-medium">
                                ✓ Enrolled
                            </span>
                        @elseif ($isLocked)
                            <button disabled class="block w-full bg-gray-300 text-gray-500 px-4 py-2 rounded-lg font-medium cursor-not-allowed" title="{{ $lockReason }}">
                                🔒 Locked
                            </button>
                            <p class="text-xs text-gray-500 text-center mt-1">{{ $lockReason }}</p>
                        @else
                            <div class="flex flex-col gap-2">
                                <button wire:click="enroll({{ $roadmap->id }})" class="block w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition duration-150">
                                    Enroll Now
                                </button>
                                <button wire:click="skipRoadmap({{ $roadmap->id }})" class="block w-full bg-gray-500 hover:bg-gray-600 text-white px-4 py-1.5 rounded-lg font-medium text-sm transition duration-150">
                                    Skip
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 text-gray-500">
                    No roadmaps found.
                </div>
            @endforelse
        </div>
    </div>
</div>
