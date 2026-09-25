<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Order;
use App\Models\TableReservation;

class DashboardController extends Controller
{
    public function index()
    {
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
            )->count(),

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
        ];

        $latestBookings = Booking::with([
            'room.roomType',
        ])
            ->latest()
            ->take(5)
            ->get();

        $latestReservations = TableReservation::with(
            'restaurantTable'
        )
            ->latest()
            ->take(5)
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
                'latestOrders'
            )
        );
    }
}
