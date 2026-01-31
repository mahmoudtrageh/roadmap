<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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

        <!-- Subscription Status Header -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Your Subscription</h2>

                @if($completedRoadmapsCount === 0)
                    <!-- First Roadmap is Free -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <div class="flex items-start gap-4">
                            <svg class="w-12 h-12 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                            </svg>
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-blue-900 mb-2">🎁 Your First Roadmap is FREE!</h3>
                                <p class="text-blue-800 mb-4">
                                    Start learning today at no cost. Complete your first roadmap to unlock all features and see if our platform is right for you.
                                </p>
                                <a href="{{ route('student.roadmaps') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                                    Browse Roadmaps →
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Subscription Required for 2nd+ Roadmap -->
                    @if($currentSubscription && $currentSubscription->isActive())
                        <!-- Active Subscription -->
                        <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start gap-4">
                                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <h3 class="text-xl font-bold text-green-900 mb-2">✓ Active Subscription</h3>
                                        <p class="text-green-800 mb-2">
                                            Your subscription is active and gives you unlimited access to all roadmaps.
                                        </p>
                                        <div class="text-sm text-green-700">
                                            <p><strong>Expires:</strong> {{ $currentSubscription->expires_at->format('M d, Y') }}</p>
                                            <p><strong>Days remaining:</strong> {{ $currentSubscription->expires_at->diffInDays(now()) }} days</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- No Active Subscription -->
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6">
                            <div class="flex items-start gap-4">
                                <svg class="w-12 h-12 text-yellow-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                <div class="flex-1">
                                    <h3 class="text-xl font-bold text-yellow-900 mb-2">Subscription Required</h3>
                                    <p class="text-yellow-800 mb-4">
                                        You've completed {{ $completedRoadmapsCount }} roadmap(s). To continue learning and enroll in more roadmaps, you need an active subscription.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Subscription Plans -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Monthly Plan -->
                            <div class="bg-white rounded-lg p-8 text-gray-800 shadow-lg">
                                <div class="text-center mb-6">
                                    <h3 class="text-2xl font-bold mb-2">Monthly</h3>
                                    <div class="text-5xl font-bold text-indigo-600 mb-1">100 EGP</div>
                                    <p class="text-gray-600">per month</p>
                                </div>
                                <ul class="space-y-3 mb-6 text-left">
                                    <li class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="text-sm">Unlimited roadmap access</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="text-sm">Job board access</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="text-sm">Cancel anytime</span>
                                    </li>
                                </ul>
                                <div class="text-center">
                                    <p class="text-sm text-gray-500">Billed monthly</p>
                                </div>
                            </div>

                            <!-- Annual Plan (Best Value) -->
                            <div class="bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg p-8 text-white shadow-lg relative">
                                <div class="absolute -top-3 right-4 bg-yellow-400 text-gray-900 px-3 py-1 rounded-full text-xs font-bold">
                                    SAVE 17%
                                </div>
                                <div class="text-center mb-6">
                                    <h3 class="text-2xl font-bold mb-2">Yearly</h3>
                                    <div class="text-5xl font-bold mb-1">1000 EGP</div>
                                    <p class="text-indigo-100 mb-1">per year</p>
                                    <p class="text-sm text-indigo-200">Only 83 EGP/month</p>
                                </div>
                                <ul class="space-y-3 mb-6 text-left">
                                    <li class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-green-300 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="text-sm">Unlimited roadmap access</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-green-300 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="text-sm">Job board access</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-green-300 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="text-sm font-bold">Best value - 2 months FREE!</span>
                                    </li>
                                </ul>
                                <div class="text-center">
                                    <p class="text-sm text-indigo-100">Billed annually</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg p-8 text-white">
                            <div class="max-w-3xl mx-auto text-center">

                                <div class="bg-white/10 backdrop-blur rounded-lg p-6 mb-6 text-left">
                                    <h4 class="font-bold text-lg mb-3">All Plans Include:</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <div class="flex items-start gap-2">
                                            <svg class="w-5 h-5 text-green-300 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span class="text-sm">Unlimited access to ALL roadmaps</span>
                                        </div>
                                        <div class="flex items-start gap-2">
                                            <svg class="w-5 h-5 text-green-300 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span class="text-sm">Progress tracking and analytics</span>
                                        </div>
                                        <div class="flex items-start gap-2">
                                            <svg class="w-5 h-5 text-green-300 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span class="text-sm">Job board access</span>
                                        </div>
                                        <div class="flex items-start gap-2">
                                            <svg class="w-5 h-5 text-green-300 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span class="text-sm">Priority support</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Payment Instructions -->
                                <div class="bg-white/10 backdrop-blur rounded-lg p-6 mb-6 text-left">
                                    <h4 class="font-bold text-lg mb-3">💳 How to Pay:</h4>
                                    <ol class="space-y-2 text-sm">
                                        <li class="flex items-start gap-2">
                                            <span class="font-bold text-green-300">1.</span>
                                            <span>Choose your plan: <strong>100 EGP/month</strong> or <strong>1000 EGP/year</strong></span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <span class="font-bold text-green-300">2.</span>
                                            <span>Transfer the amount to our bank account or mobile wallet</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <span class="font-bold text-green-300">3.</span>
                                            <span>Take a screenshot of the payment receipt</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <span class="font-bold text-green-300">4.</span>
                                            <span>Upload the receipt using the button below</span>
                                        </li>
                                        <li class="flex items-start gap-2">
                                            <span class="font-bold text-green-300">5.</span>
                                            <span>Wait for admin approval (usually within 24 hours)</span>
                                        </li>
                                    </ol>

                                    <div class="mt-4 p-3 bg-white/10 rounded border border-white/20">
                                        <p class="text-xs text-white/90 mb-2"><strong>Payment Methods:</strong></p>
                                        <p class="text-sm font-mono">Vodafone Cash: <strong>01234567890</strong></p>
                                        <p class="text-sm font-mono">Bank Account: <strong>1234-5678-9012-3456</strong></p>
                                    </div>
                                </div>

                                <button
                                    wire:click="openPaymentModal"
                                    class="bg-white text-indigo-600 hover:bg-indigo-50 px-8 py-4 rounded-lg font-bold text-lg shadow-lg transition-colors inline-flex items-center gap-2"
                                >
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    Upload Payment Receipt
                                </button>

                                <p class="text-indigo-100 text-sm mt-4">
                                    Secure manual verification by our team
                                </p>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>

        <!-- Payment History -->
        @if($transactions->count() > 0)
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Payment History</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Method</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($transactions as $transaction)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $transaction->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $transaction->transaction_id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    {{ number_format($transaction->amount, 2) }} {{ $transaction->currency }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}
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
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Payment Upload Modal -->
    @if($showPaymentModal)
    <div class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-lg w-full">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4 text-white rounded-t-lg">
                <h2 class="text-xl font-bold">📤 Upload Payment Receipt</h2>
            </div>

            <form wire:submit.prevent="submitPayment" class="p-6">
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                        Select Your Plan <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                        <label class="relative cursor-pointer">
                            <input
                                type="radio"
                                wire:model="selectedPlan"
                                value="monthly"
                                class="peer sr-only"
                            >
                            <div class="border-2 border-gray-300 dark:border-gray-600 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 dark:peer-checked:bg-indigo-900/20 rounded-lg p-4 transition-all">
                                <div class="font-bold text-lg text-gray-900 dark:text-gray-100">Monthly</div>
                                <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">100 EGP</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">per month</div>
                            </div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input
                                type="radio"
                                wire:model="selectedPlan"
                                value="yearly"
                                class="peer sr-only"
                            >
                            <div class="border-2 border-gray-300 dark:border-gray-600 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 dark:peer-checked:bg-indigo-900/20 rounded-lg p-4 transition-all relative">
                                <div class="absolute -top-2 -right-2 bg-yellow-400 text-gray-900 px-2 py-0.5 rounded-full text-xs font-bold">
                                    SAVE 17%
                                </div>
                                <div class="font-bold text-lg text-gray-900 dark:text-gray-100">Yearly</div>
                                <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">1000 EGP</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">83 EGP/month</div>
                            </div>
                        </label>
                    </div>
                    @error('selectedPlan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-4">
                        <h4 class="font-semibold text-blue-900 dark:text-blue-100 mb-2">Payment Methods:</h4>
                        <ul class="text-sm text-blue-800 dark:text-blue-200 space-y-1">
                            <li>• Vodafone Cash: <strong>01234567890</strong></li>
                            <li>• Bank Account: <strong>1234-5678-9012-3456</strong></li>
                        </ul>
                        <p class="text-xs text-blue-700 dark:text-blue-300 mt-2">
                            Transfer the amount for your selected plan, then upload your receipt below.
                        </p>
                    </div>

                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Upload Receipt <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="file"
                        wire:model="receipt"
                        accept="image/*"
                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                    >
                    @error('receipt')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                        Accepted formats: JPG, PNG, PDF (Max 2MB)
                    </p>

                    @if($receipt)
                        <div class="mt-3 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                            <p class="text-sm text-green-800 dark:text-green-200 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Receipt uploaded: {{ $receipt->getClientOriginalName() }}
                            </p>
                        </div>
                    @endif
                </div>

                <div class="mb-6">
                    <label for="transactionNotes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Additional Notes (Optional)
                    </label>
                    <textarea
                        wire:model="transactionNotes"
                        id="transactionNotes"
                        rows="3"
                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="e.g., Transaction reference number, payment date, etc."
                    ></textarea>
                    @error('transactionNotes')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-between gap-3">
                    <button
                        type="button"
                        wire:click="closePaymentModal"
                        class="flex-1 px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 font-medium border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-2 rounded-lg font-medium transition-colors"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove>Submit Payment</span>
                        <span wire:loading>Uploading...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
