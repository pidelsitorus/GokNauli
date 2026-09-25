@if ($errors->any())
    <div class="error-box">
        <strong>Data belum dapat disimpan.</strong>

        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<div class="form-grid">

    <div class="form-group">
        <label for="name">Nama Barang</label>

        <input
            id="name"
            type="text"
            name="name"
            value="{{ old(
                'name',
                $inventoryItem->name ?? ''
            ) }}"
            required
        >
    </div>


    <div class="form-group">
        <label for="area">Area</label>

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
                        $inventoryItem->area ?? ''
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
                        $inventoryItem->area ?? ''
                    ) === 'cafe'
                )
            >
                Cafe & Resto
            </option>
        </select>
    </div>


    <div class="form-group">
        <label for="item_type">
            Jenis Barang
        </label>

        <select
            id="item_type"
            name="item_type"
            required
        >
            @php
                $types = [
                    'consumable' => 'Consumable',
                    'ingredient' => 'Bahan',
                    'equipment' => 'Equipment',
                    'cleaning' => 'Cleaning',
                    'other' => 'Lainnya',
                ];

                $selectedType = old(
                    'item_type',
                    $inventoryItem->item_type ?? ''
                );
            @endphp

            <option value="">
                Pilih Jenis
            </option>

            @foreach ($types as $value => $label)
                <option
                    value="{{ $value }}"
                    @selected(
                        $selectedType === $value
                    )
                >
                    {{ $label }}
                </option>
            @endforeach
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
                $inventoryItem->category ?? ''
            ) }}"
            placeholder="Contoh: Linen, Minuman, Dapur"
        >
    </div>


    <div class="form-group">
        <label for="unit">
            Satuan
        </label>

        <input
            id="unit"
            type="text"
            name="unit"
            value="{{ old(
                'unit',
                $inventoryItem->unit ?? ''
            ) }}"
            placeholder="pcs, kg, liter, roll..."
            required
        >
    </div>


    @if (!isset($inventoryItem))

        <div class="form-group">
            <label for="initial_stock">
                Stok Awal
            </label>

            <input
                id="initial_stock"
                type="number"
                step="0.001"
                min="0"
                name="initial_stock"
                value="{{ old('initial_stock', 0) }}"
            >
        </div>

    @endif


    <div class="form-group">
        <label for="minimum_stock">
            Minimum Stok
        </label>

        <input
            id="minimum_stock"
            type="number"
            step="0.001"
            min="0"
            name="minimum_stock"
            value="{{ old(
                'minimum_stock',
                $inventoryItem->minimum_stock ?? 0
            ) }}"
            required
        >
    </div>


        {-- Owner Only: Inventory Purchase Price --}
    @if (auth()->user()?->isOwner())

<div class="form-group">
        <label for="purchase_price">
            Harga Satuan
        </label>

        <input
            id="purchase_price"
            type="number"
            step="0.01"
            min="0"
            name="purchase_price"
            value="{{ old(
                'purchase_price',
                $inventoryItem->purchase_price ?? ''
            ) }}"
            placeholder="Opsional"
        >
    </div>

    @endif


    <div class="form-group">
        <label for="location">
            Lokasi Penyimpanan
        </label>

        <input
            id="location"
            type="text"
            name="location"
            value="{{ old(
                'location',
                $inventoryItem->location ?? ''
            ) }}"
            placeholder="Gudang, Dapur, Kamar..."
        >
    </div>

</div>


<div class="form-group">
    <label for="notes">
        Catatan
    </label>

    <textarea
        id="notes"
        name="notes"
    >{{ old(
        'notes',
        $inventoryItem->notes ?? ''
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
                isset($inventoryItem)
                    ? $inventoryItem->is_active
                    : true
            )
        )
    >

    Barang Aktif
</label>
