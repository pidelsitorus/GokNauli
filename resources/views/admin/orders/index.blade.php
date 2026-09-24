<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Order Management - Gok Nauli</title>

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
            width: 95%;
            max-width: 1500px;
            margin: 35px auto;
        }

        .filter-card,
        .order-card {
            background: white;
            border-radius: 14px;
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
        }

        .filter-card {
            padding: 20px;
            margin-bottom: 25px;
        }

        .filters {
            display: grid;
            grid-template-columns:
                2fr
                1fr
                1fr
                1fr
                auto;
            gap: 10px;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 7px;
        }

        button {
            border: 0;
            padding: 10px 14px;
            border-radius: 7px;
            background: #31563a;
            color: white;
            cursor: pointer;
        }

        .success {
            background: #e6f4e8;
            color: #246532;
            padding: 14px;
            border-radius: 9px;
            margin-bottom: 20px;
        }

        .order-card {
            margin-bottom: 22px;
            overflow: hidden;
        }

        .order-header {
            background: #f6f7f3;
            padding: 18px 22px;
            display: flex;
            justify-content: space-between;
            gap: 20px;
            align-items: center;
            flex-wrap: wrap;
        }

        .order-code {
            font-size: 18px;
            font-weight: bold;
            color: #31563a;
        }

        .small {
            font-size: 13px;
            color: #777;
            margin-top: 5px;
        }

        .order-body {
            padding: 22px;
        }

        .info-grid {
            display: grid;
            grid-template-columns:
                repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }

        .info-box {
            background: #fafafa;
            padding: 14px;
            border-radius: 9px;
        }

        .info-box span {
            display: block;
            font-size: 12px;
            color: #777;
            margin-bottom: 5px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .items-table th,
        .items-table td {
            padding: 11px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        .items-table th {
            background: #f7f7f7;
        }

        .management {
            display: grid;
            grid-template-columns:
                1fr
                1fr;
            gap: 20px;
            margin-top: 20px;
        }

        .management-box {
            border: 1px solid #eee;
            border-radius: 10px;
            padding: 15px;
        }

        .management-form {
            display: flex;
            gap: 8px;
            margin-top: 10px;
        }

        .management-form select {
            flex: 1;
        }

        .total {
            text-align: right;
            font-size: 20px;
            font-weight: bold;
            margin-top: 15px;
        }

        .reset {
            display: inline-block;
            margin-top: 12px;
            color: #31563a;
        }

        .notes {
            background: #fffbea;
            padding: 14px;
            border-radius: 9px;
            margin-top: 15px;
        }

        .pagination {
            margin-top: 25px;
        }

        @media (max-width: 900px) {

            .filters {
                grid-template-columns: 1fr;
            }

            .info-grid {
                grid-template-columns: 1fr 1fr;
            }

            .management {
                grid-template-columns: 1fr;
            }

        }

        @media (max-width: 550px) {

            .info-grid {
                grid-template-columns: 1fr;
            }

            .management-form {
                flex-direction: column;
            }

        }

    </style>

</head>

<body>

<header>

    <strong>
        Gok Nauli Admin
    </strong>

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

        <a href="{{ route('admin.orders.index', [], false) }}">
            Orders
        </a>

    </nav>

</header>

<main>

    <h1>
        Order Management
    </h1>

    <p>
        Kelola pesanan Cafe & Resto Gok Nauli.
    </p>

    @if (session('success'))

        <div class="success">
            {{ session('success') }}
        </div>

    @endif


    <div class="filter-card">

        <form
            method="GET"
            action="{{ route('admin.orders.index', [], false) }}"
        >

            <div class="filters">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Kode, nama, WhatsApp..."
                >

                <select name="order_type">

                    <option value="">
                        Semua Jenis
                    </option>

                    <option
                        value="dine_in"
                        @selected(request('order_type') === 'dine_in')
                    >
                        Dine In
                    </option>

                    <option
                        value="takeaway"
                        @selected(request('order_type') === 'takeaway')
                    >
                        Takeaway
                    </option>

                </select>


                <select name="status">

                    <option value="">
                        Semua Status
                    </option>

                    @foreach ([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'preparing' => 'Preparing',
                        'ready' => 'Ready',
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


                <select name="payment_status">

                    <option value="">
                        Semua Pembayaran
                    </option>

                    <option
                        value="unpaid"
                        @selected(
                            request('payment_status') === 'unpaid'
                        )
                    >
                        Unpaid
                    </option>

                    <option
                        value="paid"
                        @selected(
                            request('payment_status') === 'paid'
                        )
                    >
                        Paid
                    </option>

                    <option
                        value="refunded"
                        @selected(
                            request('payment_status') === 'refunded'
                        )
                    >
                        Refunded
                    </option>

                </select>


                <button type="submit">
                    Filter
                </button>

            </div>

        </form>


        <a
            class="reset"
            href="{{ route('admin.orders.index', [], false) }}"
        >
            Reset Filter
        </a>

    </div>


    @forelse ($orders as $order)

        <div class="order-card">

            <div class="order-header">

                <div>

                    <div class="order-code">
                        {{ $order->order_code }}
                    </div>

                    <div class="small">
                        {{ $order->created_at->format('d/m/Y H:i') }}
                    </div>

                </div>

                <strong>

                    Rp {{ number_format(
                        $order->subtotal,
                        0,
                        ',',
                        '.'
                    ) }}

                </strong>

            </div>


            <div class="order-body">

                <div class="info-grid">

                    <div class="info-box">

                        <span>
                            Customer
                        </span>

                        <strong>
                            {{ $order->customer_name }}
                        </strong>

                        <div class="small">
                            {{ $order->customer_phone }}
                        </div>

                    </div>


                    <div class="info-box">

                        <span>
                            Jenis Pesanan
                        </span>

                        <strong>

                            {{ $order->order_type === 'dine_in'
                                ? 'Dine In'
                                : 'Takeaway' }}

                        </strong>

                    </div>


                    <div class="info-box">

                        <span>
                            Meja
                        </span>

                        <strong>

                            @if ($order->order_type === 'dine_in')

                                {{ $order->restaurantTable?->table_number ?? '-' }}

                            @else

                                -

                            @endif

                        </strong>

                    </div>


                    <div class="info-box">

                        <span>
                            Jumlah Item
                        </span>

                        <strong>
                            {{ $order->items->sum('quantity') }}
                        </strong>

                    </div>

                </div>


                <h3>
                    Detail Pesanan
                </h3>


                <table class="items-table">

                    <thead>

                        <tr>
                            <th>Menu</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($order->items as $item)

                            <tr>

                                <td>
                                    {{ $item->menu_name }}
                                </td>

                                <td>

                                    Rp {{ number_format(
                                        $item->price,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </td>

                                <td>
                                    {{ $item->quantity }}
                                </td>

                                <td>

                                    Rp {{ number_format(
                                        $item->subtotal,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>


                <div class="total">

                    Total:
                    Rp {{ number_format(
                        $order->subtotal,
                        0,
                        ',',
                        '.'
                    ) }}

                </div>


                @if ($order->notes)

                    <div class="notes">

                        <strong>
                            Catatan:
                        </strong>

                        {{ $order->notes }}

                    </div>

                @endif


                <div class="management">

                    <div class="management-box">

                        <strong>
                            Status Pesanan
                        </strong>

                        <form
                            class="management-form"
                            method="POST"
                            action="{{ route(
                                'admin.orders.status',
                                $order,
                                false
                            ) }}"
                        >

                            @csrf
                            @method('PATCH')

                            <select name="status">

                                @foreach ([
                                    'pending' => 'Pending',
                                    'confirmed' => 'Confirmed',
                                    'preparing' => 'Preparing',
                                    'ready' => 'Ready',
                                    'completed' => 'Completed',
                                    'cancelled' => 'Cancelled',
                                ] as $value => $label)

                                    <option
                                        value="{{ $value }}"
                                        @selected(
                                            $order->status === $value
                                        )
                                    >
                                        {{ $label }}
                                    </option>

                                @endforeach

                            </select>

                            <button type="submit">
                                Update
                            </button>

                        </form>

                    </div>


                    <div class="management-box">

                        <strong>
                            Pembayaran
                        </strong>

                        <form
                            class="management-form"
                            method="POST"
                            action="{{ route(
                                'admin.orders.payment',
                                $order,
                                false
                            ) }}"
                        >

                            @csrf
                            @method('PATCH')

                            <select name="payment_status">

                                <option
                                    value="unpaid"
                                    @selected(
                                        $order->payment_status === 'unpaid'
                                    )
                                >
                                    Unpaid
                                </option>

                                <option
                                    value="paid"
                                    @selected(
                                        $order->payment_status === 'paid'
                                    )
                                >
                                    Paid
                                </option>

                                <option
                                    value="refunded"
                                    @selected(
                                        $order->payment_status === 'refunded'
                                    )
                                >
                                    Refunded
                                </option>

                            </select>

                            <button type="submit">
                                Update
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    @empty

        <div class="order-card">

            <div class="order-body">
                Belum ada order Cafe & Resto.
            </div>

        </div>

    @endforelse


    <div class="pagination">
        {{ $orders->links() }}
    </div>

</main>

</body>

</html>
