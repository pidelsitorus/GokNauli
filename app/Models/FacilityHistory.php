<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FacilityHistory extends Model
{
    protected $fillable = [
        'facility_asset_id',
        'user_id',
        'activity_type',
        'condition_before',
        'condition_after',
        'cost',
        'vendor',
        'reference',
        'notes',
        'occurred_at',
    ];

    protected function casts(): array
    {
        return [
            'cost' => 'decimal:2',
            'occurred_at' => 'datetime',
        ];
    }

    public function facilityAsset(): BelongsTo
    {
        return $this->belongsTo(
            FacilityAsset::class
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
