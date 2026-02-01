<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 dark:text-gray-400 text-sm">Total Users</div>
                    <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ \App\Models\User::count() }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 dark:text-gray-400 text-sm">Total Roadmaps</div>
                    <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ \App\Models\Roadmap::count() }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 dark:text-gray-400 text-sm">Total Tasks</div>
                    <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ \App\Models\Task::count() }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 dark:text-gray-400 text-sm">Active Enrollments</div>
                    <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ \App\Models\RoadmapEnrollment::where('status', 'active')->count() }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Quick Actions</h3>
                    <div class="space-y-2">
                        <a href="{{ route('admin.roadmaps') }}" class="block px-4 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition">
                            Manage Roadmaps
                        </a>
                        <a href="{{ route('admin.users') }}" class="block px-4 py-3 bg-purple-500 hover:bg-purple-600 text-white rounded-lg transition">
                            Manage Users
                        </a>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Recent Activity</h3>
                    <div class="space-y-3">
                        @foreach(\App\Models\RoadmapEnrollment::latest()->take(5)->get() as $enrollment)
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                <span class="font-medium text-gray-900 dark:text-white">{{ $enrollment->student->name }}</span> enrolled in
                                <span class="font-medium text-gray-900 dark:text-white">{{ $enrollment->roadmap->title }}</span>
                                <div class="text-xs text-gray-500">{{ $enrollment->started_at->diffForHumans() }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
