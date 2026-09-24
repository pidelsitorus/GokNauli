@extends('layouts.public')

@section('title', 'Reservasi Meja - Gok Nauli')

@section(
    'description',
    'Reservasi meja Gok Nauli Cafe & Resto secara online.'
)

@section('styles')
<style>
    .reservation-hero {
        padding: 75px 20px;
        text-align: center;
        background: #e8ecdf;
    }

    .reservation-hero span {
        display: inline-block;
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 13px;
        color: #66735f;
    }

    .reservation-hero h1 {
        margin: 0 0 15px;
        font-size: 44px;
    }

    .reservation-hero p {
        max-width: 650px;
        margin: auto;
        color: #657064;
        line-height: 1.7;
    }

    .reservation-main {
        width: 90%;
        max-width: 850px;
        margin: 50px auto 70px;
    }

    .reservation-card {
        background: white;
        padding: 32px;
        border-radius: 17px;
        box-shadow: 0 8px 30px rgba(0,0,0,.07);
    }

    .reservation-card h2 {
        margin: 0 0 8px;
    }

    .subtitle {
        color: #747b72;
        line-height: 1.6;
        margin-bottom: 28px;
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
        font-weight: bold;
        margin-bottom: 7px;
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
        min-height: 110px;
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

    .reservation-info {
        margin-top: 22px;
        background: #eef3e9;
        border-radius: 10px;
        padding: 17px;
        color: #4e5c4a;
        line-height: 1.6;
    }

    .reservation-cta {
        background: #26372a;
        color: white;
        text-align: center;
        padding: 50px 20px;
    }

    .reservation-cta h2 {
        margin: 0 0 12px;
    }

    .reservation-cta p {
        color: #d4ddd1;
        margin: 0 0 22px;
    }

    @media (max-width: 650px) {
        .form-grid {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .reservation-hero h1 {
            font-size: 34px;
        }

        .reservation-card {
            padding: 24px;
        }
    }
</style>
@endsection


@section('content')

<section class="reservation-hero">

    <span>
        Cafe & Resto
    </span>

    <h1>
        Reservasi Meja
    </h1>

    <p>
        Tentukan tanggal, waktu, dan jumlah tamu.
        Sistem akan mencarikan meja yang sesuai untuk Anda.
    </p>

</section>


<main class="reservation-main">

    <div class="reservation-card">

        <h2>
            Data Reservasi
        </h2>

        <p class="subtitle">
            Isi data berikut untuk membuat reservasi
            di Gok Nauli Cafe & Resto.
        </p>


        @if ($errors->any())

            <div class="error-box">

                <strong>
                    Reservasi belum dapat dibuat.
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


        <form
            method="POST"
            action="{{ route('reservations.store', [], false) }}"
        >

            @csrf


            <div class="form-group">

                <label for="guest_name">
                    Nama
                </label>

                <input
                    id="guest_name"
                    type="text"
                    name="guest_name"
                    value="{{ old('guest_name') }}"
                    placeholder="Nama lengkap"
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
                        placeholder="Nomor WhatsApp"
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
                        placeholder="Opsional"
                    >

                </div>

            </div>


            <div class="form-grid">

                <div class="form-group">

                    <label for="reservation_date">
                        Tanggal Reservasi
                    </label>

                    <input
                        id="reservation_date"
                        type="date"
                        name="reservation_date"
                        value="{{ old('reservation_date') }}"
                        min="{{ date('Y-m-d') }}"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="reservation_time">
                        Waktu
                    </label>

                    <input
                        id="reservation_time"
                        type="time"
                        name="reservation_time"
                        value="{{ old('reservation_time') }}"
                        required
                    >

                </div>

            </div>


            <div class="form-group">

                <label for="guests">
                    Jumlah Tamu
                </label>

                <input
                    id="guests"
                    type="number"
                    name="guests"
                    value="{{ old('guests', 2) }}"
                    min="1"
                    required
                >

            </div>


            <div class="form-group">

                <label for="notes">
                    Catatan
                </label>

                <textarea
                    id="notes"
                    name="notes"
                    placeholder="Contoh: ingin area outdoor, acara ulang tahun, kursi bayi..."
                >{{ old('notes') }}</textarea>

            </div>


            <button
                class="submit-button"
                type="submit"
            >
                Buat Reservasi
            </button>

        </form>


        <div class="reservation-info">

            <strong>
                Informasi:
            </strong>

            reservasi yang dibuat akan berstatus
            <strong>Pending</strong> terlebih dahulu dan
            menunggu konfirmasi dari Gok Nauli.

        </div>

    </div>

</main>


<section class="reservation-cta">

    <h2>
        Ingin melihat menu terlebih dahulu?
    </h2>

    <p>
        Lihat pilihan makanan, minuman, kopi, dan camilan
        dari Gok Nauli Cafe & Resto.
    </p>

    <a
        class="btn btn-light"
        href="{{ route('menu.index', [], false) }}"
    >
        Lihat Menu
    </a>

</section>

@endsection
