<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Facilities - Gok Nauli</title>

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
            flex-wrap: wrap;
            gap: 15px;
        }

        .btn {
            background: #31563a;
            color: white;
            padding: 11px 15px;
            border-radius: 8px;
            text-decoration: none;
            border: 0;
            cursor: pointer;
        }

        .stats {
            display: grid;
            grid-template-columns:
                repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
            margin: 25px 0;
        }

        .stat {
            background: white;
            border-radius: 13px;
            padding: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
        }

        .stat span {
            display: block;
            color: #777;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .stat strong {
            font-size: 27px;
            color: #31563a;
        }

        .warning strong {
            color: #c47c00;
        }

        .danger strong {
            color: #c0392b;
        }

        .filters {
            background: white;
            padding: 18px;
            border-radius: 13px;
            margin-bottom: 20px;
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
            min-width: 1100px;
            border-collapse: collapse;
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

        .badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            background: #edf2e9;
            font-size: 11px;
        }

        .badge.warning {
            background: #fff3d6;
            color: #9a6900;
        }

        .badge.danger {
            background: #fde9e7;
            color: #b3261e;
        }

        .actions {
            display: flex;
            gap: 8px;
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
            <h1>Facilities & Assets</h1>

            <p>
                Kelola fasilitas Homestay
                dan Cafe & Resto.
            </p>
        </div>

        <a
            class="btn"
            href="{{ route(
                'admin.facilities.create',
                [],
                false
            ) }}"
        >
            + Tambah Aset
        </a>

    </div>


    @if (session('success'))

        <div class="success">
            {{ session('success') }}
        </div>

    @endif


    <div class="stats">

        <div class="stat">
            <span>Total Aset Aktif</span>
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

        <div class="stat danger">
            <span>Perlu Perhatian</span>
            <strong>{{ $stats['attention'] }}</strong>
        </div>

        <div class="stat warning">
            <span>Maintenance Jatuh Tempo</span>
            <strong>
                {{ $stats['maintenance_due'] }}
            </strong>
        </div>

    </div>


    <div class="filters">

        <form
            method="GET"
            action="{{ route(
                'admin.facilities.index',
                [],
                false
            ) }}"
        >

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Kode, nama, lokasi..."
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


            <select name="condition">

                <option value="">
                    Semua Kondisi
                </option>

                @foreach ([
                    'good' => 'Baik',
                    'needs_maintenance' =>
                        'Perlu Maintenance',
                    'damaged' => 'Rusak',
                    'under_repair' =>
                        'Dalam Perbaikan',
                    'replaced' => 'Diganti',
                    'retired' =>
                        'Tidak Digunakan',
                ] as $value => $label)

                    <option
                        value="{{ $value }}"
                        @selected(
                            request('condition')
                                === $value
                        )
                    >
                        {{ $label }}
                    </option>

                @endforeach

            </select>


            <label>

                <input
                    type="checkbox"
                    name="attention"
                    value="1"
                    @checked(
                        request()
                            ->boolean('attention')
                    )
                >

                Perlu Perhatian

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
                    'admin.facilities.index',
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
                    <th>Aset</th>
                    <th>Area</th>
                    <th>Lokasi</th>
                    <th>Kondisi</th>
                    <th>Maintenance Terakhir</th>
                    <th>Maintenance Berikutnya</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

            @forelse ($assets as $asset)

                @php
                    $conditionClass =
                        in_array(
                            $asset->condition,
                            [
                                'damaged',
                                'under_repair',
                            ]
                        )
                            ? 'danger'
                            : (
                                $asset->condition
                                    === 'needs_maintenance'
                                        ? 'warning'
                                        : ''
                            );
                @endphp

                <tr>

                    <td class="code">
                        {{ $asset->asset_code }}
                    </td>

                    <td>
                        <strong>
                            {{ $asset->name }}
                        </strong>

                        @if ($asset->category)
                            <br>
                            <small>
                                {{ $asset->category }}
                            </small>
                        @endif
                    </td>

                    <td>
                        {{ $asset->area_label }}
                    </td>

                    <td>
                        {{ $asset->location ?? '-' }}
                    </td>

                    <td>
                        <span
                            class="
                                badge
                                {{ $conditionClass }}
                            "
                        >
                            {{ $asset->condition_label }}
                        </span>
                    </td>

                    <td>
                        {{ $asset->last_maintenance_at
                            ?->format('d/m/Y') ?? '-' }}
                    </td>

                    <td>

                        @if (
                            $asset->next_maintenance_at
                            && $asset
                                ->next_maintenance_at
                                ->lte(today())
                        )

                            <span class="badge warning">
                                ⚠
                                {{ $asset
                                    ->next_maintenance_at
                                    ->format('d/m/Y') }}
                            </span>

                        @else

                            {{ $asset->next_maintenance_at
                                ?->format('d/m/Y') ?? '-' }}

                        @endif

                    </td>

                    <td>

                        <div class="actions">

                            <a href="{{ route(
                                'admin.facilities.histories',
                                $asset,
                                false
                            ) }}">
                                Riwayat
                            </a>

                            <a href="{{ route(
                                'admin.facilities.edit',
                                $asset,
                                false
                            ) }}">
                                Edit
                            </a>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="8">
                        Belum ada fasilitas.
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

        <div class="pagination">
            {{ $assets->links() }}
        </div>

    </div>

</main>

</body>

</html>
