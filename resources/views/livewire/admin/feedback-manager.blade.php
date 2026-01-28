<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <!-- Header -->
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Feedback Management</h2>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Review and manage user feedback, bug reports, and feature requests</p>
                    </div>
                </div>

                <!-- Flash Message -->
                @if (session()->has('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('message') }}</span>
                    </div>
                @endif

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg p-4 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-100 text-sm">Total Feedback</p>
                                <p class="text-3xl font-bold mt-1">{{ $stats['total'] }}</p>
                            </div>
                            <div class="text-4xl opacity-50">💬</div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-yellow-500 to-orange-500 rounded-lg p-4 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-yellow-100 text-sm">New</p>
                                <p class="text-3xl font-bold mt-1">{{ $stats['new'] }}</p>
                            </div>
                            <div class="text-4xl opacity-50">🆕</div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg p-4 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-100 text-sm">In Progress</p>
                                <p class="text-3xl font-bold mt-1">{{ $stats['in_progress'] }}</p>
                            </div>
                            <div class="text-4xl opacity-50">⚡</div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg p-4 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-100 text-sm">Resolved</p>
                                <p class="text-3xl font-bold mt-1">{{ $stats['resolved'] }}</p>
                            </div>
                            <div class="text-4xl opacity-50">✅</div>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="flex flex-wrap items-center gap-4 mb-6 p-4 bg-gray-50 dark:bg-gray-900 rounded-lg">
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2">Status:</label>
                        <select wire:model.live="filterStatus" class="border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm">
                            <option value="all">All Statuses</option>
                            <option value="new">New</option>
                            <option value="in_progress">In Progress</option>
                            <option value="resolved">Resolved</option>
                            <option value="dismissed">Dismissed</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2">Type:</label>
                        <select wire:model.live="filterType" class="border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm">
                            <option value="all">All Types</option>
                            <option value="bug">🐛 Bug Reports</option>
                            <option value="feature">✨ Feature Requests</option>
                            <option value="improvement">💡 Improvements</option>
                            <option value="other">💬 Other</option>
                        </select>
                    </div>
                </div>

                <!-- Feedback List -->
                <div class="space-y-3">
                    @forelse($feedback as $item)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition-shadow bg-white dark:bg-gray-800">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-3 mb-2">
                                        <!-- Type Badge -->
                                        @php
                                            $typeConfig = [
                                                'bug' => ['icon' => '🐛', 'color' => 'red', 'label' => 'Bug'],
                                                'feature' => ['icon' => '✨', 'color' => 'green', 'label' => 'Feature'],
                                                'improvement' => ['icon' => '💡', 'color' => 'blue', 'label' => 'Improvement'],
                                                'other' => ['icon' => '💬', 'color' => 'purple', 'label' => 'Other'],
                                            ];
                                            $config = $typeConfig[$item->type] ?? $typeConfig['other'];
                                        @endphp
                                        <span class="px-3 py-1 bg-{{ $config['color'] }}-100 dark:bg-{{ $config['color'] }}-900/30 text-{{ $config['color'] }}-700 dark:text-{{ $config['color'] }}-300 text-xs font-semibold rounded-full">
                                            {{ $config['icon'] }} {{ $config['label'] }}
                                        </span>

                                        <!-- Status Badge -->
                                        @php
                                            $statusConfig = [
                                                'new' => ['color' => 'yellow', 'label' => 'New'],
                                                'in_progress' => ['color' => 'purple', 'label' => 'In Progress'],
                                                'resolved' => ['color' => 'green', 'label' => 'Resolved'],
                                                'dismissed' => ['color' => 'gray', 'label' => 'Dismissed'],
                                            ];
                                            $statusInfo = $statusConfig[$item->status] ?? $statusConfig['new'];
                                        @endphp
                                        <span class="px-3 py-1 bg-{{ $statusInfo['color'] }}-100 dark:bg-{{ $statusInfo['color'] }}-900/30 text-{{ $statusInfo['color'] }}-700 dark:text-{{ $statusInfo['color'] }}-300 text-xs font-semibold rounded-full">
                                            {{ $statusInfo['label'] }}
                                        </span>

                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $item->created_at->diffForHumans() }}
                                        </span>
                                    </div>

                                    <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-1">
                                        {{ $item->subject }}
                                    </h3>

                                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2 mb-2">
                                        {{ $item->message }}
                                    </p>

                                    <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            {{ $item->user ? $item->user->name : 'Anonymous' }}
                                        </span>
                                        @if($item->page_url)
                                            <span class="flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                                </svg>
                                                Page URL
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex flex-col gap-2 shrink-0">
                                    <button
                                        wire:click="viewFeedback({{ $item->id }})"
                                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors"
                                    >
                                        View Details
                                    </button>

                                    @if($item->status !== 'resolved')
                                        <button
                                            wire:click="updateStatus({{ $item->id }}, 'in_progress')"
                                            class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors"
                                        >
                                            Mark In Progress
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">📭</div>
                            <p class="text-gray-500 dark:text-gray-400 font-medium">No feedback found</p>
                            <p class="text-sm text-gray-400 dark:text-gray-500">Try adjusting your filters</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $feedback->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    @if($showDetailModal && $selectedFeedback)
    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 text-white rounded-t-lg">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold">Feedback Details</h2>
                    <button
                        wire:click="closeDetailModal"
                        class="text-white hover:text-gray-200 transition-colors"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="p-6 space-y-6">
                <!-- Subject -->
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">
                        {{ $selectedFeedback->subject }}
                    </h3>
                    <div class="flex items-center gap-2">
                        @php
                            $typeConfig = [
                                'bug' => ['icon' => '🐛', 'color' => 'red', 'label' => 'Bug'],
                                'feature' => ['icon' => '✨', 'color' => 'green', 'label' => 'Feature'],
                                'improvement' => ['icon' => '💡', 'color' => 'blue', 'label' => 'Improvement'],
                                'other' => ['icon' => '💬', 'color' => 'purple', 'label' => 'Other'],
                            ];
                            $config = $typeConfig[$selectedFeedback->type] ?? $typeConfig['other'];
                        @endphp
                        <span class="px-3 py-1 bg-{{ $config['color'] }}-100 text-{{ $config['color'] }}-700 text-xs font-semibold rounded-full">
                            {{ $config['icon'] }} {{ $config['label'] }}
                        </span>
                    </div>
                </div>

                <!-- Message -->
                <div>
                    <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Message</h4>
                    <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                        <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $selectedFeedback->message }}</p>
                    </div>
                </div>

                <!-- Metadata -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Submitted By</h4>
                        <p class="text-gray-600 dark:text-gray-400">{{ $selectedFeedback->user ? $selectedFeedback->user->name : 'Anonymous' }}</p>
                        @if($selectedFeedback->user)
                            <p class="text-sm text-gray-500">{{ $selectedFeedback->user->email }}</p>
                        @endif
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Submitted At</h4>
                        <p class="text-gray-600 dark:text-gray-400">{{ $selectedFeedback->created_at->format('M d, Y h:i A') }}</p>
                        <p class="text-sm text-gray-500">{{ $selectedFeedback->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                @if($selectedFeedback->page_url)
                <div>
                    <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Page URL</h4>
                    <a href="{{ $selectedFeedback->page_url }}" target="_blank" class="text-blue-600 hover:underline text-sm break-all">
                        {{ $selectedFeedback->page_url }}
                    </a>
                </div>
                @endif

                <!-- Admin Notes -->
                <div>
                    <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Admin Notes</h4>
                    <textarea
                        wire:model="adminNotes"
                        rows="4"
                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-lg"
                        placeholder="Add internal notes about this feedback..."
                    ></textarea>
                    <button
                        wire:click="saveNotes"
                        class="mt-2 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm rounded-lg"
                    >
                        Save Notes
                    </button>
                </div>

                <!-- Status Actions -->
                <div class="flex items-center gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <h4 class="font-semibold text-gray-700 dark:text-gray-300">Change Status:</h4>
                    <button
                        wire:click="updateStatus({{ $selectedFeedback->id }}, 'new')"
                        class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white text-sm rounded-lg"
                    >
                        New
                    </button>
                    <button
                        wire:click="updateStatus({{ $selectedFeedback->id }}, 'in_progress')"
                        class="px-3 py-1 bg-purple-500 hover:bg-purple-600 text-white text-sm rounded-lg"
                    >
                        In Progress
                    </button>
                    <button
                        wire:click="markAsResolved"
                        class="px-3 py-1 bg-green-500 hover:bg-green-600 text-white text-sm rounded-lg"
                    >
                        Resolve
                    </button>
                    <button
                        wire:click="updateStatus({{ $selectedFeedback->id }}, 'dismissed')"
                        class="px-3 py-1 bg-gray-500 hover:bg-gray-600 text-white text-sm rounded-lg"
                    >
                        Dismiss
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
