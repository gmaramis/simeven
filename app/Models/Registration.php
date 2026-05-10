<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    public const PAYMENT_NOT_APPLICABLE = 'not_applicable';

    public const PAYMENT_PENDING = 'pending';

    public const PAYMENT_PAID = 'paid';

    public const PAYMENT_FAILED = 'failed';

    public const PAYMENT_EXPIRED = 'expired';

    protected $fillable = [
        'user_id',
        'event_id',
        'name',
        'phone',
        'church',
        'ministry',
        'status',
        'notes',
        'checked_in_at',
        'checked_in_by',
        'payment_status',
        'payment_gateway',
        'midtrans_order_id',
        'paid_at',
    ];

    protected $casts = [
        'checked_in_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the WhatsApp messages for this registration
     */
    public function whatsappMessages()
    {
        return $this->hasMany(WhatsAppMessage::class);
    }

    public function isConfirmed()
    {
        return $this->status === 'confirmed';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    public function isCheckedIn()
    {
        return !is_null($this->checked_in_at);
    }

    public function checkIn($adminName)
    {
        $this->update([
            'checked_in_at' => now(),
            'checked_in_by' => $adminName
        ]);
    }

    public function checkOut()
    {
        $this->update([
            'checked_in_at' => null,
            'checked_in_by' => null
        ]);
    }

    /**
     * Peserta dihitung untuk kuota, daftar hadir, dan reminder (event gratis = seperti sebelumnya; event berbayar = setelah lunas).
     */
    public function isFullyRegisteredForEvent(): bool
    {
        if ($this->status !== 'confirmed') {
            return false;
        }

        $event = $this->relationLoaded('event') ? $this->event : $this->event()->first();
        if (! $event) {
            return false;
        }

        if ($event->isFree()) {
            return true;
        }

        return $this->payment_status === self::PAYMENT_PAID;
    }

    public function scopeConfirmedForAttendance(Builder $query): Builder
    {
        return $query->where('status', 'confirmed')
            ->where(function (Builder $q) {
                $q->where('payment_status', self::PAYMENT_NOT_APPLICABLE)
                    ->orWhere('payment_status', self::PAYMENT_PAID);
            });
    }
}
