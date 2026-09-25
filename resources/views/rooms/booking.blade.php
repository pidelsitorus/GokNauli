@extends('layouts.public')

@section('title', 'Booking Kamar - Gok Nauli')

@section(
    'description',
    'Booking kamar Gok Nauli Homestay secara online.'
)

@section('styles')
<style>
    .booking-hero {
        padding: 65px 20px;
        text-align: center;
        background: #e8ecdf;
    }

    .booking-hero span {
        display: inline-block;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 13px;
        color: #66735f;
    }

    .booking-hero h1 {
        margin: 0 0 12px;
        font-size: 42px;
    }

    .booking-hero p {
        margin: 0;
        color: #657064;
    }

    .booking-main {
        width: 92%;
        max-width: 1100px;
        margin: 45px auto 70px;
    }

    .booking-layout {
        display: grid;
        grid-template-columns: 1.1fr .9fr;
        gap: 25px;
        align-items: start;
    }

    .booking-card {
        background: white;
        padding: 28px;
        border-radius: 16px;
        box-shadow: 0 7px 25px rgba(0,0,0,.06);
    }

    .booking-card h2 {
        margin: 0 0 8px;
    }

    .subtitle {
        color: #747b72;
        line-height: 1.6;
        margin-bottom: 25px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
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
    textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-family: inherit;
    }

    input:focus,
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

    .room-image {
        height: 230px;
        background: #dde3d7;
        border-radius: 12px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #747e70;
        margin-bottom: 20px;
    }

    .room-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .room-type {
        color: #71806d;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 12px;
    }

    .room-title {
        font-size: 26px;
        margin: 7px 0;
    }

    .room-number {
        color: #777;
        font-size: 13px;
    }

    .summary {
        margin-top: 25px;
        background: #eef3e9;
        padding: 20px;
        border-radius: 12px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        padding: 10px 0;
        border-bottom: 1px solid #dce5d8;
    }

    .summary-row:last-child {
        border-bottom: 0;
    }

    .summary-row span {
        color: #667063;
    }

    .summary-total {
        font-size: 20px;
        color: #31563a;
    }

    .back-link {
        display: inline-block;
        margin-top: 20px;
        color: #31563a;
        font-weight: bold;
    }

    @media (max-width: 800px) {
        .booking-layout {
            grid-template-columns: 1fr;
        }

        .booking-hero h1 {
            font-size: 34px;
        }
    }

    @media (max-width: 600px) {
        .form-grid {
            grid-template-columns: 1fr;
            gap: 0;
        }
    }
</style>
@endsection


@section('content')

<section class="booking-hero">

    <span>
        Homestay
    </span>

    <h1>
        Booking Kamar
    </h1>

    <p>
        Lengkapi data tamu dan tanggal menginap Anda.
    </p>

</section>


<main class="booking-main">

    @if ($errors->any())

        <div class="error-box">

            <strong>
                Booking belum dapat diproses.
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


    <div class="booking-layout">

        <div class="booking-card">

            <h2>
                Data Tamu
            </h2>

            <p class="subtitle">
                Masukkan data yang dapat digunakan
                Gok Nauli untuk menghubungi Anda.
            </p>


            <form
                method="POST"
                action="{{ route(
                    'rooms.booking.store',
                    $room,
                    false
                ) }}"
            >

                @csrf


                <div class="form-group">

                    <label for="guest_name">
                        Nama Tamu
                    </label>

                    <input
                        id="guest_name"
                        type="text"
                        name="guest_name"
                        value="{{ old('guest_name') }}"
                        required
                    >

                </div>


                <div class="form-grid">

                    <div class="form-group">

                        <label for="guest_phone">
                            WhatsApp / Telepon
                        </label>

                        <input
                            id="guest_phone"
                            type="text"
                            name="guest_phone"
                            value="{{ old('guest_phone') }}"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="guest_email">
                            Email
                        </label>

                        <input
                            id="guest_email"
                            type="email"
                            name="guest_email"
                            value="{{ old('guest_email') }}"
                        >

                    </div>

                </div>


                <div class="form-grid">

                    <div class="form-group">

                        <label for="check_in">
                            Check In
                        </label>

                        <input
                            id="check_in"
                            type="date"
                            name="check_in"
                            value="{{ old(
                                'check_in',
                                $checkIn ?? request('check_in')
                            ) }}"
                            min="{{ date('Y-m-d') }}"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="check_out">
                            Check Out
                        </label>

                        <input
                            id="check_out"
                            type="date"
                            name="check_out"
                            value="{{ old(
                                'check_out',
                                $checkOut ?? request('check_out')
                            ) }}"
                            min="{{ date('Y-m-d') }}"
                            required
                        >

                    </div>

                </div>


                <div class="form-grid">

                    <div class="form-group">

                        <label for="adults">
                            Dewasa
                        </label>

                        <input
                            id="adults"
                            type="number"
                            name="adults"
                            value="{{ old('adults', 1) }}"
                            min="1"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="children">
                            Anak-anak
                        </label>

                        <input
                            id="children"
                            type="number"
                            name="children"
                            value="{{ old('children', 0) }}"
                            min="0"
                            required
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
                        placeholder="Permintaan tambahan atau informasi lainnya..."
                    >{{ old('notes') }}</textarea>

                </div>


                <button
                    class="submit-button"
                    type="submit"
                >
                    Konfirmasi Booking
                </button>

            </form>

        </div>


        <aside class="booking-card">

            <div class="room-image">

                @if ($room->image)

                    <img
                        src="{{ asset(
                            'storage/' . $room->image
                        ) }}"
                        alt="{{ $room->name }}"
                    >

                @else

                    Foto {{ $room->name }}

                @endif

            </div>


            <span class="room-type">
                {{ $room->roomType?->name ?? 'Room' }}
            </span>

            <h2 class="room-title">
                {{ $room->name }}
            </h2>

            <div class="room-number">
                Kamar {{ $room->room_number }}
            </div>


            <div class="summary">

                <div class="summary-row">

                    <span>
                        Harga / malam
                    </span>

                    <strong>
                        Rp {{ number_format(
                            $room->price
                                ?? $room->roomType?->base_price
                                ?? 0,
                            0,
                            ',',
                            '.'
                        ) }}
                    </strong>

                </div>


                <div class="summary-row">

                    <span>
                        Durasi
                    </span>

                    <strong id="total-nights">
                        0 malam
                    </strong>

                </div>


                <div class="summary-row summary-total">

                    <span>
                        Total
                    </span>

                    <strong id="total-price">
                        Rp 0
                    </strong>

                </div>

            </div>


            <a
                class="back-link"
                href="{{ route('rooms.index', [], false) }}"
            >
                ← Kembali ke daftar kamar
            </a>

        </aside>

    </div>

</main>

@endsection


@push('scripts')
<script>
    const checkIn =
        document.getElementById('check_in');

    const checkOut =
        document.getElementById('check_out');

    const totalNights =
        document.getElementById('total-nights');

    const totalPrice =
        document.getElementById('total-price');

    const pricePerNight = Number(
        @json((float) (
            $room->price
            ?? $room->roomType?->base_price
            ?? 0
        ))
    );

    function formatRupiah(value) {
        return new Intl.NumberFormat(
            'id-ID',
            {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0
            }
        ).format(value);
    }

    function calculateTotal() {

        if (!checkIn.value || !checkOut.value) {
            totalNights.textContent = '0 malam';
            totalPrice.textContent = formatRupiah(0);
            return;
        }

        const start = new Date(
            checkIn.value + 'T00:00:00'
        );

        const end = new Date(
            checkOut.value + 'T00:00:00'
        );

        const milliseconds =
            end.getTime() - start.getTime();

        const nights =
            Math.round(
                milliseconds / 86400000
            );

        if (nights <= 0) {
            totalNights.textContent = '0 malam';
            totalPrice.textContent = formatRupiah(0);
            return;
        }

        totalNights.textContent =
            nights + ' malam';

        totalPrice.textContent =
            formatRupiah(
                nights * pricePerNight
            );
    }

    checkIn.addEventListener(
        'change',
        calculateTotal
    );

    checkOut.addEventListener(
        'change',
        calculateTotal
    );

    calculateTotal();
</script>
@endpush
