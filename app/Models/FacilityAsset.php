<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FacilityAsset extends Model
{
    protected $fillable = [
        'asset_code',
        'name',
        'area',
        'category',
        'location',
        'condition',
        'status',
        'brand',
        'model',
        'serial_number',
        'purchase_date',
        'purchase_price',
        'last_maintenance_at',
        'next_maintenance_at',
        'notes',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'purchase_date' => 'date',
            'purchase_price' => 'decimal:2',
            'last_maintenance_at' => 'date',
            'next_maintenance_at' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function histories(): HasMany
    {
        return $this->hasMany(FacilityHistory::class);
    }

    public function scopeNeedsAttention(
        Builder $query
    ): Builder {
        return $query->whereIn(
            'condition',
            [
                'needs_maintenance',
                'damaged',
                'under_repair',
            ]
        );
    }

    public function scopeMaintenanceDue(
        Builder $query
    ): Builder {
        return $query
            ->whereNotNull('next_maintenance_at')
            ->whereDate(
                'next_maintenance_at',
                '<=',
                today()
            );
    }

    public function getAreaLabelAttribute(): string
    {
        return match ($this->area) {
            'homestay' => 'Homestay',
            'cafe' => 'Cafe & Resto',
            default => ucfirst($this->area),
        };
    }

    public function getConditionLabelAttribute(): string
    {
        return match ($this->condition) {
            'good' => 'Baik',
            'needs_maintenance' => 'Perlu Maintenance',
            'damaged' => 'Rusak',
            'under_repair' => 'Dalam Perbaikan',
            'replaced' => 'Diganti',
            'retired' => 'Tidak Digunakan',
            default => ucfirst($this->condition),
        };
    }
}
