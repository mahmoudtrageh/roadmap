<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white">🏆 Leaderboard</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Compete with other students and climb the rankings!</p>
        </div>

        <!-- My Stats Card -->
        @if($myStats)
        <div class="mb-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg shadow-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold mb-2">Your Stats</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div>
                            <p class="text-blue-100 text-sm">Rank</p>
                            <p class="text-3xl font-bold">#{!! $myRank !!}</p>
                        </div>
                        <div>
                            <p class="text-blue-100 text-sm">Total Points</p>
                            <p class="text-3xl font-bold">{{ number_format($myStats['points']) }}</p>
                        </div>
                        <div>
                            <p class="text-blue-100 text-sm">Tasks</p>
                            <p class="text-3xl font-bold">{{ $myStats['completed_tasks'] }}</p>
                        </div>
                        <div>
                            <p class="text-blue-100 text-sm">Avg. Grade</p>
                            <p class="text-3xl font-bold">{{ number_format($myStats['average_grade'], 1) }}%</p>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block text-7xl">
                    @if($myRank === 1)
                        🥇
                    @elseif($myRank === 2)
                        🥈
                    @elseif($myRank === 3)
                        🥉
                    @else
                        🎯
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- Points Legend -->
        <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm p-4">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-2">How Points Work:</h3>
            <div class="flex flex-wrap gap-4 text-sm text-gray-600 dark:text-gray-400">
                <span>✅ <strong>10 points</strong> per task completed</span>
                <span>🗺️ <strong>100 points</strong> per roadmap completed</span>
            </div>
        </div>

        <!-- Leaderboard Table -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Rank
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Student
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Points
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Tasks
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Roadmaps
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Avg. Grade
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($leaderboard as $student)
                        <tr class="{{ $student['is_me'] ? 'bg-blue-50 dark:bg-blue-900/20' : '' }} hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <!-- Rank -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($student['rank'] === 1)
                                        <span class="text-2xl">🥇</span>
                                    @elseif($student['rank'] === 2)
                                        <span class="text-2xl">🥈</span>
                                    @elseif($student['rank'] === 3)
                                        <span class="text-2xl">🥉</span>
                                    @else
                                        <span class="text-lg font-semibold text-gray-500 dark:text-gray-400">#{{ $student['rank'] }}</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Student Name -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white font-bold">
                                            {{ substr($student['name'], 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $student['name'] }}
                                            @if($student['is_me'])
                                                <span class="ml-2 px-2 py-1 text-xs bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full">You</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Points -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="text-lg font-bold text-gray-900 dark:text-white">
                                    {{ number_format($student['points']) }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">points</div>
                            </td>

                            <!-- Tasks -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ $student['completed_tasks'] }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">completed</div>
                            </td>

                            <!-- Roadmaps -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ $student['completed_roadmaps'] }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">completed</div>
                            </td>

                            <!-- Average Grade -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ number_format($student['average_grade'], 1) }}%
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">exam avg</div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Empty State -->
        @if(count($leaderboard) === 0)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-12 text-center">
            <div class="text-6xl mb-4">🏆</div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No Students Yet!</h3>
            <p class="text-gray-600 dark:text-gray-400">Start learning to appear on the leaderboard</p>
        </div>
        @endif

        <!-- Motivational Footer -->
        <div class="mt-8 text-center text-sm text-gray-500 dark:text-gray-400">
            <p>💪 Keep learning and climbing the ranks! Complete tasks and finish roadmaps to earn more points.</p>
        </div>
    </div>
</div>
