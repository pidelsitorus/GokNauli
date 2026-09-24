@extends('layouts.public')

@section('title', 'Pesanan Berhasil - Gok Nauli')

@section('styles')
<style>
    .order-success-main {
        width: 90%;
        max-width: 760px;
        margin: 60px auto;
    }

    .success-card {
        background: white;
        padding: 35px;
        border-radius: 18px;
        box-shadow: 0 8px 30px rgba(0,0,0,.07);
    }

    .success-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 20px;
        border-radius: 50%;
        background: #e5f2e5;
        color: #31563a;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 32px;
        font-weight: bold;
    }

    .success-card h1 {
        text-align: center;
        color: #31563a;
        margin: 0 0 10px;
    }

    .success-intro {
        text-align: center;
        color: #70776f;
        line-height: 1.6;
    }

    .order-code {
        background: #eef3e9;
        text-align: center;
        padding: 20px;
        border-radius: 12px;
        font-size: 24px;
        font-weight: bold;
        margin: 28px 0;
        color: #31563a;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        padding: 13px 0;
        border-bottom: 1px solid #eee;
    }

    .detail-row span {
        color: #70776f;
    }

    .section-title {
        margin-top: 30px;
        margin-bottom: 8px;
    }

    .status {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        background: #fff4d6;
        color: #856311;
        font-size: 12px;
    }

    .payment {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        background: #fdebea;
        color: #98372f;
        font-size: 12px;
    }

    .grand-total {
        font-size: 19px;
        color: #31563a;
    }

    .actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-top: 30px;
    }

    .action-button {
        text-align: center;
        padding: 13px;
        border-radius: 8px;
        font-weight: bold;
    }

    .home-button {
        background: #eef3e9;
        color: #31563a;
    }

    .menu-button {
        background: #31563a;
        color: white;
    }

    @media (max-width: 550px) {
        .success-card {
            padding: 25px;
        }

        .detail-row {
            flex-direction: column;
            gap: 5px;
        }

        .actions {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection


@section('content')

<main class="order-success-main">

    <div class="success-card">

        <div class="success-icon">
            ✓
        </div>

        <h1>
            Pesanan Berhasil Dibuat
        </h1>

        <p class="success-intro">
            Pesanan Anda sudah masuk ke sistem Gok Nauli
            dan sedang menunggu konfirmasi.
        </p>


        <div class="order-code">
            {{ $order->order_code }}
        </div>


        <div class="detail-row">

            <span>
                Nama
            </span>

            <strong>
                {{ $order->customer_name }}
            </strong>

        </div>


        <div class="detail-row">

            <span>
                Jenis Pesanan
            </span>

            <strong>

                {{ $order->order_type === 'dine_in'
                    ? 'Dine In'
                    : 'Takeaway' }}

            </strong>

        </div>


        @if ($order->order_type === 'dine_in')

            <div class="detail-row">

                <span>
                    Meja
                </span>

                <strong>

                    {{ $order
                        ->restaurantTable
                        ?->table_number ?? '-' }}

                </strong>

            </div>

        @endif


        <div class="detail-row">

            <span>
                Status Pesanan
            </span>

            <strong class="status">
                {{ ucfirst($order->status) }}
            </strong>

        </div>


        <div class="detail-row">

            <span>
                Pembayaran
            </span>

            <strong class="payment">
                {{ ucfirst($order->payment_status) }}
            </strong>

        </div>


        <h2 class="section-title">
            Detail Pesanan
        </h2>


        @foreach ($order->items as $item)

            <div class="detail-row">

                <span>
                    {{ $item->menu_name }}
                    × {{ $item->quantity }}
                </span>

                <strong>

                    Rp {{ number_format(
                        $item->subtotal,
                        0,
                        ',',
                        '.'
                    ) }}

                </strong>

            </div>

        @endforeach


        <div class="detail-row grand-total">

            <strong>
                Total
            </strong>

            <strong>

                Rp {{ number_format(
                    $order->subtotal,
                    0,
                    ',',
                    '.'
                ) }}

            </strong>

        </div>


        @if ($order->notes)

            <div class="detail-row">

                <span>
                    Catatan
                </span>

                <strong>
                    {{ $order->notes }}
                </strong>

            </div>

        @endif


        <div class="actions">

            <a
                class="action-button home-button"
                href="{{ route('home', [], false) }}"
            >
                Kembali ke Home
            </a>

            <a
                class="action-button menu-button"
                href="{{ route('menu.index', [], false) }}"
            >
                Pesan Menu Lagi
            </a>

        </div>

    </div>

</main>

@endsection
