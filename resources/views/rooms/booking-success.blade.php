<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Booking Berhasil - Gok Nauli</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f7f5ef;
            color: #2f352d;
        }

        header {
            background: #26372a;
            color: white;
            padding: 20px 8%;
        }

        header a {
            color: white;
            text-decoration: none;
        }

        .container {
            width: 90%;
            max-width: 720px;
            margin: 50px auto;
        }

        .card {
            background: white;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 8px 30px rgba(0,0,0,.08);
        }

        .success-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 20px;
            border-radius: 50%;
            background: #e6f3e8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 34px;
        }

        h1 {
            text-align: center;
            margin-bottom: 8px;
            color: #355b3e;
        }

        .subtitle {
            text-align: center;
            color: #687064;
            margin-bottom: 30px;
        }

        .booking-code {
            background: #f2f5ef;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 25px;
        }

        .booking-code small {
            display: block;
            color: #687064;
            margin-bottom: 6px;
        }

        .booking-code strong {
            font-size: 26px;
            color: #26372a;
        }

        .section {
            margin-top: 25px;
        }

        .section h2 {
            font-size: 18px;
            margin-bottom: 15px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            padding: 11px 0;
            border-bottom: 1px solid #eee;
        }

        .row span:first-child {
            color: #687064;
        }

        .total {
            font-size: 21px;
            font-weight: bold;
            color: #355b3e;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            background: #fff3cd;
            color: #795d00;
            font-size: 13px;
        }

        .actions {
            display: grid;
            gap: 12px;
            margin-top: 30px;
        }

        .button {
            display: block;
            text-align: center;
            text-decoration: none;
            padding: 14px 20px;
            border-radius: 9px;
            font-weight: bold;
        }

        .whatsapp {
            background: #26753a;
            color: white;
        }

        .secondary {
            background: #eef1ec;
            color: #26372a;
        }

        .notice {
            margin-top: 20px;
            padding: 15px;
            background: #fff8e5;
            border-radius: 9px;
            color: #725c1d;
        }

        @media (max-width: 600px) {
            .row {
                flex-direction: column;
                gap: 5px;
            }

            .card {
                padding: 25px 20px;
            }
        }
    </style>
</head>

<body>

<header>
    Gok Nauli Homestay Cafe & Resto
</header>

@php
    $nights = $booking->check_in->diffInDays($booking->check_out);

    $whatsappNumber = config('goknauli.whatsapp_number');

    $whatsappMessage = rawurlencode(
        "Halo Gok Nauli, saya ingin mengonfirmasi booking homestay.\n\n" .
        "Kode Booking: {$booking->booking_code}\n" .
        "Nama: {$booking->guest_name}\n" .
        "Kamar: {$booking->room->name}\n" .
        "Check-in: {$booking->check_in->format('d/m/Y')}\n" .
        "Check-out: {$booking->check_out->format('d/m/Y')}\n" .
        "Durasi: {$nights} malam\n" .
        "Total: Rp " . number_format($booking->total_price, 0, ',', '.') . "\n\n" .
        "Mohon konfirmasi ketersediaan dan proses pembayaran. Terima kasih."
    );
@endphp

<div class="container">

    <div class="card">

        <div class="success-icon">
            ✓
        </div>

        <h1>Booking Berhasil Dibuat</h1>

        <p class="subtitle">
            Simpan kode booking Anda untuk proses konfirmasi.
        </p>

        <div class="booking-code">
            <small>Kode Booking</small>
            <strong>{{ $booking->booking_code }}</strong>
        </div>

        <div class="section">

            <h2>Detail Tamu</h2>

            <div class="row">
                <span>Nama</span>
                <strong>{{ $booking->guest_name }}</strong>
            </div>

            <div class="row">
                <span>WhatsApp / Telepon</span>
                <strong>{{ $booking->guest_phone }}</strong>
            </div>

            @if ($booking->guest_email)
                <div class="row">
                    <span>Email</span>
                    <strong>{{ $booking->guest_email }}</strong>
                </div>
            @endif

        </div>

        <div class="section">

            <h2>Detail Menginap</h2>

            <div class="row">
                <span>Kamar</span>
                <strong>{{ $booking->room->name }}</strong>
            </div>

            <div class="row">
                <span>Tipe</span>
                <strong>{{ $booking->room->roomType->name }}</strong>
            </div>

            <div class="row">
                <span>Check-in</span>
                <strong>{{ $booking->check_in->format('d M Y') }}</strong>
            </div>

            <div class="row">
                <span>Check-out</span>
                <strong>{{ $booking->check_out->format('d M Y') }}</strong>
            </div>

            <div class="row">
                <span>Durasi</span>
                <strong>{{ $nights }} malam</strong>
            </div>

            <div class="row">
                <span>Tamu</span>

                <strong>
                    {{ $booking->adults }} dewasa
                    @if ($booking->children > 0)
                        + {{ $booking->children }} anak
                    @endif
                </strong>
            </div>

        </div>

        <div class="section">

            <h2>Pembayaran</h2>

            <div class="row">
                <span>Total</span>

                <span class="total">
                    Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                </span>
            </div>

            <div class="row">
                <span>Status Booking</span>

                <span class="badge">
                    {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                </span>
            </div>

            <div class="row">
                <span>Status Pembayaran</span>

                <span class="badge">
                    {{ ucfirst(str_replace('_', ' ', $booking->payment_status)) }}
                </span>
            </div>

        </div>

        <div class="actions">

            @if ($whatsappNumber)

                <a
                    class="button whatsapp"
                    href="https://wa.me/{{ $whatsappNumber }}?text={{ $whatsappMessage }}"
                    target="_blank"
                    rel="noopener"
                >
                    Konfirmasi via WhatsApp
                </a>

            @else

                <div class="notice">
                    Nomor WhatsApp Gok Nauli belum dikonfigurasi.
                </div>

            @endif

            <a
                class="button secondary"
                href="{{ route('rooms.index', [], false) }}"
            >
                Kembali ke Homestay
            </a>

        </div>

    </div>

</div>

</body>
</html>
