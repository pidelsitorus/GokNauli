<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoomTypeController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::withCount('rooms')
            ->orderBy('name')
            ->get();

        return view('admin.room-types.index', compact('roomTypes'));
    }

    public function create()
    {
        return view('admin.room-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:room_types,name',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'capacity' => [
                'required',
                'integer',
                'min:1',
            ],
            'base_price' => [
                'required',
                'numeric',
                'min:0',
            ],
            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        $validated['is_active'] =
            $request->boolean('is_active');

        RoomType::create($validated);

        return redirect(
            route('admin.room-types.index', [], false)
        )->with(
            'success',
            'Tipe kamar berhasil ditambahkan.'
        );
    }

    public function edit(RoomType $roomType)
    {
        return view(
            'admin.room-types.edit',
            compact('roomType')
        );
    }

    public function update(
        Request $request,
        RoomType $roomType
    ) {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('room_types', 'name')
                    ->ignore($roomType->id),
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'capacity' => [
                'required',
                'integer',
                'min:1',
            ],
            'base_price' => [
                'required',
                'numeric',
                'min:0',
            ],
            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        $validated['is_active'] =
            $request->boolean('is_active');

        $roomType->update($validated);

        return redirect(
            route('admin.room-types.index', [], false)
        )->with(
            'success',
            'Tipe kamar berhasil diperbarui.'
        );
    }
}
