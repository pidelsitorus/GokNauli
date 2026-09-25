<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>
    Laporan Operasional {{ $areaLabel }}
</title>

<style>
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 10px;
        color: #262626;
    }

    h1,
    h2,
    h3,
    p {
        margin-top: 0;
    }

    .header {
        border-bottom: 2px solid #31563a;
        padding-bottom: 12px;
        margin-bottom: 18px;
    }

    .business {
        font-size: 18px;
        font-weight: bold;
        color: #31563a;
    }

    .muted {
        color: #666;
    }

    .report-title {
        margin-top: 16px;
        font-size: 16px;
    }

    .summary {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 18px;
    }

    .summary td {
        width: 25%;
        padding: 9px;
        border: 1px solid #ddd;
        vertical-align: top;
    }

    .summary span {
        display: block;
        color: #666;
        font-size: 8px;
        margin-bottom: 5px;
    }

    .summary strong {
        font-size: 11px;
    }

    table.data {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    table.data th,
    table.data td {
        border: 1px solid #ddd;
        padding: 6px;
        vertical-align: top;
    }

    table.data th {
        background: #edf2e9;
        text-align: left;
        font-size: 8px;
    }

    .right {
        text-align: right;
    }

    .section-title {
        color: #31563a;
        font-size: 13px;
        border-bottom: 1px solid #d6ddd3;
        padding-bottom: 5px;
        margin-top: 18px;
    }

    .footer {
        margin-top: 30px;
        border-top: 1px solid #ddd;
        padding-top: 10px;
        font-size: 8px;
        color: #666;
    }

    .signature {
        margin-top: 35px;
        width: 100%;
    }

    .signature td {
        width: 50%;
        text-align: center;
        padding-top: 10px;
    }

    .signature-space {
        height: 55px;
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


    <div class="report-title">
        LAPORAN OPERASIONAL BULANAN
    </div>

    <strong>
        {{ $areaLabel }}
    </strong>

    <p>
        Periode:
        <strong>{{ $periodLabel }}</strong>
        <br>

        No. Laporan:
        <strong>{{ $reportCode }}</strong>
        <br>

        Dicetak:
        {{ now()->format('d/m/Y H:i') }} WIB
    </p>

</div>


<h2 class="section-title">
    Ringkasan Inventory
</h2>

<table class="summary">

    <tr>

        <td>
            <span>Transaksi</span>
            <strong>
                {{ $data['inventory']
                    ['transactions'] }}
            </strong>
        </td>

        <td>
            <span>Barang Masuk</span>
            <strong>
                Rp {{ number_format(
                    $data['inventory']
                        ['stock_in_cost'],
                    0,
                    ',',
                    '.'
                ) }}
            </strong>
        </td>

        <td>
            <span>
                Pemakaian / Kerusakan
            </span>

            <strong>
                Rp {{ number_format(
                    $data['inventory']
                        ['operational_out_cost'],
                    0,
                    ',',
                    '.'
                ) }}
            </strong>
        </td>

        <td>
            <span>Rusak + Hilang</span>

            <strong>
                Rp {{ number_format(
                    $data['inventory']
                        ['damaged_cost']
                    +
                    $data['inventory']
                        ['lost_cost'],
                    0,
                    ',',
                    '.'
                ) }}
            </strong>
        </td>

    </tr>

</table>


<h3 class="section-title">
    Pemakaian Inventory per Barang
</h3>

<table class="data">

    <thead>

        <tr>
            <th>Barang</th>
            <th>Satuan</th>
            <th>Masuk</th>
            <th>Dipakai</th>
            <th>Rusak</th>
            <th>Hilang</th>
            <th>Return</th>
            <th>Adj. -</th>
            <th>Biaya Keluar</th>
        </tr>

    </thead>

    <tbody>

    @forelse (
        $data['inventory_by_item']
        as $row
    )

        <tr>

            <td>
                {{ $row['item']->name }}

                <br>

                <small>
                    {{ $row['item']->item_code }}
                </small>
            </td>

            <td>
                {{ $row['item']->unit }}
            </td>

            <td class="right">
                {{ number_format(
                    $row['stock_in'],
                    3,
                    ',',
                    '.'
                ) }}
            </td>

            <td class="right">
                {{ number_format(
                    $row['used'],
                    3,
                    ',',
                    '.'
                ) }}
            </td>

            <td class="right">
                {{ number_format(
                    $row['damaged'],
                    3,
                    ',',
                    '.'
                ) }}
            </td>

            <td class="right">
                {{ number_format(
                    $row['lost'],
                    3,
                    ',',
                    '.'
                ) }}
            </td>

            <td class="right">
                {{ number_format(
                    $row['returned'],
                    3,
                    ',',
                    '.'
                ) }}
            </td>

            <td class="right">
                {{ number_format(
                    $row['adjustment_out'],
                    3,
                    ',',
                    '.'
                ) }}
            </td>

            <td class="right">
                Rp {{ number_format(
                    $row['cost'],
                    0,
                    ',',
                    '.'
                ) }}
            </td>

        </tr>

    @empty

        <tr>
            <td colspan="9">
                Tidak ada aktivitas inventory
                pada periode ini.
            </td>
        </tr>

    @endforelse

    </tbody>

</table>


<h2 class="section-title">
    Ringkasan Facilities
</h2>

<table class="summary">

    <tr>

        <td>
            <span>Total Aktivitas</span>

            <strong>
                {{ $data['facilities']
                    ['activities'] }}
            </strong>
        </td>

        <td>
            <span>Kerusakan</span>

            <strong>
                {{ $data['facilities']
                    ['damaged'] }}
            </strong>
        </td>

        <td>
            <span>
                Repair / Replacement
            </span>

            <strong>
                {{ $data['facilities']
                    ['repairs']
                +
                $data['facilities']
                    ['replacements'] }}
            </strong>
        </td>

        <td>
            <span>Total Biaya</span>

            <strong>
                Rp {{ number_format(
                    $data['facilities']
                        ['total_cost'],
                    0,
                    ',',
                    '.'
                ) }}
            </strong>
        </td>

    </tr>

</table>


<h3 class="section-title">
    Riwayat Facilities
</h3>

<table class="data">

    <thead>

        <tr>
            <th>Tanggal</th>
            <th>Aset</th>
            <th>Aktivitas</th>
            <th>Kondisi</th>
            <th>Vendor</th>
            <th>Biaya</th>
            <th>Catatan</th>
        </tr>

    </thead>

    <tbody>

    @forelse (
        $data['facility_histories']
        as $history
    )

        <tr>

            <td>
                {{ $history
                    ->occurred_at
                    ->format('d/m/Y H:i') }}
            </td>

            <td>
                {{ $history
                    ->facilityAsset
                    ?->name ?? '-' }}

                <br>

                <small>
                    {{ $history
                        ->facilityAsset
                        ?->asset_code ?? '-' }}
                </small>
            </td>

            <td>
                {{ $history->activity_type }}
            </td>

            <td>
                {{ $history->condition_before
                    ?? '-' }}
                →
                {{ $history->condition_after
                    ?? '-' }}
            </td>

            <td>
                {{ $history->vendor ?? '-' }}
            </td>

            <td class="right">
                @if ($history->cost !== null)

                    Rp {{ number_format(
                        $history->cost,
                        0,
                        ',',
                        '.'
                    ) }}

                @else
                    -
                @endif
            </td>

            <td>
                {{ $history->notes ?? '-' }}
            </td>

        </tr>

    @empty

        <tr>
            <td colspan="7">
                Tidak ada aktivitas fasilitas
                pada periode ini.
            </td>
        </tr>

    @endforelse

    </tbody>

</table>


<table class="signature">

    <tr>

        <td>
            Dibuat oleh,
            <div class="signature-space"></div>
            ______________________
            <br>
            Admin Gok Nauli
        </td>

        <td>
            Mengetahui,
            <div class="signature-space"></div>
            ______________________
            <br>
            Management
        </td>

    </tr>

</table>


<div class="footer">

    Laporan ini dibuat otomatis oleh sistem
    Gok Nauli.

    <br>

    Nilai inventory dihitung berdasarkan
    biaya yang tercatat pada transaksi stok.
    Kuantitas ditampilkan per barang karena
    satuan inventory dapat berbeda-beda.

</div>

</body>

</html>
