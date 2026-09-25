<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Menu Management - Gok Nauli</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f5f1;
            color: #293229;
        }

        header {
            background: #26372a;
            color: white;
            padding: 18px 5%;
            display: flex;
            justify-content: space-between;
        }

        nav {
            display: flex;
            gap: 18px;
        }

        nav a {
            color: white;
            text-decoration: none;
        }

        main {
            width: 94%;
            max-width: 1300px;
            margin: 35px auto;
        }

        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .add {
            background: #31563a;
            color: white;
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 8px;
        }

        .success {
            background: #e6f4e8;
            color: #246532;
            padding: 14px;
            border-radius: 9px;
            margin-bottom: 20px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 14px;
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 950px;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 13px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        th {
            background: #f6f7f3;
        }

        .available {
            color: #26753a;
            font-weight: bold;
        }

        .unavailable {
            color: #a12822;
            font-weight: bold;
        }

        .edit {
            color: #31563a;
            font-weight: bold;
            text-decoration: none;
        }
    </style>
</head>

<body>

@include('admin.partials.header')

<main>

    <div class="top">
        <div>
            <h1>Menu Management</h1>
            <p>Kelola makanan dan minuman Gok Nauli.</p>
        </div>

        <a
            class="add"
            href="{{ route('admin.menus.create', [], false) }}"
        >
            + Tambah Menu
        </a>
    </div>

    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">

        <table>
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Tersedia</th>
                    <th>Aktif</th>
                    <th>Urutan</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

            @forelse ($menus as $menu)

                <tr>
                    <td>
                        <strong>{{ $menu->name }}</strong>

                        @if ($menu->description)
                            <div style="font-size:12px;color:#777;margin-top:4px;">
                                {{ $menu->description }}
                            </div>
                        @endif
                    </td>

                    <td>
                        {{ $menu->category->name }}
                    </td>

                    <td>
                        Rp {{ number_format(
                            $menu->price,
                            0,
                            ',',
                            '.'
                        ) }}
                    </td>

                    <td>
                        @if ($menu->is_available)
                            <span class="available">Available</span>
                        @else
                            <span class="unavailable">Out of Stock</span>
                        @endif
                    </td>

                    <td>
                        {{ $menu->is_active ? 'Ya' : 'Tidak' }}
                    </td>

                    <td>
                        {{ $menu->sort_order }}
                    </td>

                    <td>
                        <a
                            class="edit"
                            href="{{ route(
                                'admin.menus.edit',
                                $menu,
                                false
                            ) }}"
                        >
                            Edit
                        </a>
                    </td>
                </tr>

            @empty

                <tr>
                    <td colspan="7">
                        Belum ada menu.
                    </td>
                </tr>

            @endforelse

            </tbody>
        </table>

    </div>

</main>

</body>
</html>
