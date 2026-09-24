<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Reservation Management - Gok Nauli</title>

    <style>
        * {
            box-sizing: border-box;
        }

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
            gap: 16px;
            flex-wrap: wrap;
        }

        nav a {
            color: white;
            text-decoration: none;
        }

        main {
            width: 94%;
            max-width: 1450px;
            margin: 35px auto;
        }

        .filter-card,
        .table-card {
            background: white;
            padding: 20px;
            border-radius: 14px;
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
        }

        .filter-card {
            margin-bottom: 25px;
        }

        .filters {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr auto;
            gap: 12px;
        }

        input,
        select {
            width: 100%;
            padding: 11px;
            border: 1px solid #ccc;
            border-radius: 7px;
        }

        button {
            border: 0;
            background: #31563a;
            color: white;
            padding: 10px 14px;
            border-radius: 7px;
            cursor: pointer;
        }

        .success {
            background: #e6f4e8;
            color: #246532;
            padding: 14px;
            border-radius: 9px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            min-width: 1100px;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 13px 10px;
            border-bottom: 1px solid #eee;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #f6f7f3;
        }

        .table-card {
            overflow-x: auto;
        }

        .code {
            font-weight: bold;
            color: #31563a;
        }

        .small {
            color: #777;
            font-size: 12px;
            margin-top: 4px;
        }

        .status-form {
            display: flex;
            gap: 7px;
        }

        .status-form select {
            min-width: 130px;
        }

        .reset {
            display: inline-block;
            margin-top: 12px;
            color: #31563a;
        }

        .pagination {
            margin-top: 20px;
        }

        @media (max-width: 800px) {
            .filters {
                grid-template-columns: 1fr;
            }
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
    </nav>

</header>

<main>

    <h1>Table Reservation Management</h1>

    <p>
        Kelola reservasi meja Cafe & Resto Gok Nauli.
    </p>

    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <div class="filter-card">

        <form
            method="GET"
            action="{{ route('admin.reservations.index', [], false) }}"
        >

            <div class="filters">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Kode, nama, WhatsApp..."
                >

                <input
                    type="date"
                    name="date"
                    value="{{ request('date') }}"
                >

                <select name="status">

                    <option value="">
                        Semua Status
                    </option>

                    @foreach ([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'seated' => 'Seated',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ] as $value => $label)

                        <option
                            value="{{ $value }}"
                            @selected(request('status') === $value)
                        >
                            {{ $label }}
                        </option>

                    @endforeach

                </select>

                <button type="submit">
                    Filter
                </button>

            </div>

        </form>

        <a
            class="reset"
            href="{{ route('admin.reservations.index', [], false) }}"
        >
            Reset Filter
        </a>

    </div>

    <div class="table-card">

        <table>

            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Tamu</th>
                    <th>Jadwal</th>
                    <th>Jumlah</th>
                    <th>Meja</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>

            @forelse ($reservations as $reservation)

                <tr>

                    <td>
                        <div class="code">
                            {{ $reservation->reservation_code }}
                        </div>

                        <div class="small">
                            {{ $reservation->created_at->format('d/m/Y H:i') }}
                        </div>
                    </td>

                    <td>
                        <strong>
                            {{ $reservation->guest_name }}
                        </strong>

                        <div class="small">
                            {{ $reservation->guest_phone }}
                        </div>

                        @if ($reservation->guest_email)
                            <div class="small">
                                {{ $reservation->guest_email }}
                            </div>
                        @endif
                    </td>

                    <td>
                        {{ $reservation->reservation_date->format('d/m/Y') }}

                        <div class="small">
                            {{ substr($reservation->reservation_time, 0, 5) }}
                        </div>
                    </td>

                    <td>
                        {{ $reservation->guests }} orang
                    </td>

                    <td>
                        {{ $reservation->restaurantTable?->table_number ?? '-' }}
                    </td>

                    <td>
                        {{ $reservation->restaurantTable?->location ?? '-' }}
                    </td>

                    <td>

                        <form
                            class="status-form"
                            method="POST"
                            action="{{ route(
                                'admin.reservations.status',
                                $reservation,
                                false
                            ) }}"
                        >
                            @csrf
                            @method('PATCH')

                            <select name="status">

                                @foreach ([
                                    'pending' => 'Pending',
                                    'confirmed' => 'Confirmed',
                                    'seated' => 'Seated',
                                    'completed' => 'Completed',
                                    'cancelled' => 'Cancelled',
                                ] as $value => $label)

                                    <option
                                        value="{{ $value }}"
                                        @selected(
                                            $reservation->status === $value
                                        )
                                    >
                                        {{ $label }}
                                    </option>

                                @endforeach

                            </select>

                            <button type="submit">
                                Save
                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="7">
                        Belum ada reservasi.
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

        <div class="pagination">
            {{ $reservations->links() }}
        </div>

    </div>

</main>

</body>
</html>
