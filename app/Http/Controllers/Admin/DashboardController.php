<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Order;
use App\Models\TableReservation;
use App\Models\InventoryItem;
use App\Models\FacilityAsset;

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

            'homestay_revenue' => Booking::where(
                'payment_status',
                'paid'
            )->sum('total_price'),

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

            'cafe_revenue' => Order::where(
                'payment_status',
                'paid'
            )->sum('subtotal'),

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
                'maintenanceDue'

            )
        );
    }
}
