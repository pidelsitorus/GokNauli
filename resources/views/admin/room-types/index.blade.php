<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Room Type Management - Gok Nauli</title>

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
            width: 92%;
            max-width: 1200px;
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
            <h1>Room Type Management</h1>
            <p>Kelola tipe dan harga dasar kamar.</p>
        </div>

        <a
            class="add"
            href="{{ route('admin.room-types.create', [], false) }}"
        >
            + Tambah Tipe
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
                    <th>Tipe</th>
                    <th>Kapasitas</th>
                    <th>Harga Dasar</th>
                    <th>Jumlah Kamar</th>
                    <th>Aktif</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

            @foreach ($roomTypes as $type)

                <tr>

                    <td>
                        <strong>{{ $type->name }}</strong>
                    </td>

                    <td>
                        {{ $type->capacity }} tamu
                    </td>

                    <td>
                        Rp {{ number_format(
                            $type->base_price,
                            0,
                            ',',
                            '.'
                        ) }}
                    </td>

                    <td>
                        {{ $type->rooms_count }}
                    </td>

                    <td>
                        {{ $type->is_active ? 'Ya' : 'Tidak' }}
                    </td>

                    <td>
                        <a
                            class="edit"
                            href="{{ route(
                                'admin.room-types.edit',
                                $type,
                                false
                            ) }}"
                        >
                            Edit
                        </a>
                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

    </div>

</main>

</body>
</html>
