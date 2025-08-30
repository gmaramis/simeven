<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsAppMessage extends Model
{
    protected $table = 'whatsapp_messages';
    
    protected $fillable = [
        'registration_id',
        'message_type',
        'phone_number',
        'message_content',
        'sent_at',
        'status',
        'response_data',
        'error_message'
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'response_data' => 'array'
    ];

    /**
     * Get the registration that owns the message
     */
    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    /**
     * Check if message is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if message was sent successfully
     */
    public function isSent(): bool
    {
        return $this->status === 'sent';
    }

    /**
     * Check if message failed to send
     */
    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    /**
     * Mark message as sent
     */
    public function markAsSent($responseData = null): void
    {
        $this->update([
            'status' => 'sent',
            'sent_at' => now(),
            'response_data' => $responseData
        ]);
    }

    /**
     * Mark message as failed
     */
    public function markAsFailed($errorMessage = null): void
    {
        $this->update([
            'status' => 'failed',
            'error_message' => $errorMessage
        ]);
    }

    /**
     * Get message type label
     */
    public function getMessageTypeLabel(): string
    {
        return match($this->message_type) {
            'confirmation' => 'Konfirmasi Pendaftaran',
            'reminder_h1' => 'Reminder H-1',
            'reminder_h0' => 'Reminder H-0',
            default => 'Unknown'
        };
    }

    /**
     * Get status label
     */
    public function getStatusLabel(): string
    {
        return match($this->status) {
            'pending' => 'Menunggu',
            'sent' => 'Terkirim',
            'failed' => 'Gagal',
            default => 'Unknown'
        };
    }
}
