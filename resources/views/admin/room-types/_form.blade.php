@csrf

<div class="form-group">
    <label>Nama Tipe Kamar</label>

    <input
        type="text"
        name="name"
        value="{{ old('name', $roomType->name ?? '') }}"
        placeholder="Contoh: Deluxe Room"
        required
    >
</div>

<div class="grid">

    <div class="form-group">
        <label>Kapasitas Tamu</label>

        <input
            type="number"
            name="capacity"
            value="{{ old('capacity', $roomType->capacity ?? 2) }}"
            min="1"
            required
        >
    </div>

    <div class="form-group">
        <label>Harga Dasar / Malam</label>

        <input
            type="number"
            name="base_price"
            value="{{ old('base_price', $roomType->base_price ?? '') }}"
            min="0"
            required
        >
    </div>

</div>

<div class="form-group">
    <label>Deskripsi</label>

    <textarea name="description">{{ old(
        'description',
        $roomType->description ?? ''
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
                $roomType->is_active ?? true
            )
        )
    >

    Tipe kamar aktif
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
    Simpan Tipe Kamar
</button>
