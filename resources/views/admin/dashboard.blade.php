<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Admin Dashboard - Gok Nauli</title>

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
            gap: 20px;
        }

        nav {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        nav a {
            color: white;
            text-decoration: none;
        }

        main {
            width: 94%;
            max-width: 1500px;
            margin: 35px auto;
        }

        h1 {
            margin-bottom: 5px;
        }

        .subtitle {
            color: #727970;
            margin-bottom: 30px;
        }

        .section-title {
            margin-top: 40px;
            margin-bottom: 18px;
        }

        .stats {
            display: grid;
            grid-template-columns:
                repeat(auto-fit, minmax(210px, 1fr));
            gap: 17px;
        }

        .stat-card {
            background: white;
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .05);
        }

        .stat-card span {
            display: block;
            color: #777;
            font-size: 13px;
            margin-bottom: 10px;
        }

        .stat-card strong {
            font-size: 27px;
            color: #31563a;
        }

        .tables-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 25px;
        }

        .panel {
            background: white;
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .05);
            overflow-x: auto;
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
            gap: 15px;
        }

        .panel-header h2 {
            margin: 0;
        }

        .panel-header a {
            color: #31563a;
            text-decoration: none;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 750px;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        th {
            background: #f7f8f5;
            font-size: 13px;
        }

        .status {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            background: #edf2e9;
            font-size: 12px;
        }

        .code {
            color: #31563a;
            font-weight: bold;
        }

        .empty {
            color: #777;
            padding: 15px 0;
        }

        .notification-panel {
            margin-top: 25px;
            background: white;
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .05);
        }

        .notification-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .notification-header h2 {
            margin: 0;
        }

        .notification-count {
            min-width: 28px;
            height: 28px;
            padding: 0 9px;
            border-radius: 20px;
            background: #c0392b;
            color: white;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            font-size: 13px;
            font-weight: bold;
        }

        .notification-list {
            display: grid;
            gap: 12px;
        }

        .checkout-alert {
            display: grid;
            grid-template-columns: auto 1fr auto;
            gap: 16px;
            align-items: center;
            padding: 18px;
            border-radius: 12px;
        }

        .checkout-alert.today {
            background: #fff7df;
            border-left: 5px solid #e0a800;
        }

        .checkout-alert.overdue {
            background: #fff0ee;
            border-left: 5px solid #c0392b;
        }

        .checkout-icon {
            font-size: 25px;
        }

        .checkout-info strong {
            display: block;
            margin-bottom: 5px;
        }

        .checkout-meta {
            color: #666;
            font-size: 13px;
            line-height: 1.6;
        }

        .checkout-action {
            color: #31563a;
            text-decoration: none;
            font-weight: bold;
            white-space: nowrap;
        }

        .checkout-action:hover {
            text-decoration: underline;
        }

        .notification-safe {
            background: #edf7ed;
            color: #31563a;
            border-radius: 12px;
            padding: 18px;
        }

        .stat-card.warning strong {
            color: #c78800;
        }

        .stat-card.danger strong {
            color: #c0392b;
        }

        .logout {
            background: none;
            border: 0;
            color: white;
            cursor: pointer;
            padding: 0;
            font-size: 14px;
        }

        @media (max-width: 800px) {
            header {
                .checkout-alert {
                    grid-template-columns: 1fr;
                }

                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>

@include('admin.partials.header')

<main>

        <h1>Dashboard</h1>

        <p class="subtitle">
            Ringkasan operasional Gok Nauli Homestay Cafe & Resto.
        </p>


        <h2 class="section-title">
            Homestay
        </h2>

        <div class="stats">

            <div class="stat-card">
                <span>Total Booking</span>
                <strong>
                    {{ $stats['bookings_total'] }}
                </strong>
            </div>

            <div class="stat-card">
                <span>Booking Pending</span>
                <strong>
                    {{ $stats['bookings_pending'] }}
                </strong>
            </div>

            <div class="stat-card">
                <span>Sedang Check In</span>
                <strong>
                    {{ $stats['bookings_checked_in'] }}
                </strong>
            </div>

            <div class="stat-card warning">

                <span>
                    Checkout Hari Ini
                </span>

                <strong>
                    {{ $stats['checkout_today'] }}
                </strong>

            </div>


            <div class="stat-card danger">

                <span>
                    Terlambat Checkout
                </span>

                <strong>
                    {{ $stats['checkout_overdue'] }}
                </strong>

            </div>

            <div class="stat-card">
                <span>Pendapatan Homestay</span>

                <strong>
                    Rp {{ number_format(
                    $stats['homestay_revenue'],
                    0,
                    ',',
                    '.'
                ) }}
                </strong>
            </div>

        </div>

        <div class="notification-panel">

            <div class="notification-header">

                <h2>
                    🔔 Notifikasi Checkout
                </h2>

                @if ($checkoutNotificationCount > 0)

                <span class="notification-count">
                    {{ $checkoutNotificationCount }}
                </span>

                @endif

            </div>


            @if (
            $overdueCheckouts->count()
            || $checkoutToday->count()
            )

            <div class="notification-list">


                {{-- Terlambat Checkout --}}

                @foreach ($overdueCheckouts as $booking)

                <div class="checkout-alert overdue">

                    <div class="checkout-icon">
                        🔴
                    </div>


                    <div class="checkout-info">

                        <strong>
                            Terlambat Checkout
                        </strong>

                        <div class="checkout-meta">

                            Booking:
                            <b>
                                {{ $booking->booking_code }}
                            </b>

                            <br>

                            Tamu:
                            {{ $booking->guest_name }}

                            <br>

                            Kamar:
                            {{ $booking->room?->room_number ?? '-' }}

                            @if ($booking->room?->name)
                            -
                            {{ $booking->room->name }}
                            @endif

                            <br>

                            Seharusnya checkout:
                            <b>
                                {{ $booking->check_out->format(
                                        'd/m/Y'
                                    ) }}
                            </b>

                        </div>

                    </div>


                    <a
                        class="checkout-action"
                        href="{{ route(
                                'admin.bookings.index',
                                [],
                                false
                            ) }}">
                        Lihat Booking →
                    </a>

                </div>

                @endforeach


                {{-- Checkout Hari Ini --}}

                @foreach ($checkoutToday as $booking)

                <div class="checkout-alert today">

                    <div class="checkout-icon">
                        🟠
                    </div>


                    <div class="checkout-info">

                        <strong>
                            Checkout Hari Ini
                        </strong>

                        <div class="checkout-meta">

                            Booking:
                            <b>
                                {{ $booking->booking_code }}
                            </b>

                            <br>

                            Tamu:
                            {{ $booking->guest_name }}

                            <br>

                            Kamar:
                            {{ $booking->room?->room_number ?? '-' }}

                            @if ($booking->room?->name)
                            -
                            {{ $booking->room->name }}
                            @endif

                            <br>

                            Tanggal checkout:
                            <b>
                                {{ $booking->check_out->format(
                                        'd/m/Y'
                                    ) }}
                            </b>

                        </div>

                    </div>


                    <a
                        class="checkout-action"
                        href="{{ route(
                                'admin.bookings.index',
                                [],
                                false
                            ) }}">
                        Lihat Booking →
                    </a>

                </div>

                @endforeach

            </div>

            @else

            <div class="notification-safe">

                ✓ Tidak ada tamu yang harus checkout hari ini
                atau terlambat checkout.

            </div>

            @endif

        </div>

        <h2 class="section-title">
            Tamu Sedang Menginap
        </h2>

        <div class="panel">

            <div class="panel-header">

                <h2>
                    Check In Aktif
                </h2>

                <a href="{{ route(
            'admin.bookings.index',
            [],
            false
        ) }}">
                    Lihat Semua Booking
                </a>

            </div>


            @if ($checkedInBookings->count())

            <table>

                <thead>

                    <tr>
                        <th>Kode Booking</th>
                        <th>Tamu</th>
                        <th>Kamar</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Status</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach ($checkedInBookings as $booking)

                    <tr>

                        <td class="code">
                            {{ $booking->booking_code }}
                        </td>

                        <td>
                            {{ $booking->guest_name }}
                        </td>

                        <td>
                            {{ $booking->room?->room_number ?? '-' }}

                            @if ($booking->room?->name)
                            -
                            {{ $booking->room->name }}
                            @endif
                        </td>

                        <td>
                            {{ $booking->check_in->format('d/m/Y') }}
                        </td>

                        <td>
                            {{ $booking->check_out->format('d/m/Y') }}
                        </td>

                        <td>
                            <span class="status">
                                Checked In
                            </span>
                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

            @else

            <div class="empty">
                Tidak ada tamu yang sedang menginap.
            </div>

            @endif

        </div>

        <h2 class="section-title">
            Cafe & Resto
        </h2>

        <div class="stats">

            <div class="stat-card">
                <span>Reservasi Hari Ini</span>

                <strong>
                    {{ $stats['reservations_today'] }}
                </strong>
            </div>

            <div class="stat-card">
                <span>Reservasi Pending</span>

                <strong>
                    {{ $stats['reservations_pending'] }}
                </strong>
            </div>

            <div class="stat-card">
                <span>Order Hari Ini</span>

                <strong>
                    {{ $stats['orders_today'] }}
                </strong>
            </div>

            <div class="stat-card">
                <span>Order Aktif</span>

                <strong>
                    {{ $stats['orders_active'] }}
                </strong>
            </div>

            <div class="stat-card">
                <span>Pendapatan Cafe</span>

                <strong>
                    Rp {{ number_format(
                    $stats['cafe_revenue'],
                    0,
                    ',',
                    '.'
                ) }}
                </strong>
            </div>

        </div>


        <h2 class="section-title">
            Aktivitas Terbaru
        </h2>

        <div class="tables-grid">


            <div class="panel">

                <div class="panel-header">

                    <h2>
                        Booking Homestay
                    </h2>

                    <a href="{{ route(
                    'admin.bookings.index',
                    [],
                    false
                ) }}">
                        Lihat Semua
                    </a>

                </div>

                @if ($latestBookings->count())

                <table>

                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Tamu</th>
                            <th>Kamar</th>
                            <th>Check In</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($latestBookings as $booking)

                        <tr>

                            <td class="code">
                                {{ $booking->booking_code }}
                            </td>

                            <td>
                                {{ $booking->guest_name }}
                            </td>

                            <td>
                                {{ $booking->room?->room_number ?? '-' }}
                            </td>

                            <td>
                                {{ $booking->check_in->format('d/m/Y') }}
                            </td>

                            <td>
                                Rp {{ number_format(
                                    $booking->total_price,
                                    0,
                                    ',',
                                    '.'
                                ) }}
                            </td>

                            <td>
                                <span class="status">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

                @else

                <div class="empty">
                    Belum ada booking.
                </div>

                @endif

            </div>


            <div class="panel">

                <div class="panel-header">

                    <h2>
                        Reservasi Meja Hari Ini
                    </h2>

                    <a href="{{ route(
                    'admin.reservations.index',
                    [],
                    false
                ) }}">
                        Lihat Semua
                    </a>

                </div>

                @if ($latestReservations->count())

                <table>

                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Tamu</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Meja</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($latestReservations as $reservation)

                        <tr>

                            <td class="code">
                                {{ $reservation->reservation_code }}
                            </td>

                            <td>
                                {{ $reservation->guest_name }}
                            </td>

                            <td>
                                {{ $reservation->reservation_date->format('d/m/Y') }}
                            </td>

                            <td>
                                {{ substr(
                                    $reservation->reservation_time,
                                    0,
                                    5
                                ) }}
                            </td>

                            <td>
                                {{ $reservation
                                    ->restaurantTable
                                    ?->table_number ?? '-' }}
                            </td>

                            <td>
                                <span class="status">
                                    {{ ucfirst($reservation->status) }}
                                </span>
                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

                @else

                <div class="empty">
                    Tidak ada reservasi meja untuk hari ini.
                </div>

                @endif

            </div>


            <div class="panel">

                <div class="panel-header">

                    <h2>
                        Order Cafe & Resto
                    </h2>

                    <a href="{{ route(
                    'admin.orders.index',
                    [],
                    false
                ) }}">
                        Lihat Semua
                    </a>

                </div>

                @if ($latestOrders->count())

                <table>

                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Customer</th>
                            <th>Jenis</th>
                            <th>Item</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Payment</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($latestOrders as $order)

                        <tr>

                            <td class="code">
                                {{ $order->order_code }}
                            </td>

                            <td>
                                {{ $order->customer_name }}
                            </td>

                            <td>
                                {{ $order->order_type === 'dine_in'
                                    ? 'Dine In'
                                    : 'Takeaway' }}
                            </td>

                            <td>
                                {{ $order->items->sum('quantity') }}
                            </td>

                            <td>
                                Rp {{ number_format(
                                    $order->subtotal,
                                    0,
                                    ',',
                                    '.'
                                ) }}
                            </td>

                            <td>
                                <span class="status">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>

                            <td>
                                <span class="status">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

                @else

                <div class="empty">
                    Belum ada order Cafe & Resto.
                </div>

                @endif

            </div>


        </div>

    </main>

</body>

</html>