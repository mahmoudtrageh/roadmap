<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-900">{{ $task->title }}</h2>
                        <p class="mt-1 text-sm text-gray-600">{{ $task->roadmap->title }} - Day {{ $task->day_number }}</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('student.tasks', ['roadmapId' => $task->roadmap_id]) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg font-medium transition duration-150">
                            Back to Tasks
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Upload Area -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Current Submission Status -->
                @if($existingSubmission && $existingSubmission->file_path)
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-blue-900 mb-2">📁 Current Submission</h3>
                                <div class="space-y-2 text-sm text-blue-800">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="font-medium">{{ $existingSubmission->original_filename }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>Uploaded {{ $existingSubmission->updated_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($existingSubmission->submission_status === 'approved') bg-green-100 text-green-800
                                            @elseif($existingSubmission->submission_status === 'submitted') bg-blue-100 text-blue-800
                                            @elseif($existingSubmission->submission_status === 'needs_revision') bg-yellow-100 text-yellow-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst(str_replace('_', ' ', $existingSubmission->submission_status)) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <button wire:click="downloadSubmission" class="text-blue-600 hover:text-blue-800 p-2" title="Download">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                </button>
                                <button wire:click="deleteSubmission" onclick="return confirm('Delete this submission?')" class="text-red-600 hover:text-red-800 p-2" title="Delete">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- File Upload Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">📤 Upload Your Code</h3>

                        <!-- Single File Upload -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="inline-flex items-center">
                                    Single File Upload
                                </span>
                                <span class="text-gray-500 text-xs block mt-1">(HTML, CSS, JS, Python, etc.)</span>
                            </label>
                            <div class="flex items-center gap-3">
                                <input type="file" wire:model="file" class="block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-lg file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-blue-50 file:text-blue-700
                                    hover:file:bg-blue-100 cursor-pointer">
                                <button wire:click="submitFile" wire:loading.attr="disabled" wire:target="file,submitFile"
                                    class="bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 text-white px-8 py-2.5 rounded-lg font-semibold transition duration-150 whitespace-nowrap shadow-lg">
                                    <span wire:loading.remove wire:target="file,submitFile">✅ Submit File</span>
                                    <span wire:loading wire:target="file,submitFile">Submitting...</span>
                                </button>
                            </div>
                            <div wire:loading wire:target="file" class="mt-2">
                                <div class="flex items-center text-sm text-blue-600">
                                    <svg class="animate-spin h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Processing...
                                </div>
                            </div>
                            @error('file') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            <p class="mt-2 text-xs text-gray-500">
                                Supported: .html, .css, .js, .py, .java, .php, .cpp, .cs, .rb, .go, .rs, .ts, .txt, .json, .xml, .md (Max: 10MB)
                            </p>
                        </div>

                        <div class="border-t pt-6">
                            <!-- ZIP File Upload -->
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <span class="inline-flex items-center">
                                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded mr-2">OR</span>
                                    Project ZIP Upload
                                </span>
                                <span class="text-gray-500 text-xs block mt-1">(For multi-file projects)</span>
                            </label>
                            <div class="flex items-center gap-3">
                                <input type="file" wire:model="zipFile" accept=".zip" class="block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-lg file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-green-50 file:text-green-700
                                    hover:file:bg-green-100 cursor-pointer">
                                <button wire:click="submitZip" wire:loading.attr="disabled" wire:target="zipFile,submitZip"
                                    class="bg-green-600 hover:bg-green-700 disabled:bg-gray-400 text-white px-8 py-2.5 rounded-lg font-semibold transition duration-150 whitespace-nowrap shadow-lg">
                                    <span wire:loading.remove wire:target="zipFile,submitZip">📦 Submit ZIP</span>
                                    <span wire:loading wire:target="zipFile,submitZip">Submitting...</span>
                                </button>
                            </div>
                            <div wire:loading wire:target="zipFile" class="mt-2">
                                <div class="flex items-center text-sm text-green-600">
                                    <svg class="animate-spin h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Processing...
                                </div>
                            </div>
                            @error('zipFile') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            <p class="mt-2 text-xs text-gray-500">
                                Compress your entire project folder into a .zip file (Max: 50MB)
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Submission Notes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Notes for Instructor (Optional)
                        </label>
                        <textarea wire:model="submissionNotes" rows="4"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Add any notes about your submission, questions, or areas you'd like feedback on..."></textarea>
                        <p class="mt-2 text-xs text-gray-500">
                            Your notes will be saved automatically when you submit your file above.
                        </p>
                    </div>
                </div>

                <!-- Code Reviews -->
                @if($reviews->count() > 0)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">💬 Code Reviews</h3>
                            <div class="space-y-4">
                                @foreach($reviews as $review)
                                    <div class="border rounded-lg p-4
                                        @if($review->status === 'approved') border-green-300 bg-green-50
                                        @elseif($review->status === 'needs_revision') border-yellow-300 bg-yellow-50
                                        @else border-gray-300 bg-gray-50 @endif">
                                        <div class="flex justify-between items-start mb-3">
                                            <div>
                                                <span class="font-medium text-gray-900">{{ $review->reviewer->name }}</span>
                                                <span class="ml-2 text-sm text-gray-600">Rating: {{ $review->rating }}/10</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    @if($review->status === 'approved') bg-green-100 text-green-800
                                                    @elseif($review->status === 'needs_revision') bg-yellow-100 text-yellow-800
                                                    @else bg-gray-100 text-gray-800 @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $review->status)) }}
                                                </span>
                                                <span class="text-xs text-gray-500">{{ $review->reviewed_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                        <p class="text-sm text-gray-700">{{ $review->feedback }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Guide -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h3 class="text-sm font-semibold text-blue-900 mb-3">💡 How to Submit Code</h3>
                    <div class="space-y-3 text-xs text-blue-800">
                        <div class="flex items-start gap-2">
                            <span class="bg-blue-600 text-white rounded-full w-5 h-5 flex items-center justify-center flex-shrink-0 font-bold">1</span>
                            <p>Write your code in <strong>VS Code</strong> locally and test it</p>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="bg-blue-600 text-white rounded-full w-5 h-5 flex items-center justify-center flex-shrink-0 font-bold">2</span>
                            <p>Click "Browse" and select your file (or ZIP for projects)</p>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="bg-blue-600 text-white rounded-full w-5 h-5 flex items-center justify-center flex-shrink-0 font-bold">3</span>
                            <p>Add notes for instructor (optional)</p>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="bg-blue-600 text-white rounded-full w-5 h-5 flex items-center justify-center flex-shrink-0 font-bold">4</span>
                            <p>Click <strong>"✅ Submit File"</strong> or <strong>"📦 Submit ZIP"</strong> button</p>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-blue-200">
                        <p class="text-xs text-blue-700"><strong>Note:</strong> Your submission is completed in one step. Click the submit button and your task will be marked as complete!</p>
                    </div>
                </div>

                <!-- Task Description -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">📋 Task Description</h3>
                        <div class="text-sm text-gray-700 prose prose-sm max-w-none">
                            {!! nl2br(e($task->description)) !!}
                        </div>
                    </div>
                </div>

                <!-- Learning Resources -->
                @if($task->resources_links && count($task->resources_links) > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">📚 Learning Resources</h3>
                        <div class="space-y-2">
                            @foreach($task->resources_links as $resource)
                                @php
                                    $url = is_array($resource) ? ($resource['url'] ?? '') : $resource;
                                    $title = is_array($resource) ? ($resource['title'] ?? null) : null;

                                    if (!$title) {
                                        if (strpos($url, 'developer.mozilla.org') !== false) {
                                            $title = 'MDN Documentation';
                                        } elseif (strpos($url, 'w3schools.com') !== false) {
                                            $title = 'W3Schools Tutorial';
                                        } elseif (strpos($url, 'youtube.com') !== false) {
                                            $title = 'Video Tutorial';
                                        } else {
                                            $domain = parse_url($url, PHP_URL_HOST);
                                            $title = ucfirst(str_replace(['www.', '.com', '.org'], '', $domain ?? 'Resource'));
                                        }
                                    }
                                @endphp
                                <a href="{{ $url }}" target="_blank" class="flex items-center text-sm text-blue-600 hover:text-blue-800 hover:underline">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                    {{ $title }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Task Details -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">ℹ️ Task Details</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Type:</span>
                                <span class="font-medium">{{ ucfirst($task->task_type) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Category:</span>
                                <span class="font-medium">{{ $task->category }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Estimated Time:</span>
                                <span class="font-medium">{{ $task->estimated_time_minutes }} min</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status:</span>
                                <span class="font-medium
                                    @if($taskCompletion->status === 'completed') text-green-600
                                    @elseif($taskCompletion->status === 'in_progress') text-blue-600
                                    @else text-gray-600 @endif">
                                    {{ ucfirst($taskCompletion->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
