@if ($errors->any())

    <div class="error-box">

        <strong>
            Data belum dapat disimpan.
        </strong>

        <ul>
            @foreach ($errors->all() as $error)
                <li>
                    {{ $error }}
                </li>
            @endforeach
        </ul>

    </div>

@endif


<div class="form-grid">

    <div class="form-group">

        <label for="name">
            Nama Aset
        </label>

        <input
            id="name"
            type="text"
            name="name"
            value="{{ old(
                'name',
                $facilityAsset->name ?? ''
            ) }}"
            placeholder="Contoh: AC Kamar GN-101"
            required
        >

    </div>


    <div class="form-group">

        <label for="area">
            Area
        </label>

        <select
            id="area"
            name="area"
            required
        >

            <option value="">
                Pilih Area
            </option>

            <option
                value="homestay"
                @selected(
                    old(
                        'area',
                        $facilityAsset->area ?? ''
                    ) === 'homestay'
                )
            >
                Homestay
            </option>

            <option
                value="cafe"
                @selected(
                    old(
                        'area',
                        $facilityAsset->area ?? ''
                    ) === 'cafe'
                )
            >
                Cafe & Resto
            </option>

        </select>

    </div>


    <div class="form-group">

        <label for="category">
            Kategori
        </label>

        <input
            id="category"
            type="text"
            name="category"
            value="{{ old(
                'category',
                $facilityAsset->category ?? ''
            ) }}"
            placeholder="AC, Elektronik, Furniture..."
        >

    </div>


    <div class="form-group">

        <label for="location">
            Lokasi
        </label>

        <input
            id="location"
            type="text"
            name="location"
            value="{{ old(
                'location',
                $facilityAsset->location ?? ''
            ) }}"
            placeholder="GN-101, Dapur, Cafe..."
        >

    </div>


    <div class="form-group">

        <label for="brand">
            Merek
        </label>

        <input
            id="brand"
            type="text"
            name="brand"
            value="{{ old(
                'brand',
                $facilityAsset->brand ?? ''
            ) }}"
        >

    </div>


    <div class="form-group">

        <label for="model">
            Model
        </label>

        <input
            id="model"
            type="text"
            name="model"
            value="{{ old(
                'model',
                $facilityAsset->model ?? ''
            ) }}"
        >

    </div>


    <div class="form-group">

        <label for="serial_number">
            Serial Number
        </label>

        <input
            id="serial_number"
            type="text"
            name="serial_number"
            value="{{ old(
                'serial_number',
                $facilityAsset->serial_number ?? ''
            ) }}"
        >

    </div>


    <div class="form-group">

        <label for="purchase_date">
            Tanggal Pembelian
        </label>

        <input
            id="purchase_date"
            type="date"
            name="purchase_date"
            value="{{ old(
                'purchase_date',
                isset($facilityAsset)
                    && $facilityAsset->purchase_date
                        ? $facilityAsset
                            ->purchase_date
                            ->format('Y-m-d')
                        : ''
            ) }}"
        >

    </div>


    <div class="form-group">

        <label for="purchase_price">
            Harga Pembelian
        </label>

        <input
            id="purchase_price"
            type="number"
            name="purchase_price"
            step="0.01"
            min="0"
            value="{{ old(
                'purchase_price',
                $facilityAsset->purchase_price ?? ''
            ) }}"
        >

    </div>


    <div class="form-group">

        <label for="next_maintenance_at">
            Maintenance Berikutnya
        </label>

        <input
            id="next_maintenance_at"
            type="date"
            name="next_maintenance_at"
            value="{{ old(
                'next_maintenance_at',
                isset($facilityAsset)
                    && $facilityAsset->next_maintenance_at
                        ? $facilityAsset
                            ->next_maintenance_at
                            ->format('Y-m-d')
                        : ''
            ) }}"
        >

    </div>

</div>


@if (!isset($facilityAsset))

    <div class="form-grid">

        <div class="form-group">

            <label for="condition">
                Kondisi Awal
            </label>

            <select
                id="condition"
                name="condition"
                required
            >

                @foreach ([
                    'good' => 'Baik',
                    'needs_maintenance' =>
                        'Perlu Maintenance',
                    'damaged' => 'Rusak',
                    'under_repair' =>
                        'Dalam Perbaikan',
                ] as $value => $label)

                    <option
                        value="{{ $value }}"
                        @selected(
                            old(
                                'condition',
                                'good'
                            ) === $value
                        )
                    >
                        {{ $label }}
                    </option>

                @endforeach

            </select>

        </div>


        <div class="form-group">

            <label for="status">
                Status
            </label>

            <select
                id="status"
                name="status"
                required
            >

                <option value="active">
                    Active
                </option>

            </select>

        </div>

    </div>

@else

    <input
        type="hidden"
        name="condition"
        value="{{ $facilityAsset->condition }}"
    >

    <input
        type="hidden"
        name="status"
        value="{{ $facilityAsset->status }}"
    >

@endif


<div class="form-group">

    <label for="notes">
        Catatan
    </label>

    <textarea
        id="notes"
        name="notes"
    >{{ old(
        'notes',
        $facilityAsset->notes ?? ''
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
                isset($facilityAsset)
                    ? $facilityAsset->is_active
                    : true
            )
        )
    >

    Aset Aktif

</label>
