<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                📧 Developer Newsletters
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-400 mb-2">
                Curated list of the best programming newsletters
            </p>
            <p class="text-gray-500 dark:text-gray-500 max-w-3xl mx-auto">
                Stay informed with curated content delivered directly to your inbox. These newsletters feature the latest news, tutorials, tools, and trends in software development.
            </p>
        </div>

        <!-- Stats -->
        <div class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-center">
                <div class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-2">{{ count($newsletters) }}</div>
                <div class="text-gray-600 dark:text-gray-400">Total Newsletters</div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-center">
                <div class="text-3xl font-bold text-green-600 dark:text-green-400 mb-2">{{ collect($newsletters)->where('frequency', 'Weekly')->count() }}</div>
                <div class="text-gray-600 dark:text-gray-400">Weekly</div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-center">
                <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-2">{{ collect($newsletters)->where('frequency', 'Daily')->count() }}</div>
                <div class="text-gray-600 dark:text-gray-400">Daily</div>
            </div>
        </div>

        <!-- Newsletters Section -->
        <div class="mb-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($newsletters as $newsletter)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden group">
                        <!-- Newsletter Header -->
                        <div class="bg-gradient-to-r from-blue-500 to-cyan-600 p-6">
                            <div class="text-5xl mb-3 text-center">{{ $newsletter['icon'] }}</div>
                            <h3 class="text-xl font-bold text-white text-center mb-2">
                                {{ $newsletter['name'] }}
                            </h3>
                            <div class="text-blue-100 text-xs text-center space-y-1">
                                <p class="font-semibold">{{ $newsletter['frequency'] }}</p>
                                @if(isset($newsletter['subscribers']))
                                    <p>{{ $newsletter['subscribers'] }} subscribers</p>
                                @endif
                            </div>
                        </div>

                        <!-- Newsletter Content -->
                        <div class="p-6">
                            <!-- Description -->
                            <div class="mb-4">
                                <p class="text-gray-700 dark:text-gray-300 text-sm line-clamp-3">
                                    {{ $newsletter['description'] }}
                                </p>
                            </div>

                            <!-- Topics -->
                            <div class="mb-4">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($newsletter['topics'] as $topic)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            {{ $topic }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Action Button -->
                            <a href="{{ $newsletter['url'] }}"
                               target="_blank"
                               class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg text-center transition-colors duration-200 group-hover:scale-105 transform">
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>Subscribe</span>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Call to Action -->
        <div class="mt-12 bg-gradient-to-r from-blue-600 to-cyan-600 rounded-lg shadow-xl p-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">
                📬 Get Curated Content
            </h2>
            <p class="text-blue-100 text-lg mb-6">
                Subscribe to newsletters that match your interests and receive the best content directly in your inbox. Save time by having experts curate content for you!
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('student.dashboard') }}"
                   class="inline-flex items-center justify-center px-6 py-3 bg-white text-blue-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                    Back to Dashboard
                </a>
                <a href="{{ route('student.roadmaps') }}"
                   class="inline-flex items-center justify-center px-6 py-3 bg-cyan-700 text-white font-semibold rounded-lg hover:bg-cyan-800 transition-colors">
                    Browse Roadmaps
                </a>
            </div>
        </div>

        <!-- Tips Section -->
        <div class="mt-12 bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">
                💡 Newsletter Management Tips
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 dark:text-blue-300 text-xl">✓</span>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-1">Use a Separate Email</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Create a dedicated email for newsletters to keep your inbox organized</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                            <span class="text-green-600 dark:text-green-300 text-xl">✓</span>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-1">Set Reading Time</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Schedule specific times each week to catch up on newsletters</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center">
                            <span class="text-purple-600 dark:text-purple-300 text-xl">✓</span>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-1">Be Selective</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Start with 3-5 newsletters and adjust based on your capacity</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900 rounded-full flex items-center justify-center">
                            <span class="text-orange-600 dark:text-orange-300 text-xl">✓</span>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-1">Archive for Later</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Save interesting articles to read when you have more time</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
