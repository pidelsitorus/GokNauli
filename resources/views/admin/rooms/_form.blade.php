@csrf

<div class="form-group">
    <label>Tipe Kamar</label>

    <select name="room_type_id" required>
        @foreach ($roomTypes as $type)
            <option
                value="{{ $type->id }}"
                @selected(
                    old(
                        'room_type_id',
                        $room->room_type_id ?? ''
                    ) == $type->id
                )
            >
                {{ $type->name }}
            </option>
        @endforeach
    </select>
</div>

<div class="grid">

    <div class="form-group">
        <label>Nomor Kamar</label>

        <input
            type="text"
            name="room_number"
            value="{{ old('room_number', $room->room_number ?? '') }}"
            placeholder="Contoh: GN-101"
            required
        >
    </div>

    <div class="form-group">
        <label>Nama Kamar</label>

        <input
            type="text"
            name="name"
            value="{{ old('name', $room->name ?? '') }}"
            required
        >
    </div>

</div>

<div class="grid">

    <div class="form-group">
        <label>Harga / Malam</label>

        <input
            type="number"
            name="price"
            value="{{ old('price', $room->price ?? '') }}"
            min="0"
        >
    </div>

    <div class="form-group">
        <label>Status</label>

        <select name="status">

            @foreach ([
                'available' => 'Available',
                'occupied' => 'Occupied',
                'maintenance' => 'Maintenance',
                'inactive' => 'Inactive',
            ] as $value => $label)

                <option
                    value="{{ $value }}"
                    @selected(
                        old(
                            'status',
                            $room->status ?? 'available'
                        ) === $value
                    )
                >
                    {{ $label }}
                </option>

            @endforeach

        </select>
    </div>

</div>

<div class="form-group">
    <label>Deskripsi</label>

    <textarea name="description">{{ old(
        'description',
        $room->description ?? ''
    ) }}</textarea>
</div>

<label class="checkbox">
    <input
        type="checkbox"
        name="is_active"
        value="1"
        @checked(
            old(
                'is_active',
                $room->is_active ?? true
            )
        )
    >

    Kamar aktif dan dapat ditampilkan
</label>

@if ($errors->any())

    <div class="error">

        <strong>Periksa data berikut:</strong>

        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>

    </div>

@endif

<button type="submit">
    Simpan Kamar
</button>
