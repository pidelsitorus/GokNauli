<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Riwayat Fasilitas - Gok Nauli</title>

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
            padding: 22px;
            border-radius: 14px;
            margin-bottom: 22px;
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
        }

        .condition {
            font-size: 27px;
            color: #31563a;
            font-weight: bold;
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
            border-radius: 8px;
            border: 0;
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

        .history {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1050px;
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
            'admin.facilities.index',
            [],
            false
        ) }}"
    >
        ← Facilities
    </a>


    <h1>
        {{ $facilityAsset->name }}
    </h1>

    <p>
        {{ $facilityAsset->asset_code }}
        ·
        {{ $facilityAsset->area_label }}
        ·
        {{ $facilityAsset->location ?? '-' }}
    </p>


    @if (session('success'))

        <div class="success">
            {{ session('success') }}
        </div>

    @endif


    @if ($errors->any())

        <div class="error-box">

            <strong>
                Aktivitas belum dapat disimpan.
            </strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif


    <div class="summary">

        Kondisi Saat Ini

        <div class="condition">
            {{ $facilityAsset->condition_label }}
        </div>

        <br>

        Maintenance terakhir:
        <strong>
            {{ $facilityAsset->last_maintenance_at
                ?->format('d/m/Y') ?? '-' }}
        </strong>

        <br>

        Maintenance berikutnya:
        <strong>
            {{ $facilityAsset->next_maintenance_at
                ?->format('d/m/Y') ?? '-' }}
        </strong>

    </div>


    <div class="form-card">

        <h2>
            Catat Aktivitas Fasilitas
        </h2>


        <form
            method="POST"
            action="{{ route(
                'admin.facilities.histories.store',
                $facilityAsset,
                false
            ) }}"
        >

            @csrf


            <div class="form-grid">

                <div class="form-group">

                    <label for="activity_type">
                        Aktivitas
                    </label>

                    <select
                        id="activity_type"
                        name="activity_type"
                        required
                    >

                        <option value="">
                            Pilih Aktivitas
                        </option>

                        <option value="INSPECTION">
                            Inspection
                        </option>

                        <option value="DAMAGED">
                            Rusak
                        </option>

                        <option value="MAINTENANCE">
                            Maintenance
                        </option>

                        <option value="REPAIR">
                            Repair / Selesai Diperbaiki
                        </option>

                        <option value="REPLACEMENT">
                            Diganti
                        </option>

                        <option value="RETIREMENT">
                            Tidak Digunakan Lagi
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label for="condition_after">
                        Kondisi Setelah Aktivitas
                    </label>

                    <select
                        id="condition_after"
                        name="condition_after"
                    >

                        <option value="">
                            Otomatis
                        </option>

                        <option value="good">
                            Baik
                        </option>

                        <option value="needs_maintenance">
                            Perlu Maintenance
                        </option>

                        <option value="damaged">
                            Rusak
                        </option>

                        <option value="under_repair">
                            Dalam Perbaikan
                        </option>

                    </select>

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


                    {-- Owner Only: Facility Activity Cost --}
    @if (auth()->user()?->isOwner())

<div class="form-group">

                    <label for="cost">
                        Biaya
                    </label>

                    <input
                        id="cost"
                        type="number"
                        name="cost"
                        min="0"
                        step="0.01"
                        value="{{ old('cost') }}"
                    >

                </div>

    @endif


                <div class="form-group">

                    <label for="vendor">
                        Vendor / Teknisi
                    </label>

                    <input
                        id="vendor"
                        type="text"
                        name="vendor"
                        value="{{ old('vendor') }}"
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
                        placeholder="Nota / invoice"
                    >

                </div>


                <div class="form-group">

                    <label for="next_maintenance_at">
                        Maintenance Berikutnya
                    </label>

                    <input
                        id="next_maintenance_at"
                        type="date"
                        name="next_maintenance_at"
                        value="{{ old(
                            'next_maintenance_at'
                        ) }}"
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
                    placeholder="Jelaskan kondisi atau pekerjaan yang dilakukan..."
                >{{ old('notes') }}</textarea>

            </div>


            <button
                class="btn"
                type="submit"
            >
                Simpan Aktivitas
            </button>

        </form>

    </div>


    <div class="history">

        <h2>
            Riwayat Aset
        </h2>


        <table>

            <thead>

                <tr>
                    <th>Waktu</th>
                    <th>Aktivitas</th>
                    <th>Sebelum</th>
                    <th>Sesudah</th>
                    <th>Biaya</th>
                    <th>Vendor</th>
                    <th>Referensi</th>
                    <th>Catatan</th>
                </tr>

            </thead>

            <tbody>

            @forelse ($histories as $history)

                <tr>

                    <td>
                        {{ $history->occurred_at
                            ->format('d/m/Y H:i') }}
                    </td>

                    <td>
                        <strong>
                            {{ $history->activity_type }}
                        </strong>
                    </td>

                    <td>
                        {{ $history->condition_before
                            ?? '-' }}
                    </td>

                    <td>
                        {{ $history->condition_after
                            ?? '-' }}
                    </td>

                    <td>

                        @if (auth()->user()?->isOwner())

                            @if ($history->cost !== null)

                                <strong>
                                    Rp {{ number_format(
                                        $history->cost,
                                        0,
                                        ',',
                                        '.'
                                    ) }}
                                </strong>

                            @else

                                <span style="color: #777;">
                                    Belum diisi
                                </span>

                            @endif


                            <details
                                style="margin-top: 7px;"
                            >

                                <summary
                                    style="
                                        cursor: pointer;
                                        color: #31563a;
                                        font-weight: 600;
                                    "
                                >
                                    Edit Biaya
                                </summary>


                                <form
                                    class="owner-facility-cost-form"
                                    method="POST"
                                    action="{{ route(
                                        'admin.facilities.histories.cost',
                                        [
                                            $facilityAsset,
                                            $history
                                        ],
                                        false
                                    ) }}"
                                    style="margin-top: 8px;"
                                >

                                    @csrf
                                    @method('PATCH')


                                    <input
                                        type="number"
                                        name="cost"
                                        min="0"
                                        step="0.01"
                                        value="{{ $history->cost }}"
                                        placeholder="Contoh: 450000"
                                        style="
                                            width: 130px;
                                            padding: 7px;
                                            border: 1px solid #ccc;
                                            border-radius: 6px;
                                        "
                                    >


                                    <button
                                        type="submit"
                                        style="
                                            padding: 7px 10px;
                                            border: 0;
                                            border-radius: 6px;
                                            background: #31563a;
                                            color: white;
                                            cursor: pointer;
                                        "
                                    >
                                        Simpan
                                    </button>

                                </form>

                            </details>

                        @endif

                    </td>

                    <td>
                        {{ $history->vendor ?? '-' }}
                    </td>

                    <td>
                        {{ $history->reference ?? '-' }}
                    </td>

                    <td>
                        {{ $history->notes ?? '-' }}
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="8">
                        Belum ada riwayat fasilitas.
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

        {{ $histories->links() }}

    </div>

</main>

</body>

</html>
