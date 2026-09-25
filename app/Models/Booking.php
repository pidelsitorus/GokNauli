<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'booking_code',
        'user_id',
        'room_id',
        'guest_name',
        'guest_phone',
        'guest_email',
        'check_in',
        'check_out',
        'adults',
        'children',
        'total_price',
        'status',
        'payment_status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'paid_at' => 'datetime',
            'check_in' => 'date',
            'check_out' => 'date',
            'adults' => 'integer',
            'children' => 'integer',
            'total_price' => 'decimal:2',
        ];
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
