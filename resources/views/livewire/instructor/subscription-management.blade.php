<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <!-- Page Header -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Subscription Management</h2>
                <p class="text-gray-600">Manage student subscriptions and payment approvals</p>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow p-4">
                <div class="text-sm text-gray-600">Total Payments</div>
                <div class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</div>
            </div>
            <div class="bg-yellow-50 rounded-lg shadow p-4">
                <div class="text-sm text-yellow-700">Pending Approval</div>
                <div class="text-2xl font-bold text-yellow-900">{{ $stats['pending'] }}</div>
            </div>
            <div class="bg-green-50 rounded-lg shadow p-4">
                <div class="text-sm text-green-700">Approved</div>
                <div class="text-2xl font-bold text-green-900">{{ $stats['completed'] }}</div>
            </div>
            <div class="bg-red-50 rounded-lg shadow p-4">
                <div class="text-sm text-red-700">Rejected</div>
                <div class="text-2xl font-bold text-red-900">{{ $stats['failed'] }}</div>
            </div>
            <div class="bg-blue-50 rounded-lg shadow p-4">
                <div class="text-sm text-blue-700">Active Subs</div>
                <div class="text-2xl font-bold text-blue-900">{{ $stats['active_subscriptions'] }}</div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <div class="flex flex-col md:flex-row gap-4 justify-between">
                    <!-- Status Filter -->
                    <div class="flex gap-2">
                        <button
                            wire:click="filterByStatus('all')"
                            class="px-4 py-2 rounded-lg font-medium {{ $statusFilter === 'all' ? 'bg-gray-800 text-white' : 'bg-gray-200 text-gray-800 hover:bg-gray-300' }}"
                        >
                            All
                        </button>
                        <button
                            wire:click="filterByStatus('pending')"
                            class="px-4 py-2 rounded-lg font-medium {{ $statusFilter === 'pending' ? 'bg-yellow-600 text-white' : 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' }}"
                        >
                            Pending
                        </button>
                        <button
                            wire:click="filterByStatus('completed')"
                            class="px-4 py-2 rounded-lg font-medium {{ $statusFilter === 'completed' ? 'bg-green-600 text-white' : 'bg-green-100 text-green-800 hover:bg-green-200' }}"
                        >
                            Approved
                        </button>
                        <button
                            wire:click="filterByStatus('failed')"
                            class="px-4 py-2 rounded-lg font-medium {{ $statusFilter === 'failed' ? 'bg-red-600 text-white' : 'bg-red-100 text-red-800 hover:bg-red-200' }}"
                        >
                            Rejected
                        </button>
                    </div>

                    <!-- Search -->
                    <div class="flex-1 max-w-md">
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="searchTerm"
                            placeholder="Search by student name, email, or transaction ID..."
                            class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        >
                    </div>
                </div>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subscription</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($transactions as $transaction)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($transaction->student->avatar)
                                        <img src="{{ Storage::url($transaction->student->avatar) }}" alt="" class="w-8 h-8 rounded-full mr-2">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-sm font-bold mr-2">
                                            {{ substr($transaction->student->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $transaction->student->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $transaction->student->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                                {{ $transaction->transaction_id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                {{ number_format($transaction->amount, 2) }} {{ $transaction->currency }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $transaction->created_at->format('M d, Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($transaction->status === 'completed') bg-green-100 text-green-800
                                    @elseif($transaction->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($transaction->status === 'failed') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($transaction->subscription)
                                    @if($transaction->subscription->isActive())
                                        <span class="text-green-600 font-medium">
                                            Active until {{ $transaction->subscription->expires_at->format('M d, Y') }}
                                        </span>
                                    @else
                                        <span class="text-gray-500">
                                            {{ ucfirst($transaction->subscription->status) }}
                                        </span>
                                    @endif
                                @else
                                    <span class="text-gray-400">N/A</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex gap-2">
                                    @if($transaction->status === 'pending')
                                        <button
                                            wire:click="viewReceipt({{ $transaction->id }})"
                                            class="text-blue-600 hover:text-blue-900"
                                            title="View Receipt"
                                        >
                                            👁️
                                        </button>
                                        <button
                                            wire:click="openApprovalModal({{ $transaction->id }})"
                                            class="text-green-600 hover:text-green-900"
                                            title="Approve/Reject"
                                        >
                                            ✅
                                        </button>
                                    @elseif($transaction->status === 'completed')
                                        <button
                                            wire:click="viewReceipt({{ $transaction->id }})"
                                            class="text-blue-600 hover:text-blue-900"
                                            title="View Receipt"
                                        >
                                            👁️
                                        </button>
                                        @if($transaction->subscription && $transaction->subscription->isActive())
                                        <button
                                            wire:click="extendSubscription({{ $transaction->subscription->id }}, 30)"
                                            class="text-purple-600 hover:text-purple-900"
                                            title="Extend 30 days"
                                        >
                                            +30d
                                        </button>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                No transactions found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>

    <!-- Receipt Modal -->
    @if($showReceiptModal && $selectedTransaction)
    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 text-white rounded-t-lg sticky top-0">
                <h2 class="text-xl font-bold">Payment Receipt</h2>
            </div>

            <div class="p-6">
                <div class="mb-4 grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <strong>Student:</strong> {{ $selectedTransaction->student->name }}
                    </div>
                    <div>
                        <strong>Email:</strong> {{ $selectedTransaction->student->email }}
                    </div>
                    <div>
                        <strong>Amount:</strong> {{ number_format($selectedTransaction->amount, 2) }} {{ $selectedTransaction->currency }}
                    </div>
                    <div>
                        <strong>Date:</strong> {{ $selectedTransaction->created_at->format('M d, Y H:i') }}
                    </div>
                    <div class="col-span-2">
                        <strong>Transaction ID:</strong> {{ $selectedTransaction->transaction_id }}
                    </div>
                    @if($selectedTransaction->notes)
                    <div class="col-span-2">
                        <strong>Notes:</strong> {{ $selectedTransaction->notes }}
                    </div>
                    @endif
                </div>

                @if($selectedTransaction->payment_details && isset($selectedTransaction->payment_details['receipt_path']))
                <div class="mt-4">
                    <h4 class="font-semibold mb-2">Receipt Image:</h4>
                    <img
                        src="{{ Storage::url($selectedTransaction->payment_details['receipt_path']) }}"
                        alt="Payment Receipt"
                        class="w-full rounded-lg border border-gray-300"
                    >
                </div>
                @endif
            </div>

            <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 rounded-b-lg flex justify-end">
                <button
                    wire:click="closeReceiptModal"
                    class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg font-medium"
                >
                    Close
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Approval Modal -->
    @if($showApprovalModal && $selectedTransaction)
    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-lg w-full">
            <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-4 text-white rounded-t-lg">
                <h2 class="text-xl font-bold">Approve/Reject Payment</h2>
            </div>

            <div class="p-6">
                <div class="mb-4 text-sm space-y-2">
                    <p><strong>Student:</strong> {{ $selectedTransaction->student->name }}</p>
                    <p><strong>Amount:</strong> {{ number_format($selectedTransaction->amount, 2) }} {{ $selectedTransaction->currency }}</p>
                    <p><strong>Transaction ID:</strong> {{ $selectedTransaction->transaction_id }}</p>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Admin Note (Optional)
                    </label>
                    <textarea
                        wire:model="approvalNote"
                        rows="3"
                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-lg"
                        placeholder="Add a note about this approval/rejection..."
                    ></textarea>
                </div>
            </div>

            <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 rounded-b-lg flex justify-between gap-3">
                <button
                    wire:click="closeApprovalModal"
                    class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg font-medium"
                >
                    Cancel
                </button>
                <div class="flex gap-2">
                    <button
                        wire:click="rejectPayment"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium"
                    >
                        Reject
                    </button>
                    <button
                        wire:click="approvePayment"
                        class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium"
                    >
                        Approve & Activate
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
