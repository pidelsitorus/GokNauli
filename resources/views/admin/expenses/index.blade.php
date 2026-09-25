<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Expenses - Gok Nauli</title>

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
            width: 96%;
            max-width: 1300px;
            margin: 35px auto;
        }

        .top-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin: 22px 0;
        }

        .card,
        .panel {
            background: white;
            border-radius: 14px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .05);
        }

        .card {
            padding: 20px;
        }

        .card span {
            display: block;
            color: #6d736d;
            font-size: 13px;
        }

        .card strong {
            display: block;
            margin-top: 8px;
            font-size: 21px;
        }

        .panel {
            padding: 20px;
            margin-top: 20px;
        }

        .filters {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: end;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input,
        select {
            padding: 9px;
            border: 1px solid #d5d9d3;
            border-radius: 8px;
        }

        .btn {
            display: inline-block;
            padding: 10px 14px;
            border: 0;
            border-radius: 8px;
            background: #31563a;
            color: white;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-small {
            padding: 7px 10px;
            font-size: 12px;
        }

        .danger {
            background: #a43c36;
        }

        .success {
            padding: 13px;
            margin: 18px 0;
            border-radius: 8px;
            background: #e7f4e5;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 11px;
            border-bottom: 1px solid #e7e9e5;
            text-align: left;
            vertical-align: top;
            white-space: nowrap;
        }

        th {
            background: #edf2e9;
        }

        td.description {
            white-space: normal;
            min-width: 220px;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #777;
        }

        .inline-form {
            display: inline-block;
        }

        @media (max-width: 850px) {
            .stats {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 500px) {
            .stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

@include('admin.partials.header')

<main>

    <div class="top-actions">

        <div>
            <h1>Expenses</h1>

            <p>
                Catatan pengeluaran umum
                Gok Nauli.
            </p>
        </div>

        <a
            class="btn"
            href="{{ route(
                'admin.expenses.create',
                [],
                false
            ) }}"
        >
            + Tambah Pengeluaran
        </a>

    </div>


    @if (session('success'))

        <div class="success">
            {{ session('success') }}
        </div>

    @endif


    <div class="stats">

        <div class="card">
            <span>Total Pengeluaran</span>

            <strong>
                Rp {{ number_format(
                    $stats['total'],
                    0,
                    ',',
                    '.'
                ) }}
            </strong>
        </div>


        <div class="card">
            <span>Umum / Gok Nauli</span>

            <strong>
                Rp {{ number_format(
                    $stats['general'],
                    0,
                    ',',
                    '.'
                ) }}
            </strong>
        </div>


        <div class="card">
            <span>Homestay</span>

            <strong>
                Rp {{ number_format(
                    $stats['homestay'],
                    0,
                    ',',
                    '.'
                ) }}
            </strong>
        </div>


        <div class="card">
            <span>Cafe & Resto</span>

            <strong>
                Rp {{ number_format(
                    $stats['cafe'],
                    0,
                    ',',
                    '.'
                ) }}
            </strong>
        </div>

    </div>


    <div class="panel">

        <form
            method="GET"
            action="{{ route(
                'admin.expenses.index',
                [],
                false
            ) }}"
            class="filters"
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


            <div>
                <label for="area">
                    Area
                </label>

                <select
                    id="area"
                    name="area"
                >
                    <option value="">
                        Semua
                    </option>

                    <option
                        value="general"
                        @selected(
                            request('area') === 'general'
                        )
                    >
                        Umum
                    </option>

                    <option
                        value="homestay"
                        @selected(
                            request('area') === 'homestay'
                        )
                    >
                        Homestay
                    </option>

                    <option
                        value="cafe"
                        @selected(
                            request('area') === 'cafe'
                        )
                    >
                        Cafe & Resto
                    </option>
                </select>
            </div>


            <div>
                <label for="category">
                    Kategori
                </label>

                <select
                    id="category"
                    name="category"
                >
                    <option value="">
                        Semua
                    </option>

                    @foreach ([
                        'electricity' => 'Listrik',
                        'water' => 'Air',
                        'internet' => 'Internet',
                        'salary' => 'Gaji',
                        'tax' => 'Pajak',
                        'transport' => 'Transportasi',
                        'office_supplies' => 'Perlengkapan Kantor',
                        'marketing' => 'Marketing',
                        'rent' => 'Sewa',
                        'bank_fee' => 'Biaya Bank',
                        'other' => 'Lainnya',
                    ] as $value => $label)

                        <option
                            value="{{ $value }}"
                            @selected(
                                request('category')
                                    === $value
                            )
                        >
                            {{ $label }}
                        </option>

                    @endforeach

                </select>
            </div>


            <button
                class="btn"
                type="submit"
            >
                Filter
            </button>

        </form>


        <div class="table-wrapper">

            <table>

                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Area</th>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th>Metode</th>
                        <th>Vendor</th>
                        <th>Nominal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($expenses as $expense)

                        <tr>

                            <td>
                                {{ $expense
                                    ->expense_date
                                    ->format('d/m/Y') }}
                            </td>


                            <td>
                                {{ $expense->area_label }}
                            </td>


                            <td>
                                {{ $expense->category_label }}
                            </td>


                            <td class="description">

                                <strong>
                                    {{ $expense->description }}
                                </strong>

                                @if ($expense->reference)

                                    <br>

                                    <small>
                                        Ref:
                                        {{ $expense->reference }}
                                    </small>

                                @endif

                                @if ($expense->notes)

                                    <br>

                                    <small>
                                        {{ $expense->notes }}
                                    </small>

                                @endif

                            </td>


                            <td>
                                {{ $expense->payment_method
                                    ?? '-' }}
                            </td>


                            <td>
                                {{ $expense->vendor
                                    ?? '-' }}
                            </td>


                            <td>
                                <strong>
                                    Rp {{ number_format(
                                        $expense->amount,
                                        0,
                                        ',',
                                        '.'
                                    ) }}
                                </strong>
                            </td>


                            <td>

                                <a
                                    class="btn btn-small"
                                    href="{{ route(
                                        'admin.expenses.edit',
                                        $expense,
                                        false
                                    ) }}"
                                >
                                    Edit
                                </a>


                                <form
                                    method="POST"
                                    action="{{ route(
                                        'admin.expenses.destroy',
                                        $expense,
                                        false
                                    ) }}"
                                    class="inline-form"
                                    onsubmit="
                                        return confirm(
                                            'Hapus pengeluaran ini?'
                                        );
                                    "
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="
                                            btn
                                            btn-small
                                            danger
                                        "
                                    >
                                        Hapus
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td
                                colspan="8"
                                class="empty"
                            >
                                Belum ada pengeluaran
                                pada periode ini.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        <div style="margin-top: 20px;">
            {{ $expenses->links() }}
        </div>

    </div>

</main>

</body>
</html>
