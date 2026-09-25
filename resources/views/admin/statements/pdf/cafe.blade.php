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
        Gok Nauli Cafe & Resto
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
            <th>Tanggal</th>
            <th>Kode Order</th>
            <th>Customer</th>
            <th>Jenis</th>
            <th>Jumlah Item</th>
            <th class="right">Total</th>
        </tr>

    </thead>

    <tbody>

    @forelse ($orders as $order)

        <tr>

            <td>
                {{ $order->created_at->format('d/m/Y') }}
            </td>

            <td>
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

            <td class="right">
                Rp {{ number_format(
                    $order->subtotal,
                    0,
                    ',',
                    '.'
                ) }}
            </td>

        </tr>

    @empty

        <tr>

            <td
                colspan="6"
                style="text-align:center;"
            >
                Tidak ada transaksi Cafe & Resto
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
            {{ $orders->count() }}
        </td>

    </tr>

    <tr class="total">

        <td>
            TOTAL PEMASUKAN CAFE & RESTO
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
