<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'total_seats',
        'available_seats',
        'start_date',
        'end_date',
        'location',
        'status',
        'image'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
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
}
