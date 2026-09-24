@extends('layouts.public')

@section('title', 'Checkout - Gok Nauli')

@section(
    'description',
    'Checkout pesanan Gok Nauli Cafe & Resto.'
)

@section('styles')
<style>
    .checkout-hero {
        padding: 65px 20px;
        text-align: center;
        background: #e8ecdf;
    }

    .checkout-hero span {
        display: inline-block;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 13px;
        color: #66735f;
    }

    .checkout-hero h1 {
        margin: 0 0 12px;
        font-size: 42px;
    }

    .checkout-hero p {
        margin: 0;
        color: #657064;
    }

    .checkout-main {
        width: 92%;
        max-width: 1100px;
        margin: 45px auto 70px;
    }

    .checkout-layout {
        display: grid;
        grid-template-columns: 1.15fr .85fr;
        gap: 25px;
        align-items: start;
    }

    .checkout-card {
        background: white;
        padding: 28px;
        border-radius: 16px;
        box-shadow: 0 7px 25px rgba(0,0,0,.06);
    }

    .checkout-card h2 {
        margin: 0 0 8px;
    }

    .subtitle {
        color: #747b72;
        margin-bottom: 25px;
        line-height: 1.6;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        margin-bottom: 7px;
        font-weight: bold;
        font-size: 14px;
    }

    input,
    select,
    textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-family: inherit;
    }

    input:focus,
    select:focus,
    textarea:focus {
        outline: none;
        border-color: #31563a;
    }

    textarea {
        min-height: 105px;
        resize: vertical;
    }

    .error-box {
        background: #fdebea;
        color: #a12822;
        padding: 15px;
        border-radius: 9px;
        margin-bottom: 22px;
    }

    .error-box ul {
        margin: 8px 0 0 18px;
    }

    .submit-button {
        width: 100%;
        border: 0;
        background: #31563a;
        color: white;
        padding: 14px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
    }

    .submit-button:hover {
        background: #26462e;
    }

    .table-field.hidden {
        display: none;
    }

    .order-item {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        padding: 14px 0;
        border-bottom: 1px solid #eee;
    }

    .order-item small {
        display: block;
        color: #777;
        margin-top: 5px;
    }

    .order-total {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        margin-top: 22px;
        font-size: 21px;
        font-weight: bold;
        color: #31563a;
    }

    .back-cart {
        display: inline-block;
        margin-top: 20px;
        color: #31563a;
        font-weight: bold;
    }

    .checkout-info {
        margin-top: 20px;
        background: #eef3e9;
        border-radius: 9px;
        padding: 15px;
        color: #4e5c4a;
        line-height: 1.6;
        font-size: 14px;
    }

    @media (max-width: 800px) {
        .checkout-layout {
            grid-template-columns: 1fr;
        }

        .checkout-hero h1 {
            font-size: 34px;
        }
    }
</style>
@endsection


@section('content')

<section class="checkout-hero">

    <span>
        Cafe & Resto
    </span>

    <h1>
        Checkout
    </h1>

    <p>
        Lengkapi data pemesan dan periksa kembali pesanan Anda.
    </p>

</section>


<main class="checkout-main">

    @if ($errors->any())

        <div class="error-box">

            <strong>
                Pesanan belum dapat diproses.
            </strong>

            <ul>

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <div class="checkout-layout">

        <div class="checkout-card">

            <h2>
                Data Pemesan
            </h2>

            <p class="subtitle">
                Pilih Dine In atau Takeaway lalu lengkapi
                informasi pemesan.
            </p>


            <form
                method="POST"
                action="{{ route('checkout.store', [], false) }}"
            >

                @csrf


                <div class="form-group">

                    <label for="customer_name">
                        Nama
                    </label>

                    <input
                        id="customer_name"
                        type="text"
                        name="customer_name"
                        value="{{ old('customer_name') }}"
                        placeholder="Nama pemesan"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="customer_phone">
                        WhatsApp / Telepon
                    </label>

                    <input
                        id="customer_phone"
                        type="text"
                        name="customer_phone"
                        value="{{ old('customer_phone') }}"
                        placeholder="Nomor WhatsApp"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="order_type">
                        Jenis Pesanan
                    </label>

                    <select
                        id="order_type"
                        name="order_type"
                        required
                    >

                        <option
                            value="dine_in"
                            @selected(
                                old('order_type', 'dine_in')
                                === 'dine_in'
                            )
                        >
                            Dine In
                        </option>

                        <option
                            value="takeaway"
                            @selected(
                                old('order_type') === 'takeaway'
                            )
                        >
                            Takeaway
                        </option>

                    </select>

                </div>


                <div
                    class="form-group table-field"
                    id="table-field"
                >

                    <label for="restaurant_table_id">
                        Pilih Meja
                    </label>

                    <select
                        id="restaurant_table_id"
                        name="restaurant_table_id"
                    >

                        <option value="">
                            Pilih Meja
                        </option>

                        @foreach ($tables as $table)

                            <option
                                value="{{ $table->id }}"
                                @selected(
                                    old('restaurant_table_id')
                                    == $table->id
                                )
                            >
                                {{ $table->table_number }}
                                -
                                {{ $table->capacity }} orang

                                @if ($table->location)
                                    -
                                    {{ $table->location }}
                                @endif

                            </option>

                        @endforeach

                    </select>

                </div>


                <div class="form-group">

                    <label for="notes">
                        Catatan Pesanan
                    </label>

                    <textarea
                        id="notes"
                        name="notes"
                        placeholder="Contoh: tidak pedas, tanpa es, sambal dipisah..."
                    >{{ old('notes') }}</textarea>

                </div>


                <button
                    class="submit-button"
                    type="submit"
                >
                    Buat Pesanan
                </button>

            </form>


            <div class="checkout-info">

                Setelah pesanan dibuat, status awal adalah
                <strong>Pending</strong> dan pembayaran
                <strong>Unpaid</strong> sampai dikonfirmasi
                oleh Gok Nauli.

            </div>

        </div>


        <div class="checkout-card">

            <h2>
                Ringkasan Pesanan
            </h2>

            <p class="subtitle">
                Pastikan menu dan jumlah pesanan sudah benar.
            </p>


            @foreach ($cart as $item)

                <div class="order-item">

                    <div>

                        <strong>
                            {{ $item['name'] }}
                        </strong>

                        <small>
                            {{ $item['quantity'] }}
                            ×
                            Rp {{ number_format(
                                $item['price'],
                                0,
                                ',',
                                '.'
                            ) }}
                        </small>

                    </div>

                    <strong>

                        Rp {{ number_format(
                            $item['price']
                                * $item['quantity'],
                            0,
                            ',',
                            '.'
                        ) }}

                    </strong>

                </div>

            @endforeach


            <div class="order-total">

                <span>
                    Total
                </span>

                <span>

                    Rp {{ number_format(
                        $total,
                        0,
                        ',',
                        '.'
                    ) }}

                </span>

            </div>


            <a
                class="back-cart"
                href="{{ route('cart.index', [], false) }}"
            >
                ← Kembali ke Keranjang
            </a>

        </div>

    </div>

</main>

@endsection


@push('scripts')
<script>
    const orderType =
        document.getElementById('order_type');

    const tableField =
        document.getElementById('table-field');

    const tableSelect =
        document.getElementById('restaurant_table_id');

    function updateTableField() {

        if (orderType.value === 'takeaway') {

            tableField.classList.add('hidden');

            tableSelect.value = '';

        } else {

            tableField.classList.remove('hidden');

        }
    }

    orderType.addEventListener(
        'change',
        updateTableField
    );

    updateTableField();
</script>
@endpush
