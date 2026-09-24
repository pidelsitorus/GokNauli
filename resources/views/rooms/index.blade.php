@extends('layouts.public')

@section('title', 'Homestay - Gok Nauli')

@section(
    'description',
    'Temukan kamar yang nyaman di Gok Nauli Homestay dan cek ketersediaan berdasarkan tanggal menginap.'
)

@section('styles')
<style>
    .rooms-hero {
        padding: 80px 20px;
        text-align: center;
        background: #e8ecdf;
    }

    .rooms-hero span {
        display: inline-block;
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 13px;
        color: #66735f;
    }

    .rooms-hero h1 {
        margin: 0 0 15px;
        font-size: 46px;
    }

    .rooms-hero p {
        max-width: 680px;
        margin: auto;
        color: #657064;
        line-height: 1.7;
        font-size: 17px;
    }

    .availability-wrapper {
        width: 90%;
        max-width: 950px;
        margin: -35px auto 45px;
        position: relative;
        z-index: 5;
    }

    .availability-card {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 8px 30px rgba(0,0,0,.08);
    }

    .availability-card h2 {
        margin: 0 0 18px;
        font-size: 22px;
    }

    .search-grid {
        display: grid;
        grid-template-columns: 1fr 1fr auto;
        gap: 15px;
        align-items: end;
    }

    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 7px;
        font-size: 14px;
    }

    .form-group input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
    }

    .search-button {
        border: 0;
        background: #31563a;
        color: white;
        padding: 13px 22px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
        min-height: 43px;
    }

    .search-button:hover {
        background: #26462e;
    }

    .reset-link {
        display: inline-block;
        margin-top: 15px;
        color: #31563a;
        font-weight: bold;
        font-size: 14px;
    }

    .error-box {
        margin-top: 15px;
        background: #fdebea;
        color: #a12822;
        padding: 14px;
        border-radius: 8px;
    }

    .rooms-main {
        width: 90%;
        max-width: 1200px;
        margin: 0 auto 70px;
    }

    .section-heading {
        margin-bottom: 28px;
    }

    .section-heading h2 {
        margin: 0 0 8px;
        font-size: 32px;
    }

    .section-heading p {
        color: #70776f;
        margin: 0;
        line-height: 1.6;
    }

    .room-grid {
        display: grid;
        grid-template-columns:
            repeat(auto-fit, minmax(280px, 1fr));
        gap: 24px;
    }

    .room-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 7px 25px rgba(0,0,0,.06);
        transition: transform .2s;
    }

    .room-card:hover {
        transform: translateY(-3px);
    }

    .room-image {
        height: 210px;
        background: #dde3d7;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #747e70;
        overflow: hidden;
    }

    .room-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .room-content {
        padding: 22px;
    }

    .room-type {
        display: inline-block;
        margin-bottom: 8px;
        color: #71806d;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 12px;
    }

    .room-content h3 {
        margin: 0;
        font-size: 22px;
    }

    .room-number {
        margin-top: 6px;
        color: #777;
        font-size: 13px;
    }

    .room-description {
        color: #70776f;
        line-height: 1.6;
        margin: 15px 0;
        min-height: 50px;
    }

    .room-info {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 18px;
    }

    .badge {
        background: #eef2e9;
        color: #40533f;
        border-radius: 20px;
        padding: 7px 11px;
        font-size: 12px;
    }

    .room-footer {
        border-top: 1px solid #eee;
        padding-top: 18px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
    }

    .price {
        color: #31563a;
        font-size: 19px;
        font-weight: bold;
    }

    .price small {
        display: block;
        color: #777;
        font-size: 11px;
        font-weight: normal;
        margin-top: 3px;
    }

    .book-button {
        background: #31563a;
        color: white;
        padding: 11px 16px;
        border-radius: 8px;
        font-weight: bold;
        text-align: center;
    }

    .book-button:hover {
        background: #26462e;
    }

    .search-result {
        background: #eef3e9;
        padding: 14px 18px;
        border-radius: 10px;
        margin-bottom: 25px;
        color: #40533f;
    }

    .empty {
        background: white;
        border-radius: 14px;
        padding: 40px;
        text-align: center;
        color: #777;
        box-shadow: 0 5px 20px rgba(0,0,0,.04);
    }

    .rooms-cta {
        background: #26372a;
        color: white;
        text-align: center;
        padding: 55px 20px;
    }

    .rooms-cta h2 {
        margin: 0 0 12px;
        font-size: 30px;
    }

    .rooms-cta p {
        color: #d4ddd1;
        margin: 0 0 24px;
        line-height: 1.6;
    }

    @media (max-width: 750px) {
        .search-grid {
            grid-template-columns: 1fr;
        }

        .search-button {
            width: 100%;
        }

        .rooms-hero h1 {
            font-size: 35px;
        }

        .availability-wrapper {
            margin-top: -20px;
        }
    }

    @media (max-width: 550px) {
        .room-footer {
            flex-direction: column;
            align-items: flex-start;
        }

        .book-button {
            width: 100%;
        }
    }
</style>
@endsection


@section('content')

<section class="rooms-hero">

    <span>
        Gok Nauli
    </span>

    <h1>
        Homestay
    </h1>

    <p>
        Temukan kamar yang nyaman untuk beristirahat
        dan nikmati pengalaman menginap di Gok Nauli.
    </p>

</section>


<div class="availability-wrapper">

    <div class="availability-card">

        <h2>
            Cek Ketersediaan Kamar
        </h2>

        <form
            method="GET"
            action="{{ route('rooms.index', [], false) }}"
        >

            <div class="search-grid">

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
                    >

                </div>


                <button
                    class="search-button"
                    type="submit"
                >
                    Cari Kamar
                </button>

            </div>

        </form>


        @if (request('check_in') || request('check_out'))

            <a
                class="reset-link"
                href="{{ route('rooms.index', [], false) }}"
            >
                Reset Pencarian
            </a>

        @endif


        @if ($errors->any())

            <div class="error-box">

                @foreach ($errors->all() as $error)

                    <div>
                        {{ $error }}
                    </div>

                @endforeach

            </div>

        @endif

    </div>

</div>


<main class="rooms-main">

    <div class="section-heading">

        <h2>
            Kamar Gok Nauli
        </h2>

        @if (!empty($checkIn) && !empty($checkOut))

            <p>
                Menampilkan kamar yang tersedia dari
                <strong>{{ date('d/m/Y', strtotime($checkIn)) }}</strong>
                sampai
                <strong>{{ date('d/m/Y', strtotime($checkOut)) }}</strong>.
            </p>

        @else

            <p>
                Pilih kamar yang sesuai dengan kebutuhan Anda.
                Gunakan form di atas untuk mengecek ketersediaan.
            </p>

        @endif

    </div>


    @if (!empty($checkIn) && !empty($checkOut))

        <div class="search-result">
            Hasil pencarian untuk tanggal
            <strong>{{ date('d/m/Y', strtotime($checkIn)) }}</strong>
            –
            <strong>{{ date('d/m/Y', strtotime($checkOut)) }}</strong>.
        </div>

    @endif


    @if ($rooms->count())

        <div class="room-grid">

            @foreach ($rooms as $room)

                <article class="room-card">

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


                    <div class="room-content">

                        <span class="room-type">
                            {{ $room->roomType?->name ?? 'Room' }}
                        </span>

                        <h3>
                            {{ $room->name }}
                        </h3>

                        <div class="room-number">
                            Kamar {{ $room->room_number }}
                        </div>


                        <p class="room-description">

                            {{ $room->description
                                ?: (
                                    $room->roomType?->description
                                    ?: 'Kamar nyaman di Gok Nauli Homestay.'
                                ) }}

                        </p>


                        <div class="room-info">

                            <span class="badge">
                                Kapasitas
                                {{ $room->roomType?->capacity ?? 2 }}
                                orang
                            </span>

                            <span class="badge">
                                {{ ucfirst($room->status) }}
                            </span>

                        </div>


                        <div class="room-footer">

                            <div class="price">

                                Rp {{ number_format(
                                    $room->price
                                        ?? $room->roomType?->base_price
                                        ?? 0,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                                <small>
                                    per malam
                                </small>

                            </div>


                            <a
                                class="book-button"
                                href="{{ route(
                                    'rooms.booking',
                                    [
                                        'room' => $room,
                                        'check_in' => $checkIn ?? null,
                                        'check_out' => $checkOut ?? null,
                                    ],
                                    false
                                ) }}"
                            >
                                Pesan Kamar
                            </a>

                        </div>

                    </div>

                </article>

            @endforeach

        </div>

    @else

        <div class="empty">

            <h3>
                Tidak ada kamar tersedia
            </h3>

            <p>
                Coba gunakan tanggal lain untuk mencari
                ketersediaan kamar.
            </p>

        </div>

    @endif

</main>


<section class="rooms-cta">

    <h2>
        Lengkapi pengalaman Anda di Gok Nauli
    </h2>

    <p>
        Setelah memesan kamar, Anda juga dapat menikmati
        makanan dan minuman dari Cafe & Resto kami.
    </p>

    <a
        class="btn btn-light"
        href="{{ route('menu.index', [], false) }}"
    >
        Lihat Cafe & Resto
    </a>

</section>

@endsection
