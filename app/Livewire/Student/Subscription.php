<?php

namespace App\Livewire\Student;

use App\Models\Subscription as SubscriptionModel;
use App\Models\PaymentTransaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class Subscription extends Component
{
    use WithFileUploads;
    public $currentSubscription = null;
    public $transactions = [];
    public $receipt = null;
    public $showPaymentModal = false;
    public $transactionNotes = '';

    protected $rules = [
        'receipt' => 'required|image|max:2048', // Max 2MB
        'transactionNotes' => 'nullable|string|max:500',
    ];

    public function mount()
    {
        $this->loadSubscriptionData();
    }

    public function loadSubscriptionData()
    {
        $this->currentSubscription = SubscriptionModel::where('student_id', Auth::id())
            ->latest()
            ->first();

        $this->transactions = PaymentTransaction::where('student_id', Auth::id())
            ->with('subscription')
            ->latest()
            ->take(10)
            ->get();
    }

    public function openPaymentModal()
    {
        $this->showPaymentModal = true;
    }

    public function closePaymentModal()
    {
        $this->showPaymentModal = false;
        $this->reset(['receipt', 'transactionNotes']);
    }

    public function submitPayment()
    {
        $this->validate();

        // Create pending subscription
        $subscription = SubscriptionModel::create([
            'student_id' => Auth::id(),
            'status' => 'pending',
            'amount' => 100.00,
            'payment_method' => 'bank_transfer',
            'notes' => $this->transactionNotes,
        ]);

        // Store receipt
        $receiptPath = $this->receipt->store('receipts', 'public');

        // Create pending payment transaction
        $transaction = PaymentTransaction::create([
            'student_id' => Auth::id(),
            'subscription_id' => $subscription->id,
            'transaction_id' => 'TXN-' . time() . '-' . Auth::id(),
            'amount' => 100.00,
            'currency' => 'EGP',
            'status' => 'pending',
            'payment_method' => 'bank_transfer',
            'payment_details' => [
                'receipt_path' => $receiptPath,
                'uploaded_at' => now()->toDateTimeString(),
            ],
            'notes' => $this->transactionNotes,
        ]);

        session()->flash('message', 'Payment receipt uploaded successfully! Your subscription will be activated once the admin approves your payment.');
        $this->closePaymentModal();
        $this->loadSubscriptionData();
    }

    public function render()
    {
        $completedRoadmapsCount = \App\Models\RoadmapEnrollment::where('student_id', Auth::id())
            ->where('status', 'completed')
            ->count();

        return view('livewire.student.subscription', [
            'completedRoadmapsCount' => $completedRoadmapsCount,
        ]);
    }
}
