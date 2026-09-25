<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InventoryItem extends Model
{
    protected $fillable = [
        'item_code',
        'name',
        'area',
        'item_type',
        'category',
        'unit',
        'current_stock',
        'minimum_stock',
        'purchase_price',
        'location',
        'notes',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'current_stock' => 'decimal:3',
            'minimum_stock' => 'decimal:3',
            'purchase_price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function movements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class);
    }

    public function scopeLowStock(Builder $query): Builder
    {
        return $query
            ->where('minimum_stock', '>', 0)
            ->whereColumn(
                'current_stock',
                '<=',
                'minimum_stock'
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

    public function getItemTypeLabelAttribute(): string
    {
        return match ($this->item_type) {
            'consumable' => 'Consumable',
            'ingredient' => 'Bahan',
            'equipment' => 'Equipment',
            'cleaning' => 'Cleaning',
            'other' => 'Lainnya',
            default => ucfirst($this->item_type),
        };
    }
}
