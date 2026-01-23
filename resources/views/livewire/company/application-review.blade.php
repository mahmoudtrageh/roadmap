<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Application Review') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session()->has('message'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('message') }}
                </div>
            @endif

            <!-- Filter -->
            <div class="mb-6 bg-white dark:bg-gray-800 p-4 rounded-lg">
                <select wire:model.live="filterStatus" class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                    <option value="all">All Applications</option>
                    <option value="pending">Pending</option>
                    <option value="reviewing">Reviewing</option>
                    <option value="accepted">Accepted</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>

            <!-- Applications List -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    Applications ({{ $applications->total() }})
                </h3>

                @if($applications->count() > 0)
                    <div class="space-y-4">
                        @foreach($applications as $application)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900 dark:text-white">{{ $application->student->name }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                        Applied for: <strong>{{ $application->jobListing->title }}</strong>
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $application->created_at->diffForHumans() }}
                                    </p>
                                    <div class="mt-2">
                                        <span class="px-3 py-1 bg-{{ $application->status === 'pending' ? 'yellow' : ($application->status === 'accepted' ? 'green' : ($application->status === 'rejected' ? 'red' : 'blue')) }}-100 text-{{ $application->status === 'pending' ? 'yellow' : ($application->status === 'accepted' ? 'green' : ($application->status === 'rejected' ? 'red' : 'blue')) }}-700 text-xs font-semibold rounded-full">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <button wire:click="viewApplication({{ $application->id }})" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg">
                                        View Details
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        {{ $applications->links() }}
                    </div>
                @else
                    <p class="text-center text-gray-500 py-8">No applications found.</p>
                @endif
            </div>

            <!-- Application Detail Modal -->
            @if($selectedApplication)
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 p-4">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto p-8">
                    <h3 class="text-2xl font-bold mb-4">Application from {{ $selectedApplication->student->name }}</h3>

                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-600"><strong>Email:</strong> {{ $selectedApplication->student->email }}</p>
                            <p class="text-sm text-gray-600"><strong>Position:</strong> {{ $selectedApplication->jobListing->title }}</p>
                            <p class="text-sm text-gray-600"><strong>Applied:</strong> {{ $selectedApplication->created_at->format('M d, Y') }}</p>
                        </div>

                        @if($selectedApplication->cover_letter)
                        <div>
                            <h4 class="font-semibold mb-2">Cover Letter</h4>
                            <p class="text-sm bg-gray-50 dark:bg-gray-900 p-4 rounded">{{ $selectedApplication->cover_letter }}</p>
                        </div>
                        @endif

                        @if($selectedApplication->answers)
                        <div>
                            <h4 class="font-semibold mb-2">Answers to Questions</h4>
                            @foreach($selectedApplication->answers as $qId => $answer)
                                @php
                                    $question = $selectedApplication->jobListing->questions->firstWhere('id', $qId);
                                @endphp
                                @if($question)
                                <div class="mb-3">
                                    <p class="text-sm font-medium">Q: {{ $question->question }}</p>
                                    <p class="text-sm text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-900 p-2 rounded mt-1">
                                        A: {{ $answer }}
                                    </p>
                                </div>
                                @endif
                            @endforeach
                        </div>
                        @endif

                        <div>
                            <a href="{{ Storage::url($selectedApplication->cv_path) }}" target="_blank" class="text-blue-600 hover:text-blue-700">
                                📄 Download CV
                            </a>
                        </div>

                        <div class="border-t pt-4">
                            <h4 class="font-semibold mb-3">Update Status</h4>
                            <div class="flex gap-2">
                                <button wire:click="updateStatus({{ $selectedApplication->id }}, 'reviewing')" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg">
                                    Mark as Reviewing
                                </button>
                                <button wire:click="updateStatus({{ $selectedApplication->id }}, 'accepted')" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm rounded-lg">
                                    Accept
                                </button>
                                <button wire:click="updateStatus({{ $selectedApplication->id }}, 'rejected')" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm rounded-lg">
                                    Reject
                                </button>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button wire:click="closeApplication" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-lg">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
