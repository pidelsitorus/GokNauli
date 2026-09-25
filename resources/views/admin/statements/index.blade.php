<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Statement Bulanan - Gok Nauli</title>

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
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        nav a {
            color: white;
            text-decoration: none;
        }

        .logout {
            background: none;
            border: 0;
            color: white;
            cursor: pointer;
            padding: 0;
            font-size: 14px;
        }

        main {
            width: 94%;
            max-width: 1200px;
            margin: 35px auto;
        }

        h1 {
            margin-bottom: 5px;
        }

        .subtitle {
            color: #727970;
            margin-bottom: 30px;
        }

        .filter {
            background: white;
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
            margin-bottom: 25px;
        }

        .filter form {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            align-items: end;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        label {
            font-size: 13px;
            font-weight: bold;
        }

        select,
        input {
            padding: 10px 12px;
            border: 1px solid #d7dbd5;
            border-radius: 8px;
            background: white;
        }

        button,
        .btn {
            border: 0;
            background: #31563a;
            color: white;
            padding: 11px 16px;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .cards {
            display: grid;
            grid-template-columns:
                repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .card {
            background: white;
            border-radius: 14px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
        }

        .card h2 {
            margin-top: 0;
            margin-bottom: 8px;
        }

        .card-description {
            color: #777;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .stat-label {
            color: #777;
            font-size: 13px;
            margin-bottom: 5px;
        }

        .transactions {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .revenue {
            font-size: 28px;
            font-weight: bold;
            color: #31563a;
        }

        .actions {
            margin-top: 25px;
        }

        @media (max-width: 800px) {
            header {
                flex-direction: column;
                align-items: flex-start;
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

        <a href="{{ route('admin.statements.index', [], false) }}">
            Statement
        </a>

        <form
            method="POST"
            action="{{ route('admin.logout', [], false) }}"
        >
            @csrf

            <button
                type="submit"
                class="logout"
            >
                Logout
            </button>

        </form>

    </nav>

</header>


<main>

    <h1>
        Statement Bulanan
    </h1>

    <p class="subtitle">
        Laporan pemasukan Homestay dan Cafe & Resto
        dipisahkan berdasarkan periode bulan.
    </p>


    @php
        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];
    @endphp


    <div class="filter">

        <form
            method="GET"
            action="{{ route(
                'admin.statements.index',
                [],
                false
            ) }}"
        >

            <div class="field">

                <label for="month">
                    Bulan
                </label>

                <select
                    name="month"
                    id="month"
                >

                    @foreach ($months as $number => $name)

                        <option
                            value="{{ $number }}"
                            @selected(
                                (int) $month === $number
                            )
                        >
                            {{ $name }}
                        </option>

                    @endforeach

                </select>

            </div>


            <div class="field">

                <label for="year">
                    Tahun
                </label>

                <input
                    type="number"
                    name="year"
                    id="year"
                    value="{{ $year }}"
                    min="2020"
                    max="2100"
                    required
                >

            </div>


            <button type="submit">
                Tampilkan
            </button>

        </form>

    </div>


    <div class="cards">

        <div class="card">

            <h2>
                Homestay
            </h2>

            <div class="card-description">
                Laporan pemasukan booking kamar.
            </div>

            <div class="stat-label">
                Jumlah Transaksi
            </div>

            <div class="transactions">
                {{ $homestayTransactions }}
            </div>

            <div class="stat-label">
                Total Pemasukan
            </div>

            <div class="revenue">
                Rp {{ number_format(
                    $homestayRevenue,
                    0,
                    ',',
                    '.'
                ) }}
            </div>

            <div class="actions">

                <a
                    class="btn"
                    href="{{ route(
                        'admin.statements.homestay',
                        [
                            'month' => $month,
                            'year' => $year,
                        ],
                        false
                    ) }}"
                >
                    Download PDF Homestay
                </a>

            </div>

        </div>


        <div class="card">

            <h2>
                Cafe & Resto
            </h2>

            <div class="card-description">
                Laporan pemasukan order Cafe & Resto.
            </div>

            <div class="stat-label">
                Jumlah Transaksi
            </div>

            <div class="transactions">
                {{ $cafeTransactions }}
            </div>

            <div class="stat-label">
                Total Pemasukan
            </div>

            <div class="revenue">
                Rp {{ number_format(
                    $cafeRevenue,
                    0,
                    ',',
                    '.'
                ) }}
            </div>

            <div class="actions">

                <a
                    class="btn"
                    href="{{ route(
                        'admin.statements.cafe',
                        [
                            'month' => $month,
                            'year' => $year,
                        ],
                        false
                    ) }}"
                >
                    Download PDF Cafe & Resto
                </a>

            </div>

        </div>

    </div>

</main>

</body>

</html>
