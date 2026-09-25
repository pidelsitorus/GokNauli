<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Riwayat Inventory - Gok Nauli</title>

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
            max-width: 1400px;
            margin: 35px auto;
        }

        .summary,
        .form-card,
        .history {
            background: white;
            border-radius: 14px;
            padding: 22px;
            margin-bottom: 22px;
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
        }

        .stock {
            font-size: 30px;
            font-weight: bold;
            color: #31563a;
        }

        .form-grid {
            display: grid;
            grid-template-columns:
                repeat(3, 1fr);
            gap: 15px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 7px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #d6d9d4;
            border-radius: 7px;
        }

        textarea {
            min-height: 90px;
        }

        .btn {
            display: inline-block;
            background: #31563a;
            color: white;
            padding: 11px 15px;
            border: 0;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
        }

        .success {
            background: #e8f5e9;
            color: #31563a;
            padding: 14px;
            border-radius: 9px;
            margin-bottom: 18px;
        }

        .error-box {
            background: #fdebea;
            color: #a12822;
            padding: 14px;
            border-radius: 9px;
            margin-bottom: 18px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 950px;
        }

        th,
        td {
            padding: 11px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        th {
            background: #f7f8f5;
            font-size: 12px;
        }

        .history {
            overflow-x: auto;
        }

        @media (max-width: 800px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

@include('admin.partials.header')

<main>

    <a
        class="btn"
        href="{{ route(
            'admin.inventory.index',
            [],
            false
        ) }}"
    >
        ← Inventory
    </a>


    <h1>
        {{ $inventoryItem->name }}
    </h1>

    <p>
        {{ $inventoryItem->item_code }}
        ·
        {{ $inventoryItem->area_label }}
    </p>


    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif


    @if ($errors->any())

        <div class="error-box">

            <strong>
                Transaksi tidak dapat diproses.
            </strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif


    <div class="summary">

        <span>Stok Saat Ini</span>

        <div class="stock">
            {{ number_format(
                $inventoryItem->current_stock,
                3,
                ',',
                '.'
            ) }}
            {{ $inventoryItem->unit }}
        </div>

        Minimum:
        {{ number_format(
            $inventoryItem->minimum_stock,
            3,
            ',',
            '.'
        ) }}
        {{ $inventoryItem->unit }}

    </div>


    <div class="form-card">

        <h2>
            Catat Pergerakan Stok
        </h2>

        <form
            method="POST"
            action="{{ route(
                'admin.inventory.movements.store',
                $inventoryItem,
                false
            ) }}"
        >
            @csrf


            <div class="form-grid">

                <div class="form-group">

                    <label for="movement_type">
                        Aktivitas
                    </label>

                    <select
                        id="movement_type"
                        name="movement_type"
                        required
                    >

                        <option value="">
                            Pilih Aktivitas
                        </option>

                        <option value="STOCK_IN">
                            Barang Masuk
                        </option>

                        <option value="USED">
                            Digunakan
                        </option>

                        <option value="DAMAGED">
                            Rusak
                        </option>

                        <option value="LOST">
                            Hilang
                        </option>

                        <option value="RETURNED">
                            Dikembalikan
                        </option>

                        <option value="ADJUSTMENT_IN">
                            Adjustment +
                        </option>

                        <option value="ADJUSTMENT_OUT">
                            Adjustment -
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label for="quantity">
                        Jumlah
                    </label>

                    <input
                        id="quantity"
                        type="number"
                        name="quantity"
                        min="0.001"
                        step="0.001"
                        value="{{ old('quantity') }}"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="unit_cost">
                        Biaya / Satuan
                    </label>

                    <input
                        id="unit_cost"
                        type="number"
                        name="unit_cost"
                        min="0"
                        step="0.01"
                        value="{{ old('unit_cost') }}"
                        placeholder="Opsional"
                    >

                </div>


                <div class="form-group">

                    <label for="occurred_at">
                        Tanggal & Waktu
                    </label>

                    <input
                        id="occurred_at"
                        type="datetime-local"
                        name="occurred_at"
                        value="{{ old(
                            'occurred_at',
                            now()->format('Y-m-d\TH:i')
                        ) }}"
                    >

                </div>


                <div class="form-group">

                    <label for="reference">
                        Referensi
                    </label>

                    <input
                        id="reference"
                        type="text"
                        name="reference"
                        value="{{ old('reference') }}"
                        placeholder="Invoice, nomor nota..."
                    >

                </div>

            </div>


            <div class="form-group">

                <label for="notes">
                    Catatan
                </label>

                <textarea
                    id="notes"
                    name="notes"
                    placeholder="Contoh: digunakan operasional cafe..."
                >{{ old('notes') }}</textarea>

            </div>


            <button
                class="btn"
                type="submit"
            >
                Simpan Pergerakan
            </button>

        </form>

    </div>


    <div class="history">

        <h2>
            Riwayat Stok
        </h2>


        <table>

            <thead>

                <tr>
                    <th>Waktu</th>
                    <th>Aktivitas</th>
                    <th>Jumlah</th>
                    <th>Sebelum</th>
                    <th>Sesudah</th>
                    <th>Biaya</th>
                    <th>Referensi</th>
                    <th>Catatan</th>
                </tr>

            </thead>

            <tbody>

            @forelse ($movements as $movement)

                <tr>

                    <td>
                        {{ $movement
                            ->occurred_at
                            ->format('d/m/Y H:i') }}
                    </td>

                    <td>
                        {{ $movement->movement_type }}
                    </td>

                    <td>
                        {{ number_format(
                            $movement->quantity,
                            3,
                            ',',
                            '.'
                        ) }}
                        {{ $inventoryItem->unit }}
                    </td>

                    <td>
                        {{ number_format(
                            $movement->stock_before,
                            3,
                            ',',
                            '.'
                        ) }}
                    </td>

                    <td>
                        {{ number_format(
                            $movement->stock_after,
                            3,
                            ',',
                            '.'
                        ) }}
                    </td>

                    <td>
                        @if ($movement->total_cost !== null)
                            Rp {{ number_format(
                                $movement->total_cost,
                                0,
                                ',',
                                '.'
                            ) }}
                        @else
                            -
                        @endif
                    </td>

                    <td>
                        {{ $movement->reference ?? '-' }}
                    </td>

                    <td>
                        {{ $movement->notes ?? '-' }}
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="8">
                        Belum ada riwayat stok.
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>


        {{ $movements->links() }}

    </div>

</main>

</body>

</html>
