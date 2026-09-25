@csrf

<div class="form-group">
    <label>Kategori</label>

    <select name="menu_category_id" required>
        @foreach ($categories as $category)
        <option
            value="{{ $category->id }}"
            @selected(
            old( 'menu_category_id' ,
            $menu->menu_category_id ?? ''
            ) == $category->id
            )
            >
            {{ $category->name }}
        </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label>Nama Menu</label>

    <input
        type="text"
        name="name"
        value="{{ old('name', $menu->name ?? '') }}"
        required>
</div>

<div class="grid">
    <div class="form-group">
        <label>Harga</label>

        <input
            type="number"
            name="price"
            value="{{ old('price', $menu->price ?? '') }}"
            min="0"
            required>
    </div>

    <div class="form-group">
        <label>Urutan</label>

        <input
            type="number"
            name="sort_order"
            value="{{ old('sort_order', $menu->sort_order ?? 0) }}"
            min="0">
    </div>
</div>

<div class="form-group">
    <label>Deskripsi</label>

    <textarea name="description">{{ old(
        'description',
        $menu->description ?? ''
    ) }}</textarea>
</div>

<label class="checkbox">
    <input
        type="checkbox"
        name="is_available"
        value="1"
        @checked(
        old( 'is_available' ,
        $menu->is_available ?? true
    )
    )
    >

    Menu tersedia
</label>

<label class="checkbox">
    <input
        type="checkbox"
        name="is_active"
        value="1"
        @checked(
        old( 'is_active' ,
        $menu->is_active ?? true
    )
    )
    >

    Menu aktif
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

<div class="form-group">

    <label>
        Foto Menu
    </label>

    @if (!empty($menu?->image))

    <div style="margin-bottom:12px">

        <img
            src="{{ asset('storage/' . $menu->image) }}"
            alt="{{ $menu->name }}"
            style="
                    width:220px;
                    height:140px;
                    object-fit:cover;
                    border-radius:10px;
                ">

    </div>

    @endif

    <input
        type="file"
        name="image"
        accept=".jpg,.jpeg,.png,.webp">

    <small>
        JPG, PNG atau WebP. Maksimal 4 MB.
    </small>

</div>

<button type="submit">
    Simpan Menu
</button>