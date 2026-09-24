<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with([
            'items',
            'restaurantTable',
        ])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($query) use ($search) {
                    $query
                        ->where('order_code', 'like', "%{$search}%")
                        ->orWhere('customer_name', 'like', "%{$search}%")
                        ->orWhere('customer_phone', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->filled('payment_status'), function ($query) use ($request) {
                $query->where(
                    'payment_status',
                    $request->payment_status
                );
            })
            ->when($request->filled('order_type'), function ($query) use ($request) {
                $query->where(
                    'order_type',
                    $request->order_type
                );
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view(
            'admin.orders.index',
            compact('orders')
        );
    }

    public function updateStatus(
        Request $request,
        Order $order
    ) {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'pending',
                    'confirmed',
                    'preparing',
                    'ready',
                    'completed',
                    'cancelled',
                ]),
            ],
        ]);

        $order->update([
            'status' => $validated['status'],
        ]);

        return back()->with(
            'success',
            'Status pesanan berhasil diperbarui.'
        );
    }

    public function updatePayment(
        Request $request,
        Order $order
    ) {
        $validated = $request->validate([
            'payment_status' => [
                'required',
                Rule::in([
                    'unpaid',
                    'paid',
                    'refunded',
                ]),
            ],
        ]);

        $order->update([
            'payment_status' =>
                $validated['payment_status'],
        ]);

        return back()->with(
            'success',
            'Status pembayaran berhasil diperbarui.'
        );
    }
}
