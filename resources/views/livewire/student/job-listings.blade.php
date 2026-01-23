<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Job Board') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session()->has('message'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('message') }}
                </div>
            @endif

            <!-- Filters -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search</label>
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Job title, company, keywords..."
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300"
                        >
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Job Type</label>
                        <select wire:model.live="jobType" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                            <option value="all">All Types</option>
                            <option value="full_time">Full Time</option>
                            <option value="part_time">Part Time</option>
                            <option value="contract">Contract</option>
                            <option value="internship">Internship</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Experience Level</label>
                        <select wire:model.live="experienceLevel" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                            <option value="all">All Levels</option>
                            <option value="entry">Entry Level</option>
                            <option value="mid">Mid Level</option>
                            <option value="senior">Senior Level</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Job Listings -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        Available Positions
                        <span class="text-sm font-normal text-gray-600 dark:text-gray-400">
                            ({{ $jobs->total() }} total)
                        </span>
                    </h3>

                    @if($jobs->count() > 0)
                        <div class="space-y-4">
                            @foreach($jobs as $job)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-5 hover:shadow-md transition-shadow">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex-1">
                                        <div class="flex items-start gap-4">
                                            @if($job->company->logo)
                                            <img src="{{ Storage::url($job->company->logo) }}" alt="{{ $job->company->name }}" class="w-16 h-16 rounded-lg object-cover">
                                            @else
                                            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-2xl">
                                                {{ substr($job->company->name, 0, 1) }}
                                            </div>
                                            @endif

                                            <div class="flex-1">
                                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">
                                                    {{ $job->title }}
                                                </h3>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                                    {{ $job->company->name }}
                                                    @if($job->location)
                                                    <span class="mx-2">•</span>
                                                    <span>{{ $job->location }}</span>
                                                    @endif
                                                </p>

                                                <div class="flex flex-wrap items-center gap-2 mb-3">
                                                    <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-semibold rounded-full">
                                                        {{ ucfirst(str_replace('_', ' ', $job->job_type)) }}
                                                    </span>
                                                    <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 text-xs font-semibold rounded-full">
                                                        {{ ucfirst($job->experience_level) }} Level
                                                    </span>
                                                    @if($job->salary_min && $job->salary_max)
                                                    <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-semibold rounded-full">
                                                        ${{ number_format($job->salary_min) }} - ${{ number_format($job->salary_max) }}
                                                    </span>
                                                    @endif
                                                </div>

                                                <p class="text-sm text-gray-700 dark:text-gray-300 line-clamp-2">
                                                    {{ $job->description }}
                                                </p>

                                                @if($job->deadline)
                                                <p class="text-xs text-orange-600 dark:text-orange-400 mt-2">
                                                    ⏰ Apply before {{ $job->deadline->format('M d, Y') }}
                                                </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex flex-col gap-2">
                                        <a href="{{ route('student.job.view', $job->id) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors text-center">
                                            View Details
                                        </a>
                                        @php
                                            $hasApplied = \App\Models\JobApplication::where('job_id', $job->id)
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

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $jobs->links() }}
                        </div>
                    @else
                        <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <p>No jobs found</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
