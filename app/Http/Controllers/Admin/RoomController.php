<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('roomType')
            ->orderBy('room_number')
            ->get();

        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        $roomTypes = RoomType::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('admin.rooms.create', compact('roomTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_type_id' => ['required', 'exists:room_types,id'],
            'room_number' => ['required', 'string', 'max:50', 'unique:rooms,room_number'],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'status' => [
                'required',
                Rule::in([
                    'available',
                    'occupied',
                    'maintenance',
                    'inactive',
                ]),
            ],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        Room::create($validated);

        return redirect(
            route('admin.rooms.index', [], false)
        )->with('success', 'Kamar berhasil ditambahkan.');
    }

    public function edit(Room $room)
    {
        $roomTypes = RoomType::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view(
            'admin.rooms.edit',
            compact('room', 'roomTypes')
        );
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_type_id' => ['required', 'exists:room_types,id'],
            'room_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('rooms', 'room_number')->ignore($room->id),
            ],
            'name' => ['required', 'string', 'max:255'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'status' => [
                'required',
                Rule::in([
                    'available',
                    'occupied',
                    'maintenance',
                    'inactive',
                ]),
            ],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $room->update($validated);

        return redirect(
            route('admin.rooms.index', [], false)
        )->with('success', 'Data kamar berhasil diperbarui.');
    }
}
