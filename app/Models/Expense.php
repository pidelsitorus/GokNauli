<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    protected $fillable = [
        'user_id',
        'area',
        'category',
        'description',
        'amount',
        'expense_date',
        'payment_method',
        'vendor',
        'reference',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'expense_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getAreaLabelAttribute(): string
    {
        return match ($this->area) {
            'homestay' => 'Homestay',
            'cafe' => 'Cafe & Resto',
            default => 'Umum',
        };
    }

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'electricity' => 'Listrik',
            'water' => 'Air',
            'internet' => 'Internet',
            'salary' => 'Gaji',
            'tax' => 'Pajak',
            'transport' => 'Transportasi',
            'office_supplies' => 'Perlengkapan Kantor',
            'marketing' => 'Marketing',
            'rent' => 'Sewa',
            'bank_fee' => 'Biaya Bank',
            'other' => 'Lainnya',
            default => $this->category,
        };
    }
}
