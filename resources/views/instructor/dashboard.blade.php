<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Instructor Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 dark:text-gray-400 text-sm">Pending Reviews</div>
                    <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ \App\Models\CodeSubmission::where('submission_status', 'submitted')->count() }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 dark:text-gray-400 text-sm">Pending Questions</div>
                    <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ \App\Models\StudentQuestion::where('status', 'pending')->count() }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 dark:text-gray-400 text-sm">Total Students</div>
                    <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ \App\Models\User::where('role', 'student')->count() }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-600 dark:text-gray-400 text-sm">Reviews Completed</div>
                    <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ \App\Models\CodeReview::where('reviewer_id', auth()->id())->count() }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Quick Actions</h3>
                    <div class="space-y-2">
                        <a href="{{ route('instructor.code-review') }}" class="block px-4 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition">
                            Review Code Submissions
                        </a>
                        <a href="{{ route('instructor.questions') }}" class="block px-4 py-3 bg-amber-500 hover:bg-amber-600 text-white rounded-lg transition">
                            Answer Student Questions
                        </a>
                        <a href="{{ route('instructor.student-progress') }}" class="block px-4 py-3 bg-green-500 hover:bg-green-600 text-white rounded-lg transition">
                            View Student Progress
                        </a>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Recent Submissions</h3>
                    <div class="space-y-3">
                        @foreach(\App\Models\CodeSubmission::latest()->take(5)->get() as $submission)
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                <span class="font-medium text-gray-900 dark:text-white">{{ $submission->student->name }}</span> submitted code
                                <div class="text-xs text-gray-500">{{ $submission->created_at->diffForHumans() }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
