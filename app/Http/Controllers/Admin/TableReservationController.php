<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TableReservation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TableReservationController extends Controller
{
    public function index(Request $request)
    {
        $reservations = TableReservation::with('restaurantTable')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($query) use ($search) {
                    $query
                        ->where('reservation_code', 'like', "%{$search}%")
                        ->orWhere('guest_name', 'like', "%{$search}%")
                        ->orWhere('guest_phone', 'like', "%{$search}%")
                        ->orWhere('guest_email', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->filled('date'), function ($query) use ($request) {
                $query->whereDate('reservation_date', $request->date);
            })
            ->orderByDesc('reservation_date')
            ->orderByDesc('reservation_time')
            ->paginate(15)
            ->withQueryString();

        return view(
            'admin.reservations.index',
            compact('reservations')
        );
    }

    public function updateStatus(
        Request $request,
        TableReservation $reservation
    ) {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'pending',
                    'confirmed',
                    'seated',
                    'completed',
                    'cancelled',
                    'expired',
                ]),
            ],
        ]);

        $reservation->update([
            'status' => $validated['status'],
        ]);

        return back()->with(
            'success',
            'Status reservasi berhasil diperbarui.'
        );
    }
}
