<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'check_in' => [
                'nullable',
                'date',
                'after_or_equal:today',
                'required_with:check_out',
            ],
            'check_out' => [
                'nullable',
                'date',
                'after:check_in',
                'required_with:check_in',
            ],
        ]);

        $checkIn = $validated['check_in'] ?? null;
        $checkOut = $validated['check_out'] ?? null;

        $rooms = Room::with('roomType')
            ->where('is_active', true)
            ->where('status', '!=', 'maintenance')
            ->when($checkIn && $checkOut, function ($query) use ($checkIn, $checkOut) {
                $query->whereDoesntHave('bookings', function ($bookingQuery) use ($checkIn, $checkOut) {
                    $bookingQuery
                        ->whereNotIn('status', ['cancelled'])
                        ->where('check_in', '<', $checkOut)
                        ->where('check_out', '>', $checkIn);
                });
            })
            ->orderBy('room_number')
            ->get();

        return view('rooms.index', compact(
            'rooms',
            'checkIn',
            'checkOut'
        ));
    }

    public function createBooking(Request $request, Room $room)
    {
        $room->load('roomType');

        $checkIn = $request->query('check_in');
        $checkOut = $request->query('check_out');

        return view('rooms.booking', compact(
            'room',
            'checkIn',
            'checkOut'
        ));
    }

    public function storeBooking(Request $request, Room $room)
    {
        $validated = $request->validate([
            'guest_name' => ['required', 'string', 'max:255'],
            'guest_phone' => ['required', 'string', 'max:30'],
            'guest_email' => ['nullable', 'email', 'max:255'],
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'adults' => ['required', 'integer', 'min:1'],
            'children' => ['nullable', 'integer', 'min:0'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $hasConflict = Booking::where('room_id', $room->id)
            ->whereNotIn('status', ['cancelled'])
            ->where('check_in', '<', $validated['check_out'])
            ->where('check_out', '>', $validated['check_in'])
            ->exists();

        if ($hasConflict) {
            return back()
                ->withInput()
                ->withErrors([
                    'check_in' => 'Kamar tidak tersedia pada tanggal tersebut.',
                ]);
        }

        $checkIn = Carbon::parse($validated['check_in']);
        $checkOut = Carbon::parse($validated['check_out']);

        $nights = $checkIn->diffInDays($checkOut);

        $pricePerNight = $room->price ?? $room->roomType->base_price;

        $booking = Booking::create([
            'booking_code' => 'GN-' . strtoupper(Str::random(8)),
            'room_id' => $room->id,
            'guest_name' => $validated['guest_name'],
            'guest_phone' => $validated['guest_phone'],
            'guest_email' => $validated['guest_email'] ?? null,
            'check_in' => $validated['check_in'],
            'check_out' => $validated['check_out'],
            'adults' => $validated['adults'],
            'children' => $validated['children'] ?? 0,
            'total_price' => $pricePerNight * $nights,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'notes' => $validated['notes'] ?? null,
        ]);

        return response('', 302)
            ->header(
                'Location',
                route('booking.success', ['booking' => $booking], false)
            );
    }

    public function bookingSuccess(Booking $booking)
    {
        $booking->load('room.roomType');

        return view('rooms.booking-success', compact('booking'));
    }
}
