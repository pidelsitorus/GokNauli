<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #222;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0 0 5px;
            font-size: 22px;
        }

        .header h2 {
            margin: 0;
            font-size: 15px;
            font-weight: normal;
        }

        .period {
            margin-top: 10px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 7px;
            text-align: left;
        }

        th {
            background: #eeeeee;
        }

        .right {
            text-align: right;
        }

        .summary {
            margin-top: 20px;
        }

        .summary td {
            border: none;
            padding: 5px 0;
        }

        .total {
            font-weight: bold;
            font-size: 14px;
        }
    </style>
</head>

<body>

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


<div class="header">

    <h1>
        Gok Nauli Homestay
    </h1>

    <h2>
        Statement Pemasukan Bulanan
    </h2>

    <div class="period">
        Periode:
        {{ $months[(int) $month] }}
        {{ $year }}
    </div>

</div>


<table>

    <thead>

        <tr>
            <th>Tanggal Bayar</th>
            <th>Kode Booking</th>
            <th>Tamu</th>
            <th>Kamar</th>
            <th>Check In</th>
            <th>Check Out</th>
            <th class="right">Total</th>
        </tr>

    </thead>

    <tbody>

    @forelse ($bookings as $booking)

        <tr>

            <td>
                {{ $booking->paid_at?->format('d/m/Y H:i') ?? '-' }}
            </td>

            <td>
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
                {{ $booking->check_out->format('d/m/Y') }}
            </td>

            <td class="right">
                Rp {{ number_format(
                    $booking->total_price,
                    0,
                    ',',
                    '.'
                ) }}
            </td>

        </tr>

    @empty

        <tr>

            <td
                colspan="7"
                style="text-align:center;"
            >
                Tidak ada transaksi Homestay
                pada periode ini.
            </td>

        </tr>

    @endforelse

    </tbody>

</table>


<table class="summary">

    <tr>

        <td>
            Jumlah Transaksi
        </td>

        <td class="right">
            {{ $bookings->count() }}
        </td>

    </tr>

    <tr class="total">

        <td>
            TOTAL PEMASUKAN HOMESTAY
        </td>

        <td class="right">
            Rp {{ number_format(
                $totalRevenue,
                0,
                ',',
                '.'
            ) }}
        </td>

    </tr>

</table>

</body>

</html>
