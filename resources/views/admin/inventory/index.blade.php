<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Inventory - Gok Nauli</title>

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
            max-width: 1500px;
            margin: 35px auto;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn {
            background: #31563a;
            color: white;
            text-decoration: none;
            padding: 11px 15px;
            border-radius: 8px;
            border: 0;
            cursor: pointer;
        }

        .stats {
            display: grid;
            grid-template-columns:
                repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
            margin: 25px 0;
        }

        .stat {
            background: white;
            padding: 20px;
            border-radius: 13px;
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
        }

        .stat span {
            display: block;
            color: #777;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .stat strong {
            font-size: 26px;
            color: #31563a;
        }

        .stat.warning strong {
            color: #c47c00;
        }

        .filters {
            background: white;
            padding: 18px;
            border-radius: 13px;
            margin-bottom: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,.04);
        }

        .filters form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filters input,
        .filters select {
            padding: 10px;
            border: 1px solid #d5d9d3;
            border-radius: 7px;
        }

        .table-card {
            background: white;
            border-radius: 13px;
            overflow-x: auto;
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1050px;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        th {
            background: #f7f8f5;
            font-size: 12px;
        }

        .code {
            font-weight: bold;
            color: #31563a;
        }

        .stock {
            font-weight: bold;
        }

        .low {
            color: #c0392b;
        }

        .badge {
            display: inline-block;
            padding: 5px 8px;
            border-radius: 20px;
            font-size: 11px;
            background: #edf2e9;
        }

        .badge.low {
            background: #fde9e7;
        }

        .actions {
            display: flex;
            gap: 7px;
        }

        .actions a {
            color: #31563a;
            font-weight: bold;
            text-decoration: none;
        }

        .success {
            background: #e8f5e9;
            color: #31563a;
            padding: 14px;
            border-radius: 9px;
            margin-bottom: 18px;
        }

        .pagination {
            padding: 18px;
        }
    </style>
</head>

<body>

@include('admin.partials.header')

<main>

    <div class="page-header">

        <div>
            <h1>Inventory</h1>

            <p>
                Kelola stok barang dan bahan
                Homestay serta Cafe & Resto.
            </p>
        </div>

        <a
            class="btn"
            href="{{ route(
                'admin.inventory.create',
                [],
                false
            ) }}"
        >
            + Tambah Barang
        </a>

    </div>


    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif


    <div class="stats">

        <div class="stat">
            <span>Total Barang Aktif</span>
            <strong>{{ $stats['total'] }}</strong>
        </div>

        <div class="stat">
            <span>Homestay</span>
            <strong>{{ $stats['homestay'] }}</strong>
        </div>

        <div class="stat">
            <span>Cafe & Resto</span>
            <strong>{{ $stats['cafe'] }}</strong>
        </div>

        <div class="stat warning">
            <span>Stok Rendah</span>
            <strong>{{ $stats['low_stock'] }}</strong>
        </div>

    </div>


    <div class="filters">

        <form
            method="GET"
            action="{{ route(
                'admin.inventory.index',
                [],
                false
            ) }}"
        >

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Kode atau nama barang"
            >

            <select name="area">
                <option value="">
                    Semua Area
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


            <select name="item_type">
                <option value="">
                    Semua Jenis
                </option>

                @foreach ([
                    'consumable' => 'Consumable',
                    'ingredient' => 'Bahan',
                    'equipment' => 'Equipment',
                    'cleaning' => 'Cleaning',
                    'other' => 'Lainnya',
                ] as $value => $label)

                    <option
                        value="{{ $value }}"
                        @selected(
                            request('item_type') === $value
                        )
                    >
                        {{ $label }}
                    </option>

                @endforeach
            </select>


            <label>
                <input
                    type="checkbox"
                    name="low_stock"
                    value="1"
                    @checked(request()->boolean('low_stock'))
                >

                Stok Rendah
            </label>


            <button
                class="btn"
                type="submit"
            >
                Filter
            </button>

            <a
                class="btn"
                href="{{ route(
                    'admin.inventory.index',
                    [],
                    false
                ) }}"
            >
                Reset
            </a>

        </form>

    </div>


    <div class="table-card">

        <table>

            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Barang</th>
                    <th>Area</th>
                    <th>Jenis</th>
                    <th>Stok</th>
                    <th>Minimum</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

            @forelse ($items as $item)

                @php
                    $isLow =
                        $item->minimum_stock > 0
                        && $item->current_stock
                            <= $item->minimum_stock;
                @endphp

                <tr>

                    <td class="code">
                        {{ $item->item_code }}
                    </td>

                    <td>
                        <strong>
                            {{ $item->name }}
                        </strong>

                        @if ($item->category)
                            <br>
                            <small>
                                {{ $item->category }}
                            </small>
                        @endif
                    </td>

                    <td>
                        {{ $item->area_label }}
                    </td>

                    <td>
                        {{ $item->item_type_label }}
                    </td>

                    <td
                        class="
                            stock
                            {{ $isLow ? 'low' : '' }}
                        "
                    >
                        {{ number_format(
                            $item->current_stock,
                            3,
                            ',',
                            '.'
                        ) }}

                        {{ $item->unit }}
                    </td>

                    <td>
                        {{ number_format(
                            $item->minimum_stock,
                            3,
                            ',',
                            '.'
                        ) }}
                        {{ $item->unit }}
                    </td>

                    <td>
                        {{ $item->location ?? '-' }}
                    </td>

                    <td>

                        @if ($isLow)

                            <span class="badge low">
                                ⚠ Stok Rendah
                            </span>

                        @elseif (!$item->is_active)

                            <span class="badge">
                                Nonaktif
                            </span>

                        @else

                            <span class="badge">
                                Normal
                            </span>

                        @endif

                    </td>

                    <td>

                        <div class="actions">

                            <a href="{{ route(
                                'admin.inventory.movements',
                                $item,
                                false
                            ) }}">
                                Stok
                            </a>

                            <a href="{{ route(
                                'admin.inventory.edit',
                                $item,
                                false
                            ) }}">
                                Edit
                            </a>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="9">
                        Belum ada data inventory.
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>


        <div class="pagination">
            {{ $items->links() }}
        </div>

    </div>

</main>

</body>

</html>
