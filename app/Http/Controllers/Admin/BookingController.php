<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $bookings = Booking::with('room.roomType')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($query) use ($search) {
                    $query
                        ->where('booking_code', 'like', "%{$search}%")
                        ->orWhere('guest_name', 'like', "%{$search}%")
                        ->orWhere('guest_phone', 'like', "%{$search}%")
                        ->orWhere('guest_email', 'like', "%{$search}%");
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
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view(
            'admin.bookings.index',
            compact('bookings')
        );
    }

    public function updateStatus(
        Request $request,
        Booking $booking
    ) {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'pending',
                    'confirmed',
                    'checked_in',
                    'checked_out',
                    'cancelled',
                ]),
            ],
        ]);

        $booking->update([
            'status' => $validated['status'],
        ]);

        return back()->with(
            'success',
            'Status booking berhasil diperbarui.'
        );
    }

    public function updatePayment(
        Request $request,
        Booking $booking
    ) {
        $validated = $request->validate([
            'payment_status' => [
                'required',
                Rule::in([
                    'unpaid',
                    'partial',
                    'paid',
                    'refunded',
                ]),
            ],
        ]);

        $newStatus = $validated['payment_status'];

        if (
            $newStatus === 'paid'
            && $booking->payment_status !== 'paid'
        ) {
            $booking->paid_at = now();
        }

        $booking->payment_status = $newStatus;
        $booking->save();

        return back()->with(
            'success',
            'Status pembayaran berhasil diperbarui.'
        );
    }
}
