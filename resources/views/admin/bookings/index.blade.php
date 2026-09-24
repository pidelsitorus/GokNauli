<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Booking Management - Gok Nauli</title>

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

        header h2 {
            margin: 0;
        }

        nav {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        nav a {
            color: white;
            text-decoration: none;
        }

        .logout {
            border: 1px solid rgba(255,255,255,.5);
            background: transparent;
            color: white;
            padding: 8px 14px;
            border-radius: 7px;
            cursor: pointer;
        }

        main {
            width: 94%;
            max-width: 1450px;
            margin: 35px auto;
        }

        .heading {
            margin-bottom: 25px;
        }

        .filter-card {
            background: white;
            padding: 20px;
            border-radius: 14px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
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

        .filter-button {
            border: 0;
            background: #31563a;
            color: white;
            padding: 11px 20px;
            border-radius: 7px;
            cursor: pointer;
        }

        .reset {
            display: inline-block;
            margin-top: 12px;
            color: #31563a;
        }

        .success {
            background: #e6f4e8;
            color: #246532;
            padding: 14px;
            border-radius: 9px;
            margin-bottom: 20px;
        }

        .table-card {
            background: white;
            padding: 20px;
            border-radius: 14px;
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 1250px;
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

        .code {
            font-weight: bold;
            color: #31563a;
        }

        .small {
            font-size: 12px;
            color: #777;
            margin-top: 4px;
        }

        .status-form {
            display: flex;
            gap: 6px;
        }

        .status-form select {
            min-width: 125px;
        }

        .save {
            border: 0;
            padding: 8px 11px;
            border-radius: 6px;
            background: #31563a;
            color: white;
            cursor: pointer;
        }

        .badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 15px;
            background: #f2f1dc;
            font-size: 12px;
        }

        .pagination {
            margin-top: 25px;
        }

        @media (max-width: 800px) {
            header {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }

            .filters {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<header>

    <h2>Gok Nauli Admin</h2>

    <nav>

        <a href="{{ route('admin.dashboard', [], false) }}">
            Dashboard
        </a>

        <a href="{{ route('admin.bookings.index', [], false) }}">
            Booking
        </a>

        <form method="POST"
              action="{{ route('admin.logout', [], false) }}">
            @csrf

            <button class="logout" type="submit">
                Logout
            </button>
        </form>

    </nav>

</header>

<main>

    <div class="heading">
        <h1>Booking Management</h1>
        <p>Kelola booking homestay Gok Nauli.</p>
    </div>

    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <div class="filter-card">

        <form method="GET"
              action="{{ route('admin.bookings.index', [], false) }}">

            <div class="filters">

                <input
                    type="text"
                    name="search"
                    placeholder="Kode booking, nama, telepon..."
                    value="{{ request('search') }}"
                >

                <select name="status">
                    <option value="">Semua Status Booking</option>

                    <option value="pending"
                        @selected(request('status') === 'pending')>
                        Pending
                    </option>

                    <option value="confirmed"
                        @selected(request('status') === 'confirmed')>
                        Confirmed
                    </option>

                    <option value="checked_in"
                        @selected(request('status') === 'checked_in')>
                        Checked In
                    </option>

                    <option value="checked_out"
                        @selected(request('status') === 'checked_out')>
                        Checked Out
                    </option>

                    <option value="cancelled"
                        @selected(request('status') === 'cancelled')>
                        Cancelled
                    </option>
                </select>

                <select name="payment_status">
                    <option value="">Semua Pembayaran</option>

                    <option value="unpaid"
                        @selected(request('payment_status') === 'unpaid')>
                        Unpaid
                    </option>

                    <option value="partial"
                        @selected(request('payment_status') === 'partial')>
                        Partial
                    </option>

                    <option value="paid"
                        @selected(request('payment_status') === 'paid')>
                        Paid
                    </option>

                    <option value="refunded"
                        @selected(request('payment_status') === 'refunded')>
                        Refunded
                    </option>
                </select>

                <button class="filter-button" type="submit">
                    Filter
                </button>

            </div>

        </form>

        <a
            class="reset"
            href="{{ route('admin.bookings.index', [], false) }}"
        >
            Reset Filter
        </a>

    </div>

    <div class="table-card">

        <table>

            <thead>
                <tr>
                    <th>Booking</th>
                    <th>Tamu</th>
                    <th>Kamar</th>
                    <th>Menginap</th>
                    <th>Total</th>
                    <th>Status Booking</th>
                    <th>Pembayaran</th>
                </tr>
            </thead>

            <tbody>

            @forelse ($bookings as $booking)

                <tr>

                    <td>
                        <div class="code">
                            {{ $booking->booking_code }}
                        </div>

                        <div class="small">
                            {{ $booking->created_at->format('d/m/Y H:i') }}
                        </div>
                    </td>

                    <td>
                        <strong>
                            {{ $booking->guest_name }}
                        </strong>

                        <div class="small">
                            {{ $booking->guest_phone }}
                        </div>

                        @if ($booking->guest_email)
                            <div class="small">
                                {{ $booking->guest_email }}
                            </div>
                        @endif
                    </td>

                    <td>
                        <strong>
                            {{ $booking->room->name }}
                        </strong>

                        <div class="small">
                            {{ $booking->room->roomType->name }}
                        </div>
                    </td>

                    <td>
                        {{ $booking->check_in->format('d/m/Y') }}

                        <div class="small">
                            sampai
                            {{ $booking->check_out->format('d/m/Y') }}
                        </div>
                    </td>

                    <td>
                        <strong>
                            Rp {{ number_format(
                                $booking->total_price,
                                0,
                                ',',
                                '.'
                            ) }}
                        </strong>
                    </td>

                    <td>

                        <form
                            class="status-form"
                            method="POST"
                            action="{{ route(
                                'admin.bookings.status',
                                $booking,
                                false
                            ) }}"
                        >
                            @csrf
                            @method('PATCH')

                            <select name="status">

                                <option value="pending"
                                    @selected($booking->status === 'pending')>
                                    Pending
                                </option>

                                <option value="confirmed"
                                    @selected($booking->status === 'confirmed')>
                                    Confirmed
                                </option>

                                <option value="checked_in"
                                    @selected($booking->status === 'checked_in')>
                                    Checked In
                                </option>

                                <option value="checked_out"
                                    @selected($booking->status === 'checked_out')>
                                    Checked Out
                                </option>

                                <option value="cancelled"
                                    @selected($booking->status === 'cancelled')>
                                    Cancelled
                                </option>

                            </select>

                            <button class="save" type="submit">
                                Save
                            </button>

                        </form>

                    </td>

                    <td>

                        <form
                            class="status-form"
                            method="POST"
                            action="{{ route(
                                'admin.bookings.payment',
                                $booking,
                                false
                            ) }}"
                        >
                            @csrf
                            @method('PATCH')

                            <select name="payment_status">

                                <option value="unpaid"
                                    @selected($booking->payment_status === 'unpaid')>
                                    Unpaid
                                </option>

                                <option value="partial"
                                    @selected($booking->payment_status === 'partial')>
                                    Partial
                                </option>

                                <option value="paid"
                                    @selected($booking->payment_status === 'paid')>
                                    Paid
                                </option>

                                <option value="refunded"
                                    @selected($booking->payment_status === 'refunded')>
                                    Refunded
                                </option>

                            </select>

                            <button class="save" type="submit">
                                Save
                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="7">
                        Tidak ada booking ditemukan.
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

        <div class="pagination">
            {{ $bookings->links() }}
        </div>

    </div>

</main>

</body>
</html>
