<?php

namespace App\Http\Controllers;

use App\Models\RestaurantTable;
use App\Models\TableReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TableReservationController extends Controller
{
    public function create()
    {
        return view('reservations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'guest_name' => ['required', 'string', 'max:255'],
            'guest_phone' => ['required', 'string', 'max:30'],
            'guest_email' => ['nullable', 'email', 'max:255'],
            'reservation_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'reservation_time' => [
                'required',
                'date_format:H:i',
            ],
            'guests' => [
                'required',
                'integer',
                'min:1',
            ],
            'notes' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $table = RestaurantTable::where('is_active', true)
            ->where('status', 'available')
            ->where('capacity', '>=', $validated['guests'])
            ->whereDoesntHave('reservations', function ($query) use ($validated) {
                $query
                    ->where('reservation_date', $validated['reservation_date'])
                    ->where('reservation_time', $validated['reservation_time'])
                    ->whereNotIn('status', ['cancelled']);
            })
            ->orderBy('capacity')
            ->orderBy('table_number')
            ->first();

        if (!$table) {
            return back()
                ->withInput()
                ->withErrors([
                    'reservation_time' =>
                        'Tidak ada meja tersedia untuk waktu dan jumlah tamu tersebut.',
                ]);
        }

        $reservation = TableReservation::create([
            'reservation_code' =>
                'RSV-' . strtoupper(Str::random(8)),

            'restaurant_table_id' => $table->id,
            'guest_name' => $validated['guest_name'],
            'guest_phone' => $validated['guest_phone'],
            'guest_email' => $validated['guest_email'] ?? null,
            'reservation_date' => $validated['reservation_date'],
            'reservation_time' => $validated['reservation_time'],
            'guests' => $validated['guests'],
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);

        return response('', 302)
            ->header(
                'Location',
                route(
                    'reservations.success',
                    ['reservation' => $reservation],
                    false
                )
            );
    }

    public function success(TableReservation $reservation)
    {
        $reservation->load('restaurantTable');

        return view(
            'reservations.success',
            compact('reservation')
        );
    }
}
