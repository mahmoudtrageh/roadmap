<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                📚 Programming Blogs & Resources
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-400 mb-2">
                Curated list of the best programming blogs
            </p>
            <p class="text-gray-500 dark:text-gray-500 max-w-3xl mx-auto">
                Stay updated with industry insights, best practices, and cutting-edge techniques from leading developers and thought leaders. Blogs are categorized by language for your convenience.
            </p>
        </div>

        <!-- Stats -->
        <div class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-center">
                <div class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-2">{{ count($blogs) }}</div>
                <div class="text-gray-600 dark:text-gray-400">Total Blogs</div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-center">
                <div class="text-3xl font-bold text-green-600 dark:text-green-400 mb-2">{{ collect($blogs)->where('language', 'en')->count() }}</div>
                <div class="text-gray-600 dark:text-gray-400">English Blogs</div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-center">
                <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-2">{{ collect($blogs)->where('language', 'ar')->count() }}</div>
                <div class="text-gray-600 dark:text-gray-400">Arabic Blogs</div>
            </div>
        </div>

        <!-- English Blogs Section -->
        <div class="mb-12">
            <div class="flex items-center mb-6">
                <div class="flex-grow border-t border-gray-300 dark:border-gray-700"></div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mx-4 flex items-center gap-2">
                    🌍 English Blogs
                </h2>
                <div class="flex-grow border-t border-gray-300 dark:border-gray-700"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach(collect($blogs)->where('language', 'en') as $blog)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden group">
                        <!-- Blog Header -->
                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6">
                            <div class="text-5xl mb-3 text-center">{{ $blog['icon'] }}</div>
                            <h3 class="text-xl font-bold text-white text-center mb-1">
                                {{ $blog['name'] }}
                            </h3>
                        </div>

                        <!-- Blog Content -->
                        <div class="p-6">
                            <!-- Description -->
                            <div class="mb-4">
                                <p class="text-gray-700 dark:text-gray-300 text-sm">
                                    {{ $blog['description'] }}
                                </p>
                            </div>

                            <!-- Topics -->
                            <div class="mb-4">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($blog['topics'] as $topic)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            {{ $topic }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Action Button -->
                            <a href="{{ $blog['url'] }}"
                               target="_blank"
                               class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg text-center transition-colors duration-200 group-hover:scale-105 transform">
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                    <span>Visit Blog</span>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Arabic Blogs Section -->
        <div class="mb-12">
            <div class="flex items-center mb-6">
                <div class="flex-grow border-t border-gray-300 dark:border-gray-700"></div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mx-4 flex items-center gap-2">
                    🇸🇦 Arabic Blogs
                </h2>
                <div class="flex-grow border-t border-gray-300 dark:border-gray-700"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach(collect($blogs)->where('language', 'ar') as $blog)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden group">
                        <!-- Blog Header -->
                        <div class="bg-gradient-to-r from-purple-500 to-pink-600 p-6">
                            <div class="text-5xl mb-3 text-center">{{ $blog['icon'] }}</div>
                            <h3 class="text-xl font-bold text-white text-center mb-1">
                                {{ $blog['name'] }}
                            </h3>
                            <p class="text-purple-100 text-sm text-center">
                                {{ $blog['name_en'] }}
                            </p>
                        </div>

                        <!-- Blog Content -->
                        <div class="p-6">
                            <!-- Description -->
                            <div class="mb-4">
                                <p class="text-gray-700 dark:text-gray-300 text-sm mb-2 text-right" dir="rtl">
                                    {{ $blog['description_ar'] }}
                                </p>
                                <p class="text-gray-500 dark:text-gray-400 text-xs">
                                    {{ $blog['description_en'] }}
                                </p>
                            </div>

                            <!-- Topics -->
                            <div class="mb-4">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($blog['topics'] as $topic)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                            {{ $topic }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Action Button -->
                            <a href="{{ $blog['url'] }}"
                               target="_blank"
                               class="block w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-4 rounded-lg text-center transition-colors duration-200 group-hover:scale-105 transform">
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                    <span>Visit Blog</span>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Call to Action -->
        <div class="mt-12 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg shadow-xl p-8 text-center">
            <h2 class="text-3xl font-bold text-white mb-4">
                🌟 Keep Learning
            </h2>
            <p class="text-blue-100 text-lg mb-6">
                Bookmark these blogs and make reading a habit. Staying updated with industry trends is crucial for professional growth.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('student.dashboard') }}"
                   class="inline-flex items-center justify-center px-6 py-3 bg-white text-blue-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                    Back to Dashboard
                </a>
                <a href="{{ route('student.roadmaps') }}"
                   class="inline-flex items-center justify-center px-6 py-3 bg-purple-700 text-white font-semibold rounded-lg hover:bg-purple-800 transition-colors">
                    Browse Roadmaps
                </a>
            </div>
        </div>

        <!-- Tips Section -->
        <div class="mt-12 bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">
                💡 Tips for Effective Learning
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 dark:text-blue-300 text-xl">✓</span>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-1">Subscribe to RSS Feeds</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Use an RSS reader to follow multiple blogs efficiently</p>
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
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Dedicate 15-30 minutes daily to read technical articles</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center">
                            <span class="text-purple-600 dark:text-purple-300 text-xl">✓</span>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-1">Take Notes</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Document key learnings and interesting concepts</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900 rounded-full flex items-center justify-center">
                            <span class="text-orange-600 dark:text-orange-300 text-xl">✓</span>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-1">Apply What You Learn</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Try implementing new concepts in your projects</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
