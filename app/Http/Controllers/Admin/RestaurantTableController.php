<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RestaurantTable;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RestaurantTableController extends Controller
{
    public function index()
    {
        $tables = RestaurantTable::withCount('reservations')
            ->orderBy('table_number')
            ->get();

        return view('admin.tables.index', compact('tables'));
    }

    public function create()
    {
        return view('admin.tables.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'table_number' => [
                'required',
                'string',
                'max:50',
                'unique:restaurant_tables,table_number',
            ],
            'name' => [
                'nullable',
                'string',
                'max:255',
            ],
            'capacity' => [
                'required',
                'integer',
                'min:1',
            ],
            'location' => [
                'required',
                Rule::in([
                    'Indoor',
                    'Outdoor',
                ]),
            ],
            'status' => [
                'required',
                Rule::in([
                    'available',
                    'maintenance',
                    'inactive',
                ]),
            ],
            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        $validated['is_active'] =
            $request->boolean('is_active');

        RestaurantTable::create($validated);

        return redirect(
            route('admin.tables.index', [], false)
        )->with(
            'success',
            'Meja berhasil ditambahkan.'
        );
    }

    public function edit(RestaurantTable $table)
    {
        return view(
            'admin.tables.edit',
            compact('table')
        );
    }

    public function update(
        Request $request,
        RestaurantTable $table
    ) {
        $validated = $request->validate([
            'table_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique(
                    'restaurant_tables',
                    'table_number'
                )->ignore($table->id),
            ],
            'name' => [
                'nullable',
                'string',
                'max:255',
            ],
            'capacity' => [
                'required',
                'integer',
                'min:1',
            ],
            'location' => [
                'required',
                Rule::in([
                    'Indoor',
                    'Outdoor',
                ]),
            ],
            'status' => [
                'required',
                Rule::in([
                    'available',
                    'maintenance',
                    'inactive',
                ]),
            ],
            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);

        $validated['is_active'] =
            $request->boolean('is_active');

        $table->update($validated);

        return redirect(
            route('admin.tables.index', [], false)
        )->with(
            'success',
            'Data meja berhasil diperbarui.'
        );
    }
}
