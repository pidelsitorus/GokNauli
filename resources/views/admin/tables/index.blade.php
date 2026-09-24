<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Table Management - Gok Nauli</title>

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
            gap: 16px;
            flex-wrap: wrap;
        }

        nav a {
            color: white;
            text-decoration: none;
        }

        main {
            width: 92%;
            max-width: 1250px;
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
            min-width: 850px;
            border-collapse: collapse;
        }

        th, td {
            padding: 13px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        th {
            background: #f6f7f3;
        }

        .badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            background: #edf2e9;
            font-size: 12px;
        }

        .edit {
            color: #31563a;
            font-weight: bold;
            text-decoration: none;
        }
    </style>
</head>

<body>

<header>

    <strong>Gok Nauli Admin</strong>

    <nav>
        <a href="{{ route('admin.dashboard', [], false) }}">
            Dashboard
        </a>

        <a href="{{ route('admin.bookings.index', [], false) }}">
            Booking
        </a>

        <a href="{{ route('admin.rooms.index', [], false) }}">
            Rooms
        </a>

        <a href="{{ route('admin.menus.index', [], false) }}">
            Menu
        </a>

        <a href="{{ route('admin.reservations.index', [], false) }}">
            Reservations
        </a>

        <a href="{{ route('admin.tables.index', [], false) }}">
            Tables
        </a>
    </nav>

</header>

<main>

    <div class="top">

        <div>
            <h1>Table Management</h1>

            <p>
                Kelola meja Cafe & Resto Gok Nauli.
            </p>
        </div>

        <a
            class="add"
            href="{{ route('admin.tables.create', [], false) }}"
        >
            + Tambah Meja
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
                    <th>Nomor</th>
                    <th>Nama</th>
                    <th>Kapasitas</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                    <th>Aktif</th>
                    <th>Reservasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

            @forelse ($tables as $table)

                <tr>

                    <td>
                        <strong>
                            {{ $table->table_number }}
                        </strong>
                    </td>

                    <td>
                        {{ $table->name ?? '-' }}
                    </td>

                    <td>
                        {{ $table->capacity }} orang
                    </td>

                    <td>
                        {{ $table->location ?? '-' }}
                    </td>

                    <td>
                        <span class="badge">
                            {{ ucfirst($table->status) }}
                        </span>
                    </td>

                    <td>
                        {{ $table->is_active ? 'Ya' : 'Tidak' }}
                    </td>

                    <td>
                        {{ $table->reservations_count }}
                    </td>

                    <td>
                        <a
                            class="edit"
                            href="{{ route(
                                'admin.tables.edit',
                                $table,
                                false
                            ) }}"
                        >
                            Edit
                        </a>
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="8">
                        Belum ada meja.
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</main>

</body>
</html>
