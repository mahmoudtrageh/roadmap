<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                📺 Recommended YouTube Channels
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-400 mb-2">
                Curated list of the best programming channels
            </p>
            <p class="text-gray-500 dark:text-gray-500 max-w-3xl mx-auto">
                Follow these channels to stay updated with the latest technologies and learn from experienced developers. Channels are categorized by language for your convenience.
            </p>
        </div>

        <!-- Stats -->
        <div class="mb-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-center">
                <div class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-2">{{ count($channels) }}</div>
                <div class="text-gray-600 dark:text-gray-400">Total Channels</div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-center">
                <div class="text-3xl font-bold text-green-600 dark:text-green-400 mb-2">{{ collect($channels)->where('language', 'en')->count() }}</div>
                <div class="text-gray-600 dark:text-gray-400">English Channels</div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-center">
                <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 mb-2">{{ collect($channels)->where('language', 'ar')->count() }}</div>
                <div class="text-gray-600 dark:text-gray-400">Arabic Channels</div>
            </div>
        </div>

        <!-- English Channels Section -->
        <div class="mb-12">
            <div class="flex items-center mb-6">
                <div class="flex-grow border-t border-gray-300 dark:border-gray-700"></div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mx-4 flex items-center gap-2">
                    🌍 English Channels
                </h2>
                <div class="flex-grow border-t border-gray-300 dark:border-gray-700"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach(collect($channels)->where('language', 'en') as $channel)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden group">
                        <!-- Channel Header -->
                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6">
                            <div class="text-5xl mb-3 text-center">{{ $channel['icon'] }}</div>
                            <h3 class="text-xl font-bold text-white text-center mb-1">
                                {{ $channel['name'] }}
                            </h3>
                        </div>

                        <!-- Channel Content -->
                        <div class="p-6">
                            <!-- Description -->
                            <div class="mb-4">
                                <p class="text-gray-700 dark:text-gray-300 text-sm">
                                    {{ $channel['description'] }}
                                </p>
                            </div>

                            <!-- Topics -->
                            <div class="mb-4">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($channel['topics'] as $topic)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            {{ $topic }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Action Button -->
                            <a href="{{ $channel['url'] }}"
                               target="_blank"
                               class="block w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-4 rounded-lg text-center transition-colors duration-200 group-hover:scale-105 transform">
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                    </svg>
                                    <span>Visit Channel</span>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Arabic Channels Section -->
        <div class="mb-12">
            <div class="flex items-center mb-6">
                <div class="flex-grow border-t border-gray-300 dark:border-gray-700"></div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mx-4 flex items-center gap-2">
                    🇸🇦 Arabic Channels
                </h2>
                <div class="flex-grow border-t border-gray-300 dark:border-gray-700"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach(collect($channels)->where('language', 'ar') as $channel)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden group">
                        <!-- Channel Header -->
                        <div class="bg-gradient-to-r from-purple-500 to-pink-600 p-6">
                            <div class="text-5xl mb-3 text-center">{{ $channel['icon'] }}</div>
                            <h3 class="text-xl font-bold text-white text-center mb-1">
                                {{ $channel['name'] }}
                            </h3>
                            <p class="text-purple-100 text-sm text-center">
                                {{ $channel['name_en'] }}
                            </p>
                        </div>

                        <!-- Channel Content -->
                        <div class="p-6">
                            <!-- Description -->
                            <div class="mb-4">
                                <p class="text-gray-700 dark:text-gray-300 text-sm mb-2 text-right" dir="rtl">
                                    {{ $channel['description_ar'] }}
                                </p>
                                <p class="text-gray-500 dark:text-gray-400 text-xs">
                                    {{ $channel['description_en'] }}
                                </p>
                            </div>

                            <!-- Topics -->
                            <div class="mb-4">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($channel['topics'] as $topic)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                            {{ $topic }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Action Button -->
                            <a href="{{ $channel['url'] }}"
                               target="_blank"
                               class="block w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-4 rounded-lg text-center transition-colors duration-200 group-hover:scale-105 transform">
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                    </svg>
                                    <span>Visit Channel</span>
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
                🌟 Free Learning Resources
            </h2>
            <p class="text-blue-100 text-lg mb-6">
                Subscribe to these channels and accelerate your learning journey with free, high-quality content
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
                💡 Tips for Maximum Benefit
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 dark:text-blue-300 text-xl">✓</span>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-1">Subscribe to Channels</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Click the subscribe button to get notified of new content</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                            <span class="text-green-600 dark:text-green-300 text-xl">✓</span>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-1">Enable Notifications</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Turn on the bell icon to never miss an update</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900 rounded-full flex items-center justify-center">
                            <span class="text-purple-600 dark:text-purple-300 text-xl">✓</span>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-1">Practice What You Learn</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Programming requires continuous hands-on practice</p>
                    </div>
                </div>
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900 rounded-full flex items-center justify-center">
                            <span class="text-orange-600 dark:text-orange-300 text-xl">✓</span>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-1">Code Every Day</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Consistency is key - even 30 minutes daily makes a difference</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
