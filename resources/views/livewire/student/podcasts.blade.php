<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                🎙️ Programming Podcasts
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-400 mb-2">
                Curated list of the best developer podcasts
            </p>
            <p class="text-gray-500 dark:text-gray-500 max-w-3xl mx-auto">
                Learn while commuting, exercising, or relaxing. These podcasts feature interviews with industry experts, discussions on latest technologies, and insights into software development.
            </p>
        </div>

        <!-- Stats -->
        <div class="mb-8 grid grid-cols-1 md:grid-cols-2 gap-6 max-w-2xl mx-auto">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-center">
                <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-2">{{ count($podcasts) }}</div>
                <div class="text-gray-600 dark:text-gray-400">Total Podcasts</div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-center">
                <div class="text-3xl font-bold text-green-600 dark:text-green-400 mb-2">{{ collect($podcasts)->unique('frequency')->count() }}</div>
                <div class="text-gray-600 dark:text-gray-400">Update Frequencies</div>
            </div>
        </div>

        <!-- Podcasts Section -->
        <div class="mb-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($podcasts as $podcast)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden group">
                        <!-- Podcast Header -->
                        <div class="bg-gradient-to-r from-purple-500 to-pink-600 p-6">
                            <div class="text-5xl mb-3 text-center">{{ $podcast['icon'] }}</div>
                            <h3 class="text-xl font-bold text-white text-center mb-2">
                                {{ $podcast['name'] }}
                            </h3>
                            <div class="text-purple-100 text-xs text-center space-y-1">
                                <p>{{ $podcast['hosts'] }}</p>
                                <p class="font-semibold">{{ $podcast['frequency'] }}</p>
                            </div>
                        </div>

                        <!-- Podcast Content -->
                        <div class="p-6">
                            <!-- Description -->
                            <div class="mb-4">
                                <p class="text-gray-700 dark:text-gray-300 text-sm line-clamp-3">
                                    {{ $podcast['description'] }}
                                </p>
                            </div>

                            <!-- Topics -->
                            <div class="mb-4">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($podcast['topics'] as $topic)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                            {{ $topic }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Action Button -->
                            <a href="{{ $podcast['url'] }}"
                               target="_blank"
                               class="block w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-4 rounded-lg text-center transition-colors duration-200 group-hover:scale-105 transform">
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Listen Now</span>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Call to Action -->
        <div class="mt-12 bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg shadow-xl p-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">
                🎧 Start Listening Today
            </h2>
            <p class="text-purple-100 text-lg mb-6">
                Subscribe to your favorite podcasts and turn your downtime into learning time. Perfect for multitasking!
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('student.dashboard') }}"
                   class="inline-flex items-center justify-center px-6 py-3 bg-white text-purple-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                    Back to Dashboard
                </a>
                <a href="{{ route('student.roadmaps') }}"
                   class="inline-flex items-center justify-center px-6 py-3 bg-pink-700 text-white font-semibold rounded-lg hover:bg-pink-800 transition-colors">
                    Browse Roadmaps
                </a>
            </div>
        </div>

        <!-- Tips Section -->
        <div class="mt-12 bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">
                💡 Podcast Listening Tips
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center">
                            <span class="text-purple-600 dark:text-purple-300 text-xl">✓</span>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-1">Use a Podcast App</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Subscribe via Apple Podcasts, Spotify, or your favorite app</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-pink-100 dark:bg-pink-900 rounded-full flex items-center justify-center">
                            <span class="text-pink-600 dark:text-pink-300 text-xl">✓</span>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-1">Adjust Playback Speed</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Listen at 1.25x or 1.5x to consume more content</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center">
                            <span class="text-indigo-600 dark:text-indigo-300 text-xl">✓</span>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-1">Take Notes</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Jot down interesting concepts and resources mentioned</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 dark:text-blue-300 text-xl">✓</span>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-1">Make it a Habit</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Listen during commute, workouts, or household chores</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
