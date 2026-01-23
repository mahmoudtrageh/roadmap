<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
        @endif

        <!-- Header Section -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Achievement Board</h2>
                        <p class="text-gray-600 mt-1">Track your accomplishments and earn rewards</p>
                    </div>
                    <button
                        wire:click="checkForNewAchievements"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                        Check for New Achievements
                    </button>
                </div>

                <!-- Stats Summary -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-yellow-100 text-sm font-medium">Total Points</p>
                                <p class="text-3xl font-bold mt-2">{{ $totalPoints }}</p>
                            </div>
                            <div class="text-4xl">🏆</div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm font-medium">Achievements Earned</p>
                                <p class="text-3xl font-bold mt-2">{{ $earnedAchievements }}</p>
                                <p class="text-green-100 text-xs mt-1">out of {{ $totalAchievements }}</p>
                            </div>
                            <div class="text-4xl">✓</div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-sm font-medium">Completion Rate</p>
                                <p class="text-3xl font-bold mt-2">
                                    {{ $totalAchievements > 0 ? round(($earnedAchievements / $totalAchievements) * 100) : 0 }}%
                                </p>
                            </div>
                            <div class="text-4xl">📊</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Next Achievements Section -->
        @if(count($nextAchievements) > 0)
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Almost There!</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($nextAchievements as $achievement)
                    <div class="border border-blue-200 bg-blue-50 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <div class="text-3xl opacity-60">{{ $achievement['badge_icon'] }}</div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900">{{ $achievement['name'] }}</h4>
                                <p class="text-xs text-gray-600 mt-1">{{ $achievement['description'] }}</p>
                                <div class="mt-2">
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div
                                            class="bg-blue-600 h-2 rounded-full"
                                            style="width: {{ $achievement['progress'] }}%">
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">{{ $achievement['progress'] }}% complete</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <!-- Filters and Sorting -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <!-- Filter Buttons -->
                    <div class="flex gap-2">
                        <button
                            wire:click="setFilter('all')"
                            class="px-4 py-2 rounded-lg text-sm font-medium
                                {{ $filterType === 'all' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            All ({{ $totalAchievements }})
                        </button>
                        <button
                            wire:click="setFilter('earned')"
                            class="px-4 py-2 rounded-lg text-sm font-medium
                                {{ $filterType === 'earned' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Earned ({{ $earnedAchievements }})
                        </button>
                        <button
                            wire:click="setFilter('locked')"
                            class="px-4 py-2 rounded-lg text-sm font-medium
                                {{ $filterType === 'locked' ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            Locked ({{ $totalAchievements - $earnedAchievements }})
                        </button>
                    </div>

                    <!-- Sort Dropdown -->
                    <div class="flex items-center gap-2">
                        <label class="text-sm font-medium text-gray-700">Sort by:</label>
                        <select
                            wire:change="setSorting($event.target.value)"
                            class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="points" {{ $sortBy === 'points' ? 'selected' : '' }}>Points</option>
                            <option value="name" {{ $sortBy === 'name' ? 'selected' : '' }}>Name</option>
                            <option value="type" {{ $sortBy === 'type' ? 'selected' : '' }}>Type</option>
                            <option value="progress" {{ $sortBy === 'progress' ? 'selected' : '' }}>Progress</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Achievements Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($achievements as $achievement)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg
                {{ $achievement['earned'] ? 'border-2 border-yellow-400' : 'opacity-75' }}">
                <div class="p-6">
                    <!-- Achievement Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-start gap-3">
                            <div class="text-4xl {{ $achievement['earned'] ? '' : 'grayscale opacity-50' }}">
                                {{ $achievement['badge_icon'] }}
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900">{{ $achievement['name'] }}</h3>
                                <p class="text-xs text-gray-500 mt-1">
                                    <span class="bg-purple-100 text-purple-800 px-2 py-0.5 rounded">
                                        {{ ucfirst($achievement['type']) }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <!-- Points Badge -->
                        <div class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $achievement['points'] }} pts
                        </div>
                    </div>

                    <!-- Description -->
                    <p class="text-sm text-gray-600 mb-4">{{ $achievement['description'] }}</p>

                    @if($achievement['earned'])
                    <!-- Earned Badge -->
                    <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                        <div class="flex items-center justify-between">
                            <span class="text-green-800 text-sm font-semibold flex items-center gap-2">
                                <span class="text-lg">✓</span>
                                Earned
                            </span>
                            <span class="text-xs text-green-600">
                                {{ \Carbon\Carbon::parse($achievement['earned_at'])->format('M d, Y') }}
                            </span>
                        </div>
                    </div>
                    @else
                    <!-- Progress Bar -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-xs font-medium text-gray-700">Progress</span>
                            <span class="text-xs font-semibold text-gray-900">{{ $achievement['progress'] }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div
                                class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full transition-all duration-500"
                                style="width: {{ $achievement['progress'] }}%">
                            </div>
                        </div>

                        @if($achievement['progress'] === 0)
                        <p class="text-xs text-gray-500 mt-2 text-center">🔒 Locked</p>
                        @elseif($achievement['progress'] >= 75)
                        <p class="text-xs text-blue-600 mt-2 text-center">Almost there! Keep going!</p>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        @if(count($achievements) === 0)
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-12 text-center">
                <div class="text-6xl mb-4">🏆</div>
                <p class="text-gray-600 text-lg">No achievements found with the current filter.</p>
            </div>
        </div>
        @endif
    </div>
</div>
