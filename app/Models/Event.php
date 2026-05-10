<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    public const PRICING_FREE = 'free';

    public const PRICING_PAID = 'paid';

    protected $fillable = [
        'title',
        'description',
        'total_seats',
        'available_seats',
        'start_date',
        'end_date',
        'location',
        'status',
        'image',
        'pricing_type',
        'price',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'price' => 'decimal:2',
    ];

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function getRegisteredCountAttribute()
    {
        return $this->total_seats - $this->available_seats;
    }

    public function isFull()
    {
        return $this->available_seats <= 0;
    }

    public function isPublished()
    {
        return $this->status === 'published';
    }

    public function isUpcoming()
    {
        return $this->start_date->isFuture();
    }

    public function isPaid(): bool
    {
        return ($this->pricing_type ?? self::PRICING_FREE) === self::PRICING_PAID;
    }

    public function isFree(): bool
    {
        return ! $this->isPaid();
    }
}
