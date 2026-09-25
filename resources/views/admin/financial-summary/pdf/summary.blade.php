<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<style>
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 11px;
        color: #292929;
    }

    .header {
        border-bottom: 2px solid #31563a;
        padding-bottom: 12px;
        margin-bottom: 20px;
    }

    .business {
        color: #31563a;
        font-size: 18px;
        font-weight: bold;
    }

    .muted {
        color: #666;
        font-size: 9px;
    }

    h1 {
        font-size: 16px;
        margin: 18px 0 6px;
    }

    h2 {
        color: #31563a;
        margin-top: 22px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th,
    td {
        padding: 8px;
        border: 1px solid #ddd;
    }

    th {
        background: #edf2e9;
        text-align: left;
    }

    .right {
        text-align: right;
    }

    .total {
        font-weight: bold;
        background: #f3f6f1;
    }

    .grand {
        background: #26372a;
        color: white;
        font-weight: bold;
    }

    .note {
        margin-top: 25px;
        padding: 12px;
        background: #fff8e5;
        font-size: 9px;
        line-height: 1.6;
    }

    .signature {
        margin-top: 35px;
        border: 0;
    }

    .signature td {
        border: 0;
        width: 50%;
        text-align: center;
    }

    .space {
        height: 55px;
    }

    .footer {
        margin-top: 25px;
        border-top: 1px solid #ddd;
        padding-top: 8px;
        color: #666;
        font-size: 8px;
    }
</style>

</head>

<body>


<div class="header">

    <div class="business">
        {{ config(
            'goknauli.name',
            'Gok Nauli Homestay Cafe & Resto'
        ) }}
    </div>

    <div class="muted">
        {{ config('goknauli.address') }}
    </div>

    <div class="muted">
        WhatsApp:
        {{ config('goknauli.whatsapp') }}
    </div>


    <h1>
        RINGKASAN KEUANGAN BULANAN
    </h1>

    Periode:
    <strong>
        {{ $periodLabel }}
    </strong>

    <br>

    No. Laporan:
    <strong>
        {{ $reportCode }}
    </strong>

    <br>

    Dicetak:
    {{ now()->format('d/m/Y H:i') }} WIB

</div>


<table>

    <thead>
        <tr>
            <th>Keterangan</th>
            <th class="right">
                Homestay
            </th>
            <th class="right">
                Cafe & Resto
            </th>
            <th class="right">
                Total
            </th>
        </tr>
    </thead>

    <tbody>

        <tr>
            <td>Pendapatan</td>

            <td class="right">
                Rp {{ number_format(
                    $summary['homestay']
                        ['revenue'],
                    0,
                    ',',
                    '.'
                ) }}
            </td>

            <td class="right">
                Rp {{ number_format(
                    $summary['cafe']
                        ['revenue'],
                    0,
                    ',',
                    '.'
                ) }}
            </td>

            <td class="right">
                Rp {{ number_format(
                    $summary['total']
                        ['revenue'],
                    0,
                    ',',
                    '.'
                ) }}
            </td>
        </tr>


        <tr>
            <td>Biaya Inventory</td>

            <td class="right">
                Rp {{ number_format(
                    $summary['homestay']
                        ['inventory_cost'],
                    0,
                    ',',
                    '.'
                ) }}
            </td>

            <td class="right">
                Rp {{ number_format(
                    $summary['cafe']
                        ['inventory_cost'],
                    0,
                    ',',
                    '.'
                ) }}
            </td>

            <td class="right">
                Rp {{ number_format(
                    $summary['homestay']
                        ['inventory_cost']
                    +
                    $summary['cafe']
                        ['inventory_cost'],
                    0,
                    ',',
                    '.'
                ) }}
            </td>
        </tr>


        <tr>
            <td>
                Maintenance / Facilities
            </td>

            <td class="right">
                Rp {{ number_format(
                    $summary['homestay']
                        ['facility_cost'],
                    0,
                    ',',
                    '.'
                ) }}
            </td>

            <td class="right">
                Rp {{ number_format(
                    $summary['cafe']
                        ['facility_cost'],
                    0,
                    ',',
                    '.'
                ) }}
            </td>

            <td class="right">
                Rp {{ number_format(
                    $summary['homestay']
                        ['facility_cost']
                    +
                    $summary['cafe']
                        ['facility_cost'],
                    0,
                    ',',
                    '.'
                ) }}
            </td>
        </tr>


        <tr>
            <td>Expenses</td>

            <td class="right">
                Rp {{ number_format(
                    $summary['homestay']
                        ['expense_cost'],
                    0,
                    ',',
                    '.'
                ) }}
            </td>

            <td class="right">
                Rp {{ number_format(
                    $summary['cafe']
                        ['expense_cost'],
                    0,
                    ',',
                    '.'
                ) }}
            </td>

            <td class="right">
                Rp {{ number_format(
                    $summary['homestay']
                        ['expense_cost']
                    +
                    $summary['cafe']
                        ['expense_cost'],
                    0,
                    ',',
                    '.'
                ) }}
            </td>
        </tr>


        <tr>
            <td>
                Pengeluaran Umum / Gok Nauli
            </td>

            <td class="right">
                -
            </td>

            <td class="right">
                -
            </td>

            <td class="right">
                Rp {{ number_format(
                    $summary['total']
                        ['general_expenses'],
                    0,
                    ',',
                    '.'
                ) }}
            </td>
        </tr>


        <tr class="total">
            <td>
                Total Biaya Operasional
            </td>

            <td class="right">
                Rp {{ number_format(
                    $summary['homestay']
                        ['operational_cost'],
                    0,
                    ',',
                    '.'
                ) }}
            </td>

            <td class="right">
                Rp {{ number_format(
                    $summary['cafe']
                        ['operational_cost'],
                    0,
                    ',',
                    '.'
                ) }}
            </td>

            <td class="right">
                Rp {{ number_format(
                    $summary['total']
                        ['operational_cost'],
                    0,
                    ',',
                    '.'
                ) }}
            </td>
        </tr>


        <tr class="grand">
            <td>
                Surplus Operasional
            </td>

            <td class="right">
                Rp {{ number_format(
                    $summary['homestay']
                        ['surplus'],
                    0,
                    ',',
                    '.'
                ) }}
            </td>

            <td class="right">
                Rp {{ number_format(
                    $summary['cafe']
                        ['surplus'],
                    0,
                    ',',
                    '.'
                ) }}
            </td>

            <td class="right">
                Rp {{ number_format(
                    $summary['total']
                        ['surplus'],
                    0,
                    ',',
                    '.'
                ) }}
            </td>
        </tr>

    </tbody>

</table>


<div class="note">

    <strong>Catatan:</strong>

    Dokumen ini merupakan ringkasan operasional,
    bukan laporan laba-rugi lengkap.

    Pendapatan dihitung dari transaksi berstatus
    paid pada periode pembayaran.

    Biaya operasional yang dihitung saat ini
    meliputi pemakaian/kerusakan/kehilangan
    inventory, biaya aktivitas facilities,
    serta Expenses yang tercatat pada periode
    laporan.

</div>


<table class="signature">

    <tr>

        <td>
            Dibuat oleh,
            <div class="space"></div>
            ______________________
            <br>
            Admin Gok Nauli
        </td>

        <td>
            Mengetahui,
            <div class="space"></div>
            ______________________
            <br>
            Management
        </td>

    </tr>

</table>


<div class="footer">
    Dokumen dibuat otomatis oleh sistem
    Gok Nauli.
</div>

</body>

</html>
