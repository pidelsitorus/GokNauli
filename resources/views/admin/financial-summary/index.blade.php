<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Ringkasan Keuangan - Gok Nauli
    </title>

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

        main {
            width: 94%;
            max-width: 1250px;
            margin: 35px auto;
        }

        .filter,
        .card {
            background: white;
            border-radius: 14px;
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
        }

        .filter {
            padding: 20px;
            margin: 25px 0;
        }

        .filter form {
            display: flex;
            flex-wrap: wrap;
            align-items: end;
            gap: 12px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 6px;
        }

        input,
        select {
            padding: 10px;
            border: 1px solid #d5d9d3;
            border-radius: 8px;
        }

        .btn {
            display: inline-block;
            border: 0;
            border-radius: 8px;
            padding: 11px 15px;
            background: #31563a;
            color: white;
            text-decoration: none;
            cursor: pointer;
        }

        .business-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .card {
            padding: 24px;
        }

        .card h2 {
            margin-top: 0;
        }

        .finance-row {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }

        .finance-row:last-child {
            border-bottom: 0;
        }

        .finance-row span {
            color: #696f68;
        }

        .finance-row strong {
            text-align: right;
        }

        .surplus {
            margin-top: 15px;
            padding: 16px;
            border-radius: 10px;
            background: #edf5e9;
        }

        .surplus.negative {
            background: #fdebea;
        }

        .surplus strong {
            display: block;
            margin-top: 5px;
            font-size: 23px;
            color: #31563a;
        }

        .surplus.negative strong {
            color: #b3261e;
        }

        .total-card {
            margin-top: 22px;
            background: #26372a;
            color: white;
        }

        .total-card .finance-row {
            border-color: rgba(255,255,255,.12);
        }

        .total-card .finance-row span {
            color: #d8e0d5;
        }

        .total-card .surplus {
            background: rgba(255,255,255,.08);
        }

        .total-card .surplus strong {
            color: white;
        }

        .notice {
            margin-top: 20px;
            padding: 16px;
            background: #fff7df;
            border-radius: 10px;
            color: #695515;
            line-height: 1.6;
        }

        .actions {
            margin-top: 22px;
        }

        @media (max-width: 800px) {
            .business-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

@include('admin.partials.header')

<main>

    <h1>Ringkasan Keuangan Bulanan</h1>

    <p>
        Pendapatan dan biaya operasional
        Gok Nauli untuk {{ $periodLabel }}.
    </p>


    <div class="filter">

        <form
            method="GET"
            action="{{ route(
                'admin.financial-summary.index',
                [],
                false
            ) }}"
        >

            <div>
                <label for="month">
                    Bulan
                </label>

                <select
                    id="month"
                    name="month"
                >
                    @foreach ([
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
                    ] as $value => $label)

                        <option
                            value="{{ $value }}"
                            @selected(
                                $month === $value
                            )
                        >
                            {{ $label }}
                        </option>

                    @endforeach
                </select>
            </div>


            <div>
                <label for="year">
                    Tahun
                </label>

                <input
                    id="year"
                    type="number"
                    name="year"
                    min="2020"
                    max="2100"
                    value="{{ $year }}"
                >
            </div>


            <button
                class="btn"
                type="submit"
            >
                Tampilkan
            </button>

        </form>

    </div>


    <div class="business-grid">

        @foreach ([
            'homestay' => 'Homestay',
            'cafe' => 'Cafe & Resto',
        ] as $key => $label)

            @php
                $data = $summary[$key];

                $negative =
                    $data['surplus'] < 0;
            @endphp

            <section class="card">

                <h2>
                    {{ $label }}
                </h2>


                <div class="finance-row">
                    <span>Pendapatan</span>

                    <strong>
                        Rp {{ number_format(
                            $data['revenue'],
                            0,
                            ',',
                            '.'
                        ) }}
                    </strong>
                </div>


                <div class="finance-row">
                    <span>
                        Biaya Inventory
                    </span>

                    <strong>
                        Rp {{ number_format(
                            $data['inventory_cost'],
                            0,
                            ',',
                            '.'
                        ) }}
                    </strong>
                </div>


                <div class="finance-row">
                    <span>
                        Maintenance /
                        Facilities
                    </span>

                    <strong>
                        Rp {{ number_format(
                            $data['facility_cost'],
                            0,
                            ',',
                            '.'
                        ) }}
                    </strong>
                </div>


                <div class="finance-row">
                    <span>
                        Total Biaya Operasional
                    </span>

                    <strong>
                        Rp {{ number_format(
                            $data['operational_cost'],
                            0,
                            ',',
                            '.'
                        ) }}
                    </strong>
                </div>


                <div
                    class="
                        surplus
                        {{ $negative
                            ? 'negative'
                            : '' }}
                    "
                >
                    Surplus Operasional

                    <strong>
                        Rp {{ number_format(
                            $data['surplus'],
                            0,
                            ',',
                            '.'
                        ) }}
                    </strong>
                </div>

            </section>

        @endforeach

    </div>


    @php
        $totalNegative =
            $summary['total']['surplus'] < 0;
    @endphp


    <section class="card total-card">

        <h2>
            Total Gok Nauli
        </h2>


        <div class="finance-row">
            <span>Total Pendapatan</span>

            <strong>
                Rp {{ number_format(
                    $summary['total']['revenue'],
                    0,
                    ',',
                    '.'
                ) }}
            </strong>
        </div>


        <div class="finance-row">
            <span>
                Total Biaya Operasional
            </span>

            <strong>
                Rp {{ number_format(
                    $summary['total']
                        ['operational_cost'],
                    0,
                    ',',
                    '.'
                ) }}
            </strong>
        </div>


        <div
            class="
                surplus
                {{ $totalNegative
                    ? 'negative'
                    : '' }}
            "
        >
            Total Surplus Operasional

            <strong>
                Rp {{ number_format(
                    $summary['total']['surplus'],
                    0,
                    ',',
                    '.'
                ) }}
            </strong>
        </div>

    </section>


    <div class="notice">
        <strong>Catatan:</strong>

        Ringkasan ini bukan laporan laba-rugi
        lengkap. Perhitungan saat ini hanya
        mengurangi pendapatan dengan biaya
        inventory yang digunakan/rusak/hilang
        serta biaya fasilitas dan maintenance
        yang sudah tercatat di sistem.
    </div>


    <div class="actions">

        <a
            class="btn"
            href="{{ route(
                'admin.financial-summary.download',
                [
                    'month' => $month,
                    'year' => $year,
                ],
                false
            ) }}"
        >
            Download PDF Financial Summary
        </a>

    </div>

</main>

</body>

</html>
