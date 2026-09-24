@csrf

<div class="grid">

    <div class="form-group">

        <label>Nomor Meja</label>

        <input
            type="text"
            name="table_number"
            value="{{ old(
                'table_number',
                $table->table_number ?? ''
            ) }}"
            placeholder="Contoh: T06"
            required
        >

    </div>

    <div class="form-group">

        <label>Nama Meja</label>

        <input
            type="text"
            name="name"
            value="{{ old(
                'name',
                $table->name ?? ''
            ) }}"
            placeholder="Contoh: Family Table"
        >

    </div>

</div>

<div class="grid">

    <div class="form-group">

        <label>Kapasitas</label>

        <input
            type="number"
            name="capacity"
            value="{{ old(
                'capacity',
                $table->capacity ?? 2
            ) }}"
            min="1"
            required
        >

    </div>

    <div class="form-group">

        <label>Lokasi</label>

        <select name="location" required>

            <option
                value="Indoor"
                @selected(
                    old(
                        'location',
                        $table->location ?? 'Indoor'
                    ) === 'Indoor'
                )
            >
                Indoor
            </option>

            <option
                value="Outdoor"
                @selected(
                    old(
                        'location',
                        $table->location ?? ''
                    ) === 'Outdoor'
                )
            >
                Outdoor
            </option>

        </select>

    </div>

</div>

<div class="form-group">

    <label>Status</label>

    <select name="status" required>

        @foreach ([
            'available' => 'Available',
            'maintenance' => 'Maintenance',
            'inactive' => 'Inactive',
        ] as $value => $label)

            <option
                value="{{ $value }}"
                @selected(
                    old(
                        'status',
                        $table->status ?? 'available'
                    ) === $value
                )
            >
                {{ $label }}
            </option>

        @endforeach

    </select>

</div>

<label class="checkbox">

    <input
        type="checkbox"
        name="is_active"
        value="1"
        @checked(
            old(
                'is_active',
                $table->is_active ?? true
            )
        )
    >

    Meja aktif dan dapat digunakan untuk reservasi

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
    Simpan Meja
</button>
