<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryItem;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $items = InventoryItem::query()
            ->when(
                $request->filled('search'),
                function ($query) use ($request) {
                    $search = $request->search;

                    $query->where(
                        function ($query) use ($search) {
                            $query
                                ->where(
                                    'item_code',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'name',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'category',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'location',
                                    'like',
                                    "%{$search}%"
                                );
                        }
                    );
                }
            )
            ->when(
                $request->filled('area'),
                fn ($query) =>
                    $query->where(
                        'area',
                        $request->area
                    )
            )
            ->when(
                $request->filled('item_type'),
                fn ($query) =>
                    $query->where(
                        'item_type',
                        $request->item_type
                    )
            )
            ->when(
                $request->boolean('low_stock'),
                fn ($query) =>
                    $query->lowStock()
            )
            ->orderBy('area')
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        $stats = [
            'total' => InventoryItem::where(
                'is_active',
                true
            )->count(),

            'homestay' => InventoryItem::where(
                'is_active',
                true
            )
                ->where('area', 'homestay')
                ->count(),

            'cafe' => InventoryItem::where(
                'is_active',
                true
            )
                ->where('area', 'cafe')
                ->count(),

            'low_stock' => InventoryItem::where(
                'is_active',
                true
            )
                ->lowStock()
                ->count(),
        ];

        return view(
            'admin.inventory.index',
            compact(
                'items',
                'stats'
            )
        );
    }


    public function create()
    {
        return view(
            'admin.inventory.create'
        );
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'area' => [
                'required',
                Rule::in([
                    'homestay',
                    'cafe',
                ]),
            ],

            'item_type' => [
                'required',
                Rule::in([
                    'consumable',
                    'ingredient',
                    'equipment',
                    'cleaning',
                    'other',
                ]),
            ],

            'category' => [
                'nullable',
                'string',
                'max:255',
            ],

            'unit' => [
                'required',
                'string',
                'max:30',
            ],

            'initial_stock' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'minimum_stock' => [
                'required',
                'numeric',
                'min:0',
            ],

            'purchase_price' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'location' => [
                'nullable',
                'string',
                'max:255',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);


        DB::transaction(function () use (
            $request,
            $validated
        ) {
            $initialStock = (float) (
                $validated['initial_stock']
                ?? 0
            );

            $item = InventoryItem::create([
                'item_code' => $this->generateItemCode(
                    $validated['area']
                ),

                'name' =>
                    $validated['name'],

                'area' =>
                    $validated['area'],

                'item_type' =>
                    $validated['item_type'],

                'category' =>
                    $validated['category'] ?? null,

                'unit' =>
                    $validated['unit'],

                'current_stock' =>
                    $initialStock,

                'minimum_stock' =>
                    $validated['minimum_stock'],

                'purchase_price' =>
                    $validated['purchase_price']
                    ?? null,

                'location' =>
                    $validated['location'] ?? null,

                'notes' =>
                    $validated['notes'] ?? null,

                'is_active' =>
                    $request->boolean('is_active'),
            ]);


            if ($initialStock > 0) {
                $unitCost = isset(
                    $validated['purchase_price']
                )
                    ? (float) $validated[
                        'purchase_price'
                    ]
                    : null;

                InventoryMovement::create([
                    'inventory_item_id' =>
                        $item->id,

                    'user_id' =>
                        auth()->id(),

                    'movement_type' =>
                        'STOCK_IN',

                    'quantity' =>
                        $initialStock,

                    'stock_before' =>
                        0,

                    'stock_after' =>
                        $initialStock,

                    'unit_cost' =>
                        $unitCost,

                    'total_cost' =>
                        $unitCost !== null
                            ? $unitCost
                                * $initialStock
                            : null,

                    'reference' =>
                        'INITIAL-STOCK',

                    'notes' =>
                        'Stok awal barang.',

                    'occurred_at' =>
                        now(),
                ]);
            }
        });


        return redirect(
            route(
                'admin.inventory.index',
                [],
                false
            )
        )->with(
            'success',
            'Barang inventory berhasil ditambahkan.'
        );
    }


    public function edit(
        InventoryItem $inventoryItem
    ) {
        return view(
            'admin.inventory.edit',
            compact('inventoryItem')
        );
    }


    public function update(
        Request $request,
        InventoryItem $inventoryItem
    ) {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'area' => [
                'required',
                Rule::in([
                    'homestay',
                    'cafe',
                ]),
            ],

            'item_type' => [
                'required',
                Rule::in([
                    'consumable',
                    'ingredient',
                    'equipment',
                    'cleaning',
                    'other',
                ]),
            ],

            'category' => [
                'nullable',
                'string',
                'max:255',
            ],

            'unit' => [
                'required',
                'string',
                'max:30',
            ],

            'minimum_stock' => [
                'required',
                'numeric',
                'min:0',
            ],

            'purchase_price' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'location' => [
                'nullable',
                'string',
                'max:255',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        $validated['is_active'] =
            $request->boolean('is_active');

        /*
         * current_stock sengaja tidak diubah di sini.
         * Stok hanya boleh berubah melalui movement.
         */

        $inventoryItem->update(
            $validated
        );

        return redirect(
            route(
                'admin.inventory.index',
                [],
                false
            )
        )->with(
            'success',
            'Data barang berhasil diperbarui.'
        );
    }


    public function movements(
        InventoryItem $inventoryItem
    ) {
        $movements = $inventoryItem
            ->movements()
            ->with('user')
            ->latest('occurred_at')
            ->paginate(20);

        return view(
            'admin.inventory.movements',
            compact(
                'inventoryItem',
                'movements'
            )
        );
    }


    public function storeMovement(
        Request $request,
        InventoryItem $inventoryItem
    ) {
        $validated = $request->validate([
            'movement_type' => [
                'required',
                Rule::in([
                    'STOCK_IN',
                    'USED',
                    'DAMAGED',
                    'LOST',
                    'RETURNED',
                    'ADJUSTMENT_IN',
                    'ADJUSTMENT_OUT',
                ]),
            ],

            'quantity' => [
                'required',
                'numeric',
                'gt:0',
            ],

            'unit_cost' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'reference' => [
                'nullable',
                'string',
                'max:255',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'occurred_at' => [
                'nullable',
                'date',
            ],
        ]);


        DB::transaction(function () use (
            $validated,
            $inventoryItem
        ) {
            $item = InventoryItem::query()
                ->lockForUpdate()
                ->findOrFail(
                    $inventoryItem->id
                );

            $quantity = (float) (
                $validated['quantity']
            );

            $stockBefore = (float) (
                $item->current_stock
            );

            $increaseTypes = [
                'STOCK_IN',
                'RETURNED',
                'ADJUSTMENT_IN',
            ];

            $isIncrease = in_array(
                $validated['movement_type'],
                $increaseTypes,
                true
            );

            $stockAfter = $isIncrease
                ? $stockBefore + $quantity
                : $stockBefore - $quantity;


            if ($stockAfter < 0) {
                throw ValidationException::withMessages([
                    'quantity' =>
                        'Stok tidak mencukupi. '
                        . 'Stok saat ini: '
                        . number_format(
                            $stockBefore,
                            3,
                            ',',
                            '.'
                        )
                        . ' '
                        . $item->unit
                        . '.',
                ]);
            }


            $unitCost = isset(
                $validated['unit_cost']
            )
                ? (float) $validated[
                    'unit_cost'
                ]
                : (
                    $item->purchase_price !== null
                        ? (float) $item->purchase_price
                        : null
                );


            InventoryMovement::create([
                'inventory_item_id' =>
                    $item->id,

                'user_id' =>
                    auth()->id(),

                'movement_type' =>
                    $validated['movement_type'],

                'quantity' =>
                    $quantity,

                'stock_before' =>
                    $stockBefore,

                'stock_after' =>
                    $stockAfter,

                'unit_cost' =>
                    $unitCost,

                'total_cost' =>
                    $unitCost !== null
                        ? $unitCost * $quantity
                        : null,

                'reference' =>
                    $validated['reference']
                    ?? null,

                'notes' =>
                    $validated['notes']
                    ?? null,

                'occurred_at' =>
                    $validated['occurred_at']
                    ?? now(),
            ]);


            $item->current_stock =
                $stockAfter;

            $item->save();
        });


        return back()->with(
            'success',
            'Pergerakan stok berhasil dicatat.'
        );
    }


    private function generateItemCode(
        string $area
    ): string {
        $prefix = $area === 'homestay'
            ? 'INV-HST'
            : 'INV-CAF';

        do {
            $code =
                $prefix
                . '-'
                . strtoupper(
                    Str::random(6)
                );
        } while (
            InventoryItem::where(
                'item_code',
                $code
            )->exists()
        );

        return $code;
    }
}
