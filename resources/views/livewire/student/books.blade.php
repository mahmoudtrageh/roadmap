<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-gradient-to-r from-orange-500 to-pink-600 rounded-lg shadow-xl p-8 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold mb-2">📚 Programming Books</h1>
                    <p class="text-orange-100 text-lg">Curated collection of essential programming books</p>
                </div>
                <div class="hidden md:block">
                    <div class="text-center">
                        <div class="text-5xl font-bold">{{ count($books) }}</div>
                        <div class="text-sm text-orange-100">Books Recommended</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <div class="text-2xl font-bold text-blue-600">{{ collect($books)->where('level', 'Beginner')->count() }}</div>
                <div class="text-sm text-gray-600">Beginner Books</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <div class="text-2xl font-bold text-yellow-600">{{ collect($books)->where('level', 'Intermediate')->count() + collect($books)->where('level', 'Intermediate to Advanced')->count() }}</div>
                <div class="text-sm text-gray-600">Intermediate</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <div class="text-2xl font-bold text-red-600">{{ collect($books)->where('level', 'Advanced')->count() }}</div>
                <div class="text-sm text-gray-600">Advanced</div>
            </div>
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <div class="text-2xl font-bold text-green-600">{{ collect($books)->where('level', 'All Levels')->count() }}</div>
                <div class="text-sm text-gray-600">All Levels</div>
            </div>
        </div>

        <!-- Books Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach($books as $book)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300 border-l-4 border-orange-500">
                    <div class="p-6">
                        <!-- Icon & Title -->
                        <div class="flex items-start mb-4">
                            <div class="text-4xl mr-3">{{ $book['icon'] }}</div>
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $book['title'] }}</h3>
                                <p class="text-sm text-gray-600 font-medium">{{ $book['author'] }}</p>
                            </div>
                        </div>

                        <!-- Description -->
                        <p class="text-gray-700 text-sm mb-4 leading-relaxed">{{ $book['description'] }}</p>

                        <!-- Book Details -->
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-xs text-gray-600">
                                <span class="font-semibold mr-2">Level:</span>
                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                    @if($book['level'] === 'Beginner') bg-green-100 text-green-800
                                    @elseif(str_contains($book['level'], 'Intermediate')) bg-yellow-100 text-yellow-800
                                    @elseif($book['level'] === 'Advanced') bg-red-100 text-red-800
                                    @else bg-blue-100 text-blue-800 @endif">
                                    {{ $book['level'] }}
                                </span>
                            </div>
                            <div class="flex items-center text-xs text-gray-600">
                                <span class="font-semibold mr-2">📄 Pages:</span>
                                <span>{{ $book['pages'] }}</span>
                                <span class="ml-3 font-semibold mr-2">📅 Year:</span>
                                <span>{{ $book['year'] }}</span>
                            </div>
                            @if(isset($book['isbn']) && $book['isbn'] !== 'Various')
                            <div class="flex items-center text-xs text-gray-600">
                                <span class="font-semibold mr-2">ISBN:</span>
                                <span class="font-mono">{{ $book['isbn'] }}</span>
                            </div>
                            @endif
                        </div>

                        <!-- Topics -->
                        <div class="mb-4">
                            <div class="flex flex-wrap gap-2">
                                @foreach($book['topics'] as $topic)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                        {{ $topic }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            <a href="https://www.google.com/search?q={{ urlencode($book['title'] . ' ' . $book['author'] . ' book') }}"
                               target="_blank"
                               class="flex-1 bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm font-medium text-center transition-colors">
                                Search Online
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Reading Tips -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg shadow-lg p-6 mb-8 border-l-4 border-blue-500">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">📖 Reading Tips for Developers</h2>
            <div class="grid md:grid-cols-2 gap-4">
                <div class="space-y-3">
                    <div class="flex items-start">
                        <span class="text-blue-500 mr-2">✓</span>
                        <p class="text-gray-700"><strong>Start with your level:</strong> Choose books that match your current skill level</p>
                    </div>
                    <div class="flex items-start">
                        <span class="text-blue-500 mr-2">✓</span>
                        <p class="text-gray-700"><strong>Code along:</strong> Type out examples and experiment with the code</p>
                    </div>
                    <div class="flex items-start">
                        <span class="text-blue-500 mr-2">✓</span>
                        <p class="text-gray-700"><strong>Take notes:</strong> Summarize key concepts in your own words</p>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex items-start">
                        <span class="text-blue-500 mr-2">✓</span>
                        <p class="text-gray-700"><strong>Build projects:</strong> Apply what you learn to real projects</p>
                    </div>
                    <div class="flex items-start">
                        <span class="text-blue-500 mr-2">✓</span>
                        <p class="text-gray-700"><strong>Re-read classics:</strong> Revisit important books as you gain experience</p>
                    </div>
                    <div class="flex items-start">
                        <span class="text-blue-500 mr-2">✓</span>
                        <p class="text-gray-700"><strong>Join discussions:</strong> Discuss concepts with other developers</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Free Resources Note -->
        <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-8">
            <h3 class="text-lg font-bold text-green-900 mb-2">🌟 Free Books Available!</h3>
            <p class="text-green-800 mb-2">Several books in this list are available free online:</p>
            <ul class="list-disc list-inside text-green-800 space-y-1">
                <li><strong>Eloquent JavaScript</strong> - Available at eloquentjavascript.net</li>
                <li><strong>You Don't Know JS</strong> - Free on GitHub</li>
                <li><strong>Automate the Boring Stuff with Python</strong> - Available at automatetheboringstuff.com</li>
            </ul>
        </div>

        <!-- Call to Action -->
        <div class="bg-gradient-to-r from-orange-500 to-pink-600 rounded-lg shadow-xl p-8 text-white text-center">
            <h2 class="text-3xl font-bold mb-4">📚 Ready to Start Reading?</h2>
            <p class="text-orange-100 mb-6 text-lg">Pick a book that matches your learning goals and dive in! Remember, the best book is the one you actually finish.</p>
            <div class="flex justify-center gap-4">
                <a href="{{ route('student.roadmaps') }}" class="bg-white text-orange-600 px-8 py-3 rounded-lg font-bold hover:bg-orange-50 transition-colors">
                    View Roadmaps
                </a>
                <a href="{{ route('student.youtube-channels') }}" class="bg-orange-600 text-white px-8 py-3 rounded-lg font-bold hover:bg-orange-700 transition-colors border-2 border-white">
                    Watch Videos
                </a>
            </div>
        </div>
    </div>
</div>
