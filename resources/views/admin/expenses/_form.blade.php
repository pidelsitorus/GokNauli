@php
    $expense = $expense ?? null;
@endphp

<div class="form-grid">

    <div class="form-group">
        <label for="area">
            Alokasi Pengeluaran
        </label>

        <select
            id="area"
            name="area"
            required
        >
            <option value="">
                Pilih alokasi
            </option>

            <option
                value="general"
                @selected(
                    old('area', $expense?->area) === 'general'
                )
            >
                Umum / Gok Nauli
            </option>

            <option
                value="homestay"
                @selected(
                    old('area', $expense?->area) === 'homestay'
                )
            >
                Homestay
            </option>

            <option
                value="cafe"
                @selected(
                    old('area', $expense?->area) === 'cafe'
                )
            >
                Cafe & Resto
            </option>
        </select>
    </div>


    <div class="form-group">
        <label for="category">
            Kategori
        </label>

        <select
            id="category"
            name="category"
            required
        >
            <option value="">
                Pilih kategori
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
                        old(
                            'category',
                            $expense?->category
                        ) === $value
                    )
                >
                    {{ $label }}
                </option>

            @endforeach
        </select>
    </div>


    <div class="form-group full">
        <label for="description">
            Deskripsi
        </label>

        <input
            id="description"
            type="text"
            name="description"
            value="{{ old(
                'description',
                $expense?->description
            ) }}"
            placeholder="Contoh: Tagihan listrik September"
            required
        >
    </div>


    <div class="form-group">
        <label for="amount">
            Nominal
        </label>

        <input
            id="amount"
            type="number"
            name="amount"
            min="0.01"
            step="0.01"
            value="{{ old(
                'amount',
                $expense?->amount
            ) }}"
            placeholder="Contoh: 1500000"
            required
        >
    </div>


    <div class="form-group">
        <label for="expense_date">
            Tanggal Pengeluaran
        </label>

        <input
            id="expense_date"
            type="date"
            name="expense_date"
            value="{{ old(
                'expense_date',
                $expense?->expense_date
                    ? $expense->expense_date->format('Y-m-d')
                    : today()->format('Y-m-d')
            ) }}"
            required
        >
    </div>


    <div class="form-group">
        <label for="payment_method">
            Metode Pembayaran
        </label>

        <select
            id="payment_method"
            name="payment_method"
        >
            <option value="">
                Tidak ditentukan
            </option>

            @foreach ([
                'Cash',
                'Transfer Bank',
                'QRIS',
                'Debit',
                'Credit Card',
                'E-Wallet',
                'Lainnya',
            ] as $method)

                <option
                    value="{{ $method }}"
                    @selected(
                        old(
                            'payment_method',
                            $expense?->payment_method
                        ) === $method
                    )
                >
                    {{ $method }}
                </option>

            @endforeach
        </select>
    </div>


    <div class="form-group">
        <label for="vendor">
            Vendor / Penerima
        </label>

        <input
            id="vendor"
            type="text"
            name="vendor"
            value="{{ old(
                'vendor',
                $expense?->vendor
            ) }}"
            placeholder="Contoh: PLN"
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
            value="{{ old(
                'reference',
                $expense?->reference
            ) }}"
            placeholder="No. invoice / bukti transfer"
        >
    </div>


    <div class="form-group full">
        <label for="notes">
            Catatan
        </label>

        <textarea
            id="notes"
            name="notes"
            rows="4"
            placeholder="Catatan tambahan..."
        >{{ old(
            'notes',
            $expense?->notes
        ) }}</textarea>
    </div>

</div>
