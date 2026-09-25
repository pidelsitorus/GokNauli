<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <style>
        @page {
            margin: 35px 40px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #252525;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .header-table td {
            border: 0;
            vertical-align: top;
            padding: 0;
        }

        .business-name {
            font-size: 20px;
            font-weight: bold;
            color: #26372a;
            margin-bottom: 4px;
        }

        .business-type {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .business-info {
            color: #666;
            line-height: 1.5;
        }

        .statement-title {
            text-align: right;
            font-size: 19px;
            font-weight: bold;
            color: #31563a;
        }

        .statement-number {
            text-align: right;
            margin-top: 7px;
            color: #666;
        }

        .separator {
            border-top: 2px solid #31563a;
            margin: 15px 0 20px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        .info-table td {
            border: 0;
            padding: 3px 0;
        }

        .info-label {
            width: 110px;
            color: #666;
        }

        .transaction-table {
            width: 100%;
            border-collapse: collapse;
        }

        .transaction-table th,
        .transaction-table td {
            border: 1px solid #d9d9d9;
            padding: 7px 6px;
        }

        .transaction-table th {
            background: #eef2eb;
            color: #26372a;
            font-size: 9px;
        }

        .transaction-table td {
            font-size: 9px;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        .summary {
            width: 55%;
            margin-left: auto;
            margin-top: 18px;
            border-collapse: collapse;
        }

        .summary td {
            padding: 6px 8px;
            border-bottom: 1px solid #ddd;
        }

        .summary .total td {
            background: #26372a;
            color: white;
            font-size: 12px;
            font-weight: bold;
        }

        .authorization {
            width: 100%;
            margin-top: 45px;
            border-collapse: collapse;
        }

        .authorization td {
            border: 0;
            width: 50%;
            vertical-align: top;
        }

        .signature {
            text-align: center;
            width: 220px;
            margin-left: auto;
        }

        .signature-space {
            height: 55px;
        }

        .signature-line {
            border-top: 1px solid #444;
            padding-top: 5px;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            padding-top: 8px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #888;
            font-size: 8px;
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

    $statementNumber = sprintf(
        'GN-CAF-%04d%02d',
        $year,
        $month
    );
@endphp


<table class="header-table">

    <tr>

        <td>

            <div class="business-name">
                {{ config('goknauli.name') }}
            </div>

            <div class="business-type">
                Cafe & Resto
            </div>

            <div class="business-info">

                @if (config('goknauli.address'))
                    {{ config('goknauli.address') }}
                    <br>
                @endif

                @if (config('goknauli.whatsapp_number'))
                    WhatsApp:
                    {{ config('goknauli.whatsapp_number') }}
                @endif

            </div>

        </td>


        <td>

            <div class="statement-title">
                MONTHLY STATEMENT
            </div>

            <div class="statement-number">
                No. {{ $statementNumber }}
            </div>

        </td>

    </tr>

</table>


<div class="separator"></div>


<table class="info-table">

    <tr>
        <td class="info-label">
            Jenis Laporan
        </td>

        <td>
            : Pemasukan Cafe & Resto
        </td>
    </tr>

    <tr>
        <td class="info-label">
            Periode
        </td>

        <td>
            :
            {{ $months[(int) $month] }}
            {{ $year }}
        </td>
    </tr>

    <tr>
        <td class="info-label">
            Tanggal Cetak
        </td>

        <td>
            :
            {{ now()->format('d/m/Y H:i') }}
        </td>
    </tr>

</table>


<table class="transaction-table">

    <thead>

        <tr>
            <th>Tanggal Bayar</th>
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
                {{ $order->paid_at?->format(
                    'd/m/Y H:i'
                ) ?? '-' }}
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

            <td class="center">
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
                class="center"
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
            TOTAL PEMASUKAN
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


<table class="authorization">

    <tr>

        <td>
            <strong>Catatan</strong>

            <br><br>

            Statement ini hanya mencakup
            transaksi Cafe & Resto dengan
            status pembayaran Paid.
        </td>

        <td>

            <div class="signature">

                Mengetahui,
                <br>
                Management Gok Nauli

                <div class="signature-space"></div>

                <div class="signature-line">
                    Authorized Signature
                </div>

            </div>

        </td>

    </tr>

</table>


<div class="footer">
    Dokumen ini dihasilkan secara otomatis
    oleh Sistem Gok Nauli.
    Nomor Statement:
    {{ $statementNumber }}
</div>

</body>

</html>
