<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Subscription extends Model
{
    protected $fillable = [
        'student_id',
        'status',
        'starts_at',
        'expires_at',
        'amount',
        'payment_method',
        'notes',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    /**
     * Student who owns the subscription
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Payment transactions for this subscription
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(PaymentTransaction::class);
    }

    /**
     * Check if subscription is active
     */
    public function isActive(): bool
    {
        return $this->status === 'active' &&
               $this->expires_at &&
               $this->expires_at->isFuture();
    }

    /**
     * Check if subscription is expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Activate subscription
     */
    public function activate(int $durationDays = 365): void
    {
        $this->update([
            'status' => 'active',
            'starts_at' => now(),
            'expires_at' => now()->addDays($durationDays),
        ]);
    }

    /**
     * Cancel subscription
     */
    public function cancel(?string $reason = null): void
    {
        $this->update([
            'status' => 'cancelled',
            'notes' => $reason,
        ]);
    }

    /**
     * Extend subscription
     */
    public function extend(int $days): void
    {
        $expiresAt = $this->expires_at ?? now();

        $this->update([
            'expires_at' => $expiresAt->addDays($days),
            'status' => 'active',
        ]);
    }
}
