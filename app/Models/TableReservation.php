<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TableReservation extends Model
{
    protected $fillable = [
        'reservation_code',
        'restaurant_table_id',
        'guest_name',
        'guest_phone',
        'guest_email',
        'reservation_date',
        'reservation_time',
        'guests',
        'status',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'reservation_date' => 'date',
            'guests' => 'integer',
        ];
    }

    public function restaurantTable(): BelongsTo
    {
        return $this->belongsTo(RestaurantTable::class);
    }
}
