<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Laporan Operasional - Gok Nauli
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
            max-width: 1300px;
            margin: 35px auto;
        }

        .filter,
        .report-card {
            background: white;
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
        }

        .filter {
            margin: 25px 0;
        }

        .filter form {
            display: flex;
            align-items: end;
            gap: 12px;
            flex-wrap: wrap;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 6px;
        }

        select,
        input {
            padding: 10px;
            border: 1px solid #d5d9d3;
            border-radius: 8px;
        }

        .btn {
            display: inline-block;
            background: #31563a;
            color: white;
            padding: 11px 15px;
            border-radius: 8px;
            border: 0;
            text-decoration: none;
            cursor: pointer;
        }

        .reports {
            display: grid;
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .report-card h2 {
            margin-top: 0;
        }

        .stats {
            display: grid;
            grid-template-columns:
                repeat(2, minmax(0, 1fr));
            gap: 12px;
            margin: 20px 0;
        }

        .stat {
            padding: 15px;
            border-radius: 10px;
            background: #f6f8f4;
        }

        .stat span {
            display: block;
            color: #727970;
            font-size: 12px;
            margin-bottom: 6px;
        }

        .stat strong {
            color: #31563a;
            font-size: 19px;
        }

        .section-label {
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 8px;
        }

        @media (max-width: 800px) {
            .reports {
                grid-template-columns: 1fr;
            }

            .stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

@include('admin.partials.header')

<main>

    <h1>Laporan Operasional</h1>

    <p>
        Inventory dan Facilities Gok Nauli
        untuk periode {{ $periodLabel }}.
    </p>


    <div class="filter">

        <form
            method="GET"
            action="{{ route(
                'admin.operational-reports.index',
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


    <div class="reports">

        @foreach ([
            [
                'key' => 'homestay',
                'label' => 'Homestay',
                'data' => $homestay,
                'route' =>
                    'admin.operational-reports.homestay',
            ],
            [
                'key' => 'cafe',
                'label' => 'Cafe & Resto',
                'data' => $cafe,
                'route' =>
                    'admin.operational-reports.cafe',
            ],
        ] as $report)

            <section class="report-card">

                <h2>
                    {{ $report['label'] }}
                </h2>


                <div class="section-label">
                    Inventory
                </div>

                <div class="stats">

                    <div class="stat">
                        <span>
                            Transaksi Inventory
                        </span>

                        <strong>
                            {{ $report['data']
                                ['inventory']
                                ['transactions'] }}
                        </strong>
                    </div>


                    <div class="stat">
                        <span>
                            Biaya Pemakaian /
                            Kerusakan
                        </span>

                        <strong>
                            Rp {{ number_format(
                                $report['data']
                                    ['inventory']
                                    ['operational_out_cost'],
                                0,
                                ',',
                                '.'
                            ) }}
                        </strong>
                    </div>


                    <div class="stat">
                        <span>
                            Barang Masuk
                        </span>

                        <strong>
                            Rp {{ number_format(
                                $report['data']
                                    ['inventory']
                                    ['stock_in_cost'],
                                0,
                                ',',
                                '.'
                            ) }}
                        </strong>
                    </div>


                    <div class="stat">
                        <span>
                            Kerusakan + Hilang
                        </span>

                        <strong>
                            Rp {{ number_format(
                                $report['data']
                                    ['inventory']
                                    ['damaged_cost']
                                +
                                $report['data']
                                    ['inventory']
                                    ['lost_cost'],
                                0,
                                ',',
                                '.'
                            ) }}
                        </strong>
                    </div>

                </div>


                <div class="section-label">
                    Facilities
                </div>

                <div class="stats">

                    <div class="stat">
                        <span>
                            Aktivitas Fasilitas
                        </span>

                        <strong>
                            {{ $report['data']
                                ['facilities']
                                ['activities'] }}
                        </strong>
                    </div>


                    <div class="stat">
                        <span>
                            Aset Dilaporkan Rusak
                        </span>

                        <strong>
                            {{ $report['data']
                                ['facilities']
                                ['damaged'] }}
                        </strong>
                    </div>


                    <div class="stat">
                        <span>
                            Repair
                        </span>

                        <strong>
                            {{ $report['data']
                                ['facilities']
                                ['repairs'] }}
                        </strong>
                    </div>


                    <div class="stat">
                        <span>
                            Biaya Facilities
                        </span>

                        <strong>
                            Rp {{ number_format(
                                $report['data']
                                    ['facilities']
                                    ['total_cost'],
                                0,
                                ',',
                                '.'
                            ) }}
                        </strong>
                    </div>

                </div>


                <a
                    class="btn"
                    href="{{ route(
                        $report['route'],
                        [
                            'month' => $month,
                            'year' => $year,
                        ],
                        false
                    ) }}"
                >
                    Download PDF
                    {{ $report['label'] }}
                </a>

            </section>

        @endforeach

    </div>

</main>

</body>

</html>
