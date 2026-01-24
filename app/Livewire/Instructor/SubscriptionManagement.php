<?php

namespace App\Livewire\Instructor;

use App\Models\Subscription;
use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class SubscriptionManagement extends Component
{
    use WithPagination;

    public $statusFilter = 'all';
    public $searchTerm = '';

    public $selectedTransaction = null;
    public $showReceiptModal = false;
    public $showApprovalModal = false;
    public $approvalNote = '';

    public function filterByStatus($status)
    {
        $this->statusFilter = $status;
        $this->resetPage();
    }

    public function viewReceipt($transactionId)
    {
        $this->selectedTransaction = PaymentTransaction::with(['student', 'subscription'])
            ->findOrFail($transactionId);
        $this->showReceiptModal = true;
    }

    public function closeReceiptModal()
    {
        $this->showReceiptModal = false;
        $this->selectedTransaction = null;
    }

    public function openApprovalModal($transactionId)
    {
        $this->selectedTransaction = PaymentTransaction::with(['student', 'subscription'])
            ->findOrFail($transactionId);
        $this->showApprovalModal = true;
    }

    public function closeApprovalModal()
    {
        $this->showApprovalModal = false;
        $this->selectedTransaction = null;
        $this->approvalNote = '';
    }

    public function approvePayment()
    {
        if (!$this->selectedTransaction) {
            return;
        }

        // Mark transaction as completed
        $this->selectedTransaction->update([
            'status' => 'completed',
            'notes' => $this->approvalNote ?: 'Approved by admin',
        ]);

        // Activate subscription for 1 year
        if ($this->selectedTransaction->subscription) {
            $this->selectedTransaction->subscription->activate(365);
        }

        session()->flash('message', 'Payment approved and subscription activated!');
        $this->closeApprovalModal();
    }

    public function rejectPayment()
    {
        if (!$this->selectedTransaction) {
            return;
        }

        // Mark transaction as failed
        $this->selectedTransaction->update([
            'status' => 'failed',
            'notes' => $this->approvalNote ?: 'Rejected by admin',
        ]);

        // Cancel subscription
        if ($this->selectedTransaction->subscription) {
            $this->selectedTransaction->subscription->cancel($this->approvalNote);
        }

        session()->flash('message', 'Payment rejected.');
        $this->closeApprovalModal();
    }

    public function extendSubscription($subscriptionId, $days)
    {
        $subscription = Subscription::findOrFail($subscriptionId);
        $subscription->extend($days);

        session()->flash('message', "Subscription extended by {$days} days!");
    }

    public function render()
    {
        $query = PaymentTransaction::with(['student', 'subscription'])
            ->latest();

        // Apply status filter
        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        // Apply search
        if ($this->searchTerm) {
            $query->whereHas('student', function($q) {
                $q->where('name', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('email', 'like', '%' . $this->searchTerm . '%');
            })->orWhere('transaction_id', 'like', '%' . $this->searchTerm . '%');
        }

        $transactions = $query->paginate(20);

        // Get statistics
        $stats = [
            'total' => PaymentTransaction::count(),
            'pending' => PaymentTransaction::where('status', 'pending')->count(),
            'completed' => PaymentTransaction::where('status', 'completed')->count(),
            'failed' => PaymentTransaction::where('status', 'failed')->count(),
            'active_subscriptions' => Subscription::where('status', 'active')
                ->where('expires_at', '>', now())
                ->count(),
        ];

        return view('livewire.instructor.subscription-management', [
            'transactions' => $transactions,
            'stats' => $stats,
        ]);
    }
}
