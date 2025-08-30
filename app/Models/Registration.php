<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Registration extends Model
{
    protected $fillable = [
        'event_id',
        'name',
        'email',
        'phone',
        'church',
        'ministry',
        'status',
        'notes',
        'checked_in_at',
        'checked_in_by'
    ];

    protected $casts = [
        'checked_in_at' => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
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
}
