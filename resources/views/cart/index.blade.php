@extends('layouts.public')

@section('title', 'Keranjang Pesanan - Gok Nauli')

@section(
    'description',
    'Keranjang pesanan Gok Nauli Cafe & Resto.'
)

@section('styles')
<style>
    .cart-hero {
        padding: 65px 20px;
        text-align: center;
        background: #e8ecdf;
    }

    .cart-hero span {
        display: inline-block;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 13px;
        color: #66735f;
    }

    .cart-hero h1 {
        margin: 0 0 12px;
        font-size: 42px;
    }

    .cart-hero p {
        color: #657064;
        margin: 0;
    }

    .cart-main {
        width: 92%;
        max-width: 1100px;
        margin: 45px auto 70px;
    }

    .cart-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 8px 28px rgba(0,0,0,.06);
        overflow: hidden;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 720px;
    }

    th,
    td {
        padding: 15px;
        border-bottom: 1px solid #eee;
        text-align: left;
        vertical-align: middle;
    }

    th {
        background: #f5f7f2;
        font-size: 13px;
        color: #596256;
    }

    .menu-name {
        font-weight: bold;
    }

    .quantity-form {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .quantity-form input {
        width: 70px;
        padding: 9px;
        border: 1px solid #ccc;
        border-radius: 7px;
    }

    button {
        border: 0;
        border-radius: 7px;
        padding: 9px 12px;
        cursor: pointer;
        font-weight: bold;
    }

    .update-button {
        background: #31563a;
        color: white;
    }

    .remove-button {
        background: #a63d36;
        color: white;
    }

    .cart-bottom {
        padding: 25px;
    }

    .summary {
        display: flex;
        justify-content: flex-end;
    }

    .summary-box {
        width: 360px;
        background: #eef3e9;
        border-radius: 13px;
        padding: 22px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        font-size: 21px;
        font-weight: bold;
    }

    .checkout-button {
        display: block;
        margin-top: 20px;
        padding: 14px;
        text-align: center;
        border-radius: 8px;
        background: #31563a;
        color: white;
        font-weight: bold;
    }

    .cart-actions {
        margin-top: 22px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .add-more {
        color: #31563a;
        font-weight: bold;
    }

    .clear-button {
        background: #6b7069;
        color: white;
    }

    .empty-cart {
        padding: 65px 25px;
        text-align: center;
    }

    .empty-cart h2 {
        margin: 0 0 10px;
    }

    .empty-cart p {
        color: #747b72;
        margin-bottom: 25px;
    }

    .cart-info {
        margin-top: 25px;
        background: #fffbea;
        color: #665b37;
        padding: 15px;
        border-radius: 10px;
        line-height: 1.6;
    }

    @media (max-width: 650px) {
        .cart-hero h1 {
            font-size: 34px;
        }

        .summary-box {
            width: 100%;
        }

        .cart-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .add-more {
            text-align: center;
        }

        .clear-button {
            width: 100%;
        }
    }
</style>
@endsection


@section('content')

<section class="cart-hero">

    <span>
        Cafe & Resto
    </span>

    <h1>
        Keranjang Pesanan
    </h1>

    <p>
        Periksa kembali menu dan jumlah pesanan Anda.
    </p>

</section>


<main class="cart-main">

    <div class="cart-card">

        @if (count($cart) > 0)

            <div class="table-wrapper">

                <table>

                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                    @foreach ($cart as $item)

                        <tr>

                            <td class="menu-name">
                                {{ $item['name'] }}
                            </td>

                            <td>
                                Rp {{ number_format(
                                    $item['price'],
                                    0,
                                    ',',
                                    '.'
                                ) }}
                            </td>

                            <td>

                                <form
                                    class="quantity-form"
                                    method="POST"
                                    action="{{ route(
                                        'cart.update',
                                        $item['menu_id'],
                                        false
                                    ) }}"
                                >

                                    @csrf
                                    @method('PATCH')

                                    <input
                                        type="number"
                                        name="quantity"
                                        min="1"
                                        max="99"
                                        value="{{ $item['quantity'] }}"
                                        required
                                    >

                                    <button
                                        class="update-button"
                                        type="submit"
                                    >
                                        Update
                                    </button>

                                </form>

                            </td>

                            <td>

                                <strong>
                                    Rp {{ number_format(
                                        $item['price']
                                            * $item['quantity'],
                                        0,
                                        ',',
                                        '.'
                                    ) }}
                                </strong>

                            </td>

                            <td>

                                <form
                                    method="POST"
                                    action="{{ route(
                                        'cart.remove',
                                        $item['menu_id'],
                                        false
                                    ) }}"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="remove-button"
                                        type="submit"
                                    >
                                        Hapus
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>

            </div>


            <div class="cart-bottom">

                <div class="summary">

                    <div class="summary-box">

                        <div class="summary-row">

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
                            class="checkout-button"
                            href="{{ route(
                                'checkout.index',
                                [],
                                false
                            ) }}"
                        >
                            Lanjut Checkout
                        </a>

                    </div>

                </div>


                <div class="cart-actions">

                    <a
                        class="add-more"
                        href="{{ route('menu.index', [], false) }}"
                    >
                        ← Tambah Menu Lagi
                    </a>


                    <form
                        method="POST"
                        action="{{ route(
                            'cart.clear',
                            [],
                            false
                        ) }}"
                    >

                        @csrf
                        @method('DELETE')

                        <button
                            class="clear-button"
                            type="submit"
                        >
                            Kosongkan Keranjang
                        </button>

                    </form>

                </div>


                <div class="cart-info">

                    Harga pesanan akan diverifikasi kembali
                    menggunakan harga menu terbaru saat proses
                    checkout dilakukan.

                </div>

            </div>

        @else

            <div class="empty-cart">

                <h2>
                    Keranjang masih kosong
                </h2>

                <p>
                    Pilih makanan atau minuman dari
                    Cafe & Resto terlebih dahulu.
                </p>

                <a
                    class="btn btn-primary"
                    href="{{ route('menu.index', [], false) }}"
                >
                    Lihat Menu
                </a>

            </div>

        @endif

    </div>

</main>

@endsection
