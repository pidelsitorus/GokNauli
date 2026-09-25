@extends('layouts.public')

@section('title', 'Booking Berhasil - Gok Nauli')

@section('styles')
<style>
    .success-main {
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

    .booking-code {
        background: #eef3e9;
        text-align: center;
        padding: 20px;
        border-radius: 12px;
        font-size: 25px;
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

    .total {
        font-size: 20px;
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

    .rooms-button {
        background: #31563a;
        color: white;
    }

    .whatsapp-button {
        display: block;
        margin-top: 12px;
        text-align: center;
        padding: 13px;
        border-radius: 8px;
        background: #31563a;
        color: white;
        font-weight: bold;
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

<main class="success-main">

    <div class="success-card">

        <div class="success-icon">
            ✓
        </div>

        <h1>
            Booking Berhasil Dibuat
        </h1>

        <p class="success-intro">
            Booking Anda sudah masuk dan sedang
            menunggu konfirmasi dari Gok Nauli.
        </p>


        <div class="booking-code">
            {{ $booking->booking_code }}
        </div>


        <div class="detail-row">

            <span>
                Nama Tamu
            </span>

            <strong>
                {{ $booking->guest_name }}
            </strong>

        </div>


        <div class="detail-row">

            <span>
                Kamar
            </span>

            <strong>
                {{ $booking->room?->name }}
                ({{ $booking->room?->room_number }})
            </strong>

        </div>


        <div class="detail-row">

            <span>
                Tipe Kamar
            </span>

            <strong>
                {{ $booking->room?->roomType?->name ?? '-' }}
            </strong>

        </div>


        <div class="detail-row">

            <span>
                Check In
            </span>

            <strong>
                {{ $booking->check_in->format('d M Y') }}
            </strong>

        </div>


        <div class="detail-row">

            <span>
                Check Out
            </span>

            <strong>
                {{ $booking->check_out->format('d M Y') }}
            </strong>

        </div>


        <div class="detail-row">

            <span>
                Durasi
            </span>

            <strong>
                {{ $booking->check_in
                    ->diffInDays($booking->check_out) }}
                malam
            </strong>

        </div>


        <div class="detail-row">

            <span>
                Tamu
            </span>

            <strong>
                {{ $booking->adults }} dewasa

                @if ($booking->children > 0)

                    ,
                    {{ $booking->children }} anak

                @endif
            </strong>

        </div>


        <div class="detail-row">

            <span>
                Status Booking
            </span>

            <strong class="status">
                {{ ucfirst($booking->status) }}
            </strong>

        </div>


        <div class="detail-row">

            <span>
                Pembayaran
            </span>

            <strong class="payment">
                {{ ucfirst($booking->payment_status) }}
            </strong>

        </div>


        <div class="detail-row total">

            <strong>
                Total
            </strong>

            <strong>

                Rp {{ number_format(
                    $booking->total_price,
                    0,
                    ',',
                    '.'
                ) }}

            </strong>

        </div>


        @if ($booking->notes)

            <div class="detail-row">

                <span>
                    Catatan
                </span>

                <strong>
                    {{ $booking->notes }}
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
                class="action-button rooms-button"
                href="{{ route('rooms.index', [], false) }}"
            >
                Lihat Kamar
            </a>

        </div>


        @php
            $whatsappNumber =
                config('goknauli.whatsapp_number');

            $whatsappMessage =
                'Halo Gok Nauli, saya ingin mengonfirmasi booking '
                . $booking->booking_code
                . ' atas nama '
                . $booking->guest_name
                . '.';
        @endphp


        @if ($whatsappNumber)

            <a
                class="whatsapp-button"
                target="_blank"
                rel="noopener noreferrer"
                href="https://wa.me/{{ $whatsappNumber }}?text={{ rawurlencode($whatsappMessage) }}"
            >
                Konfirmasi melalui WhatsApp
            </a>

        @endif

    </div>

</main>

@endsection
