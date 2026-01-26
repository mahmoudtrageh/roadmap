<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">Leaderboards</h2>

                <!-- Board Selector -->
                <div class="flex flex-wrap gap-2 mb-6">
                    <button
                        wire:click="switchBoard('points')"
                        class="px-4 py-2 rounded-lg font-medium transition-colors {{ $selectedBoard === 'points' ? 'bg-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}"
                    >
                        Total Points
                    </button>
                    <button
                        wire:click="switchBoard('streak')"
                        class="px-4 py-2 rounded-lg font-medium transition-colors {{ $selectedBoard === 'streak' ? 'bg-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}"
                    >
                        Current Streak
                    </button>
                    <button
                        wire:click="switchBoard('completion')"
                        class="px-4 py-2 rounded-lg font-medium transition-colors {{ $selectedBoard === 'completion' ? 'bg-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}"
                    >
                        Tasks Completed
                    </button>
                    <button
                        wire:click="switchBoard('quality')"
                        class="px-4 py-2 rounded-lg font-medium transition-colors {{ $selectedBoard === 'quality' ? 'bg-blue-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' }}"
                    >
                        Code Quality
                    </button>
                </div>

                <!-- Leaderboard Table -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Rank</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Student</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Level</th>
                                @if($selectedBoard === 'points')
                                    <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700 dark:text-gray-300">Points</th>
                                @elseif($selectedBoard === 'streak')
                                    <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700 dark:text-gray-300">Current Streak</th>
                                    <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700 dark:text-gray-300">Longest Streak</th>
                                @elseif($selectedBoard === 'completion')
                                    <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700 dark:text-gray-300">Tasks Completed</th>
                                @elseif($selectedBoard === 'quality')
                                    <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700 dark:text-gray-300">Avg Rating</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topUsers as $user)
                                <tr class="border-b border-gray-100 dark:border-gray-700 {{ $user['is_current_user'] ? 'bg-blue-50 dark:bg-blue-900/20' : 'hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
                                    <!-- Rank -->
                                    <td class="px-4 py-4">
                                        <div class="flex items-center">
                                            @if($user['rank'] === 1)
                                                <span class="text-2xl">🥇</span>
                                            @elseif($user['rank'] === 2)
                                                <span class="text-2xl">🥈</span>
                                            @elseif($user['rank'] === 3)
                                                <span class="text-2xl">🥉</span>
                                            @else
                                                <span class="text-lg font-bold text-gray-600 dark:text-gray-400">{{ $user['rank'] }}</span>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Student -->
                                    <td class="px-4 py-4">
                                        <div class="flex items-center gap-3">
                                            @if($user['avatar'])
                                                <img src="{{ Storage::url($user['avatar']) }}" alt="{{ $user['name'] }}" class="w-10 h-10 rounded-full">
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                                                    {{ substr($user['name'], 0, 1) }}
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $user['name'] }}
                                                    @if($user['is_current_user'])
                                                        <span class="text-xs text-blue-600 dark:text-blue-400">(You)</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Level -->
                                    <td class="px-4 py-4">
                                        <div class="text-sm">
                                            <div class="font-semibold text-gray-900 dark:text-gray-100">Level {{ $user['level'] }}</div>
                                            <div class="text-gray-500 dark:text-gray-400">{{ $user['level_title'] }}</div>
                                        </div>
                                    </td>

                                    <!-- Stats -->
                                    @if($selectedBoard === 'points')
                                        <td class="px-4 py-4 text-right">
                                            <span class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ number_format($user['points']) }}</span>
                                        </td>
                                    @elseif($selectedBoard === 'streak')
                                        <td class="px-4 py-4 text-right">
                                            <span class="text-lg font-bold text-orange-600 dark:text-orange-400">{{ $user['streak'] }} days</span>
                                        </td>
                                        <td class="px-4 py-4 text-right">
                                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $user['longest_streak'] }} days</span>
                                        </td>
                                    @elseif($selectedBoard === 'completion')
                                        <td class="px-4 py-4 text-right">
                                            <span class="text-lg font-bold text-green-600 dark:text-green-400">{{ $user['completed_count'] }}</span>
                                        </td>
                                    @elseif($selectedBoard === 'quality')
                                        <td class="px-4 py-4 text-right">
                                            <div class="flex items-center justify-end gap-1">
                                                <span class="text-lg font-bold text-yellow-600 dark:text-yellow-400">{{ $user['avg_quality'] }}</span>
                                                <span class="text-sm text-gray-500 dark:text-gray-400">/10</span>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                        No students on the leaderboard yet. Enable leaderboard visibility in your profile to appear here!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Current User Rank (if not in top 10) -->
                @if($currentUserRank)
                    <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Your Ranking</h3>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <span class="text-xl font-bold text-gray-900 dark:text-gray-100">#{{ $currentUserRank['rank'] }}</span>
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $currentUserRank['name'] }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Level {{ $currentUserRank['level'] }} - {{ $currentUserRank['level_title'] }}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                @if($selectedBoard === 'points')
                                    <span class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ number_format($currentUserRank['points']) }} points</span>
                                @elseif($selectedBoard === 'streak')
                                    <span class="text-lg font-bold text-orange-600 dark:text-orange-400">{{ $currentUserRank['streak'] }} days</span>
                                @elseif($selectedBoard === 'completion')
                                    <span class="text-lg font-bold text-green-600 dark:text-green-400">{{ $currentUserRank['completed_count'] }} tasks</span>
                                @elseif($selectedBoard === 'quality')
                                    <span class="text-lg font-bold text-yellow-600 dark:text-yellow-400">{{ $currentUserRank['avg_quality'] }}/10</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Privacy Notice -->
                <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Privacy Settings</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Want to appear on the leaderboard? Enable leaderboard visibility in your
                        <a href="{{ route('profile.edit') }}" class="text-blue-600 dark:text-blue-400 hover:underline">profile settings</a>.
                        You can also choose a custom display name.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
