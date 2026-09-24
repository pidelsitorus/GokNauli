<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Management - Gok Nauli</title>

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
            align-items: center;
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
            overflow-x: auto;
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
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
            border-radius: 15px;
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
    </nav>
</header>

<main>

    <div class="top">
        <div>
            <h1>Room Management</h1>
            <p>Kelola seluruh kamar Gok Nauli.</p>
        </div>

        <a class="add"
           href="{{ route('admin.rooms.create', [], false) }}">
            + Tambah Kamar
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
                    <th>No. Kamar</th>
                    <th>Nama</th>
                    <th>Tipe</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Aktif</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

            @foreach ($rooms as $room)

                <tr>

                    <td>
                        <strong>{{ $room->room_number }}</strong>
                    </td>

                    <td>{{ $room->name }}</td>

                    <td>{{ $room->roomType->name }}</td>

                    <td>
                        Rp {{ number_format(
                            $room->price ?? $room->roomType->base_price,
                            0,
                            ',',
                            '.'
                        ) }}
                    </td>

                    <td>
                        <span class="badge">
                            {{ ucfirst($room->status) }}
                        </span>
                    </td>

                    <td>
                        {{ $room->is_active ? 'Ya' : 'Tidak' }}
                    </td>

                    <td>
                        <a class="edit"
                           href="{{ route(
                               'admin.rooms.edit',
                               $room,
                               false
                           ) }}">
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
