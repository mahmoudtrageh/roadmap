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
    public $selectedPlan = 'yearly'; // yearly or monthly

    protected $rules = [
        'receipt' => 'required|image|max:2048', // Max 2MB
        'transactionNotes' => 'nullable|string|max:500',
        'selectedPlan' => 'required|in:monthly,yearly',
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

        // Determine amount and duration based on selected plan
        $amount = $this->selectedPlan === 'yearly' ? 1000.00 : 100.00;
        $duration = $this->selectedPlan === 'yearly' ? 365 : 30; // days

        // Create pending subscription
        $subscription = SubscriptionModel::create([
            'student_id' => Auth::id(),
            'status' => 'pending',
            'amount' => $amount,
            'payment_method' => 'bank_transfer',
            'notes' => $this->transactionNotes . ' (Plan: ' . ucfirst($this->selectedPlan) . ')',
        ]);

        // Store receipt
        $receiptPath = $this->receipt->store('receipts', 'public');

        // Create pending payment transaction
        $transaction = PaymentTransaction::create([
            'student_id' => Auth::id(),
            'subscription_id' => $subscription->id,
            'transaction_id' => 'TXN-' . time() . '-' . Auth::id(),
            'amount' => $amount,
            'currency' => 'EGP',
            'status' => 'pending',
            'payment_method' => 'bank_transfer',
            'payment_details' => [
                'receipt_path' => $receiptPath,
                'uploaded_at' => now()->toDateTimeString(),
                'plan' => $this->selectedPlan,
                'duration_days' => $duration,
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
