<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Order;
use App\Models\TableReservation;
use App\Models\InventoryItem;
use App\Models\InventoryMovement;
use App\Models\FacilityAsset;
use App\Models\FacilityHistory;
use App\Models\Expense;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Checkout Notifications
        |--------------------------------------------------------------------------
        |
        | Hanya booking dengan status checked_in yang dianggap
        | masih sedang menginap.
        |
        */

        $checkoutToday = Booking::with([
            'room.roomType',
        ])
            ->where('status', 'checked_in')
            ->whereDate('check_out', today())
            ->orderBy('check_out')
            ->get();


        $overdueCheckouts = Booking::with([
            'room.roomType',
        ])
            ->where('status', 'checked_in')
            ->whereDate('check_out', '<', today())
            ->orderBy('check_out')
            ->get();


        $checkoutNotificationCount =
            $checkoutToday->count()
            + $overdueCheckouts->count();


        /*
        |--------------------------------------------------------------------------
        | Dashboard Statistics
        |--------------------------------------------------------------------------
        */

        $stats = [
            'bookings_total' => Booking::count(),

            'bookings_pending' => Booking::where(
                'status',
                'pending'
            )->count(),

            'bookings_checked_in' => Booking::where(
                'status',
                'checked_in'
            )->count(),

            'checkout_today' => $checkoutToday->count(),

            'checkout_overdue' => $overdueCheckouts->count(),

            'reservations_today' => TableReservation::whereDate(
                'reservation_date',
                today()
            )->count(),

            'reservations_pending' => TableReservation::where(
                'status',
                'pending'
            )
                ->whereDate(
                    'reservation_date',
                    '>=',
                    today()
                )
                ->count(),

            'orders_today' => Order::whereDate(
                'created_at',
                today()
            )->count(),

            'orders_active' => Order::whereIn(
                'status',
                [
                    'pending',
                    'confirmed',
                    'preparing',
                    'ready',
                ]
            )->count(),


            'inventory_low_stock' =>
                InventoryItem::where(
                    'is_active',
                    true
                )
                    ->lowStock()
                    ->count(),

            'facilities_attention' =>
                FacilityAsset::where(
                    'is_active',
                    true
                )
                    ->needsAttention()
                    ->count(),

            'maintenance_due' =>
                FacilityAsset::where(
                    'is_active',
                    true
                )
                    ->maintenanceDue()
                    ->count(),
        ];


        /*
        |--------------------------------------------------------------------------
        | Owner Financial Overview
        |--------------------------------------------------------------------------
        */

        $financialOverview = null;

        if (auth()->user()?->isOwner()) {

            $currentStart =
                now()->copy()->startOfMonth();

            $currentEnd =
                now()->copy()->endOfMonth();

            $previousStart =
                now()->copy()
                    ->subMonthNoOverflow()
                    ->startOfMonth();

            $previousEnd =
                now()->copy()
                    ->subMonthNoOverflow()
                    ->endOfMonth();


            /*
             * Revenue bulan berjalan.
             */
            $homestayRevenue = (float) Booking::query()
                ->where(
                    'payment_status',
                    'paid'
                )
                ->whereBetween(
                    'paid_at',
                    [
                        $currentStart,
                        $currentEnd,
                    ]
                )
                ->sum('total_price');

            $cafeRevenue = (float) Order::query()
                ->where(
                    'payment_status',
                    'paid'
                )
                ->whereBetween(
                    'paid_at',
                    [
                        $currentStart,
                        $currentEnd,
                    ]
                )
                ->sum('subtotal');

            $currentRevenue =
                $homestayRevenue
                + $cafeRevenue;


            /*
             * Revenue bulan sebelumnya.
             */
            $previousRevenue =
                (float) Booking::query()
                    ->where(
                        'payment_status',
                        'paid'
                    )
                    ->whereBetween(
                        'paid_at',
                        [
                            $previousStart,
                            $previousEnd,
                        ]
                    )
                    ->sum('total_price')
                +
                (float) Order::query()
                    ->where(
                        'payment_status',
                        'paid'
                    )
                    ->whereBetween(
                        'paid_at',
                        [
                            $previousStart,
                            $previousEnd,
                        ]
                    )
                    ->sum('subtotal');


            /*
             * Inventory cost.
             */
            $movementTypes = [
                'USED',
                'DAMAGED',
                'LOST',
                'ADJUSTMENT_OUT',
            ];

            $currentInventoryCost =
                (float) InventoryMovement::query()
                    ->whereIn(
                        'movement_type',
                        $movementTypes
                    )
                    ->whereBetween(
                        'occurred_at',
                        [
                            $currentStart,
                            $currentEnd,
                        ]
                    )
                    ->sum('total_cost');

            $previousInventoryCost =
                (float) InventoryMovement::query()
                    ->whereIn(
                        'movement_type',
                        $movementTypes
                    )
                    ->whereBetween(
                        'occurred_at',
                        [
                            $previousStart,
                            $previousEnd,
                        ]
                    )
                    ->sum('total_cost');


            /*
             * Facilities cost.
             */
            $currentFacilityCost =
                (float) FacilityHistory::query()
                    ->whereBetween(
                        'occurred_at',
                        [
                            $currentStart,
                            $currentEnd,
                        ]
                    )
                    ->sum('cost');

            $previousFacilityCost =
                (float) FacilityHistory::query()
                    ->whereBetween(
                        'occurred_at',
                        [
                            $previousStart,
                            $previousEnd,
                        ]
                    )
                    ->sum('cost');


            /*
             * Expenses.
             */
            $currentExpenseCost =
                (float) Expense::query()
                    ->whereBetween(
                        'expense_date',
                        [
                            $currentStart->toDateString(),
                            $currentEnd->toDateString(),
                        ]
                    )
                    ->sum('amount');

            $previousExpenseCost =
                (float) Expense::query()
                    ->whereBetween(
                        'expense_date',
                        [
                            $previousStart->toDateString(),
                            $previousEnd->toDateString(),
                        ]
                    )
                    ->sum('amount');


            $currentOperationalCost =
                $currentInventoryCost
                + $currentFacilityCost
                + $currentExpenseCost;

            $previousOperationalCost =
                $previousInventoryCost
                + $previousFacilityCost
                + $previousExpenseCost;


            $currentSurplus =
                $currentRevenue
                - $currentOperationalCost;

            $previousSurplus =
                $previousRevenue
                - $previousOperationalCost;


            /*
             * Top 5 Expense categories.
             */
            $categoryLabels = [
                'electricity' => 'Listrik',
                'water' => 'Air',
                'internet' => 'Internet',
                'salary' => 'Gaji',
                'tax' => 'Pajak',
                'transport' => 'Transportasi',
                'office_supplies' =>
                    'Perlengkapan Kantor',
                'marketing' => 'Marketing',
                'rent' => 'Sewa',
                'bank_fee' => 'Biaya Bank',
                'other' => 'Lainnya',
            ];

            $topExpenses = Expense::query()
                ->selectRaw(
                    'category, SUM(amount) as total'
                )
                ->whereBetween(
                    'expense_date',
                    [
                        $currentStart->toDateString(),
                        $currentEnd->toDateString(),
                    ]
                )
                ->groupBy('category')
                ->orderByDesc('total')
                ->take(5)
                ->get()
                ->map(
                    function ($expense) use (
                        $categoryLabels
                    ) {
                        return [
                            'label' =>
                                $categoryLabels[
                                    $expense->category
                                ]
                                ?? $expense->category,

                            'total' =>
                                (float) $expense->total,
                        ];
                    }
                );


            $financialOverview = [
                'period' =>
                    $currentStart
                        ->locale('id')
                        ->translatedFormat('F Y'),

                'previous_period' =>
                    $previousStart
                        ->locale('id')
                        ->translatedFormat('F Y'),

                'homestay_revenue' =>
                    $homestayRevenue,

                'cafe_revenue' =>
                    $cafeRevenue,

                'revenue' =>
                    $currentRevenue,

                'inventory_cost' =>
                    $currentInventoryCost,

                'facility_cost' =>
                    $currentFacilityCost,

                'expense_cost' =>
                    $currentExpenseCost,

                'operational_cost' =>
                    $currentOperationalCost,

                'surplus' =>
                    $currentSurplus,

                'previous_revenue' =>
                    $previousRevenue,

                'previous_operational_cost' =>
                    $previousOperationalCost,

                'previous_surplus' =>
                    $previousSurplus,

                'revenue_change' =>
                    $this->percentageChange(
                        $currentRevenue,
                        $previousRevenue
                    ),

                'cost_change' =>
                    $this->percentageChange(
                        $currentOperationalCost,
                        $previousOperationalCost
                    ),

                'surplus_change' =>
                    $this->percentageChange(
                        $currentSurplus,
                        $previousSurplus
                    ),

                'top_expenses' =>
                    $topExpenses,
            ];


            /*
             * Dipertahankan untuk kartu
             * Homestay & Cafe yang sudah ada.
             * Sekarang nilainya adalah bulan berjalan.
             */
            $stats['homestay_revenue'] =
                $homestayRevenue;

            $stats['cafe_revenue'] =
                $cafeRevenue;
        }


        /*
        |--------------------------------------------------------------------------
        | Inventory & Facilities Alerts
        |--------------------------------------------------------------------------
        */

        $lowStockItems = InventoryItem::query()
            ->where('is_active', true)
            ->lowStock()
            ->orderBy('current_stock')
            ->take(5)
            ->get();

        $facilityAttention = FacilityAsset::query()
            ->where('is_active', true)
            ->needsAttention()
            ->orderBy('name')
            ->take(5)
            ->get();

        $maintenanceDue = FacilityAsset::query()
            ->where('is_active', true)
            ->maintenanceDue()
            ->orderBy('next_maintenance_at')
            ->take(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Latest Activities
        |--------------------------------------------------------------------------
        */

        $latestBookings = Booking::with([
            'room.roomType',
        ])
            ->latest()
            ->take(5)
            ->get();

        $checkedInBookings = Booking::with([
            'room.roomType',
        ])
            ->where('status', 'checked_in')
            ->orderBy('check_out')
            ->get();

        $latestReservations = TableReservation::with(
            'restaurantTable'
        )
            ->whereDate(
                'reservation_date',
                today()
            )
            ->whereNotIn(
                'status',
                [
                    'completed',
                    'cancelled',
                    'expired',
                ]
            )
            ->orderBy('reservation_time')
            ->take(10)
            ->get();

        $latestOrders = Order::with([
            'restaurantTable',
            'items',
        ])
            ->latest()
            ->take(5)
            ->get();


        return view(
            'admin.dashboard',
            compact(
                'stats',
                'latestBookings',
                'latestReservations',
                'latestOrders',
                'checkedInBookings',
                'checkoutToday',
                'overdueCheckouts',
                'checkoutNotificationCount',
                'lowStockItems',
                'facilityAttention',
                'maintenanceDue',
                'financialOverview'

            )
        );

    }


    private function percentageChange(
        float $current,
        float $previous
    ): ?float {
        if ($previous == 0.0) {
            return null;
        }

        return (
            ($current - $previous)
            / abs($previous)
        ) * 100;
    }
}
