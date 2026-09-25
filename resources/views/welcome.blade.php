@extends('layouts.public')

@section('title', 'Gok Nauli Homestay Cafe & Resto')

@section(
    'description',
    'Gok Nauli Homestay Cafe & Resto - tempat menginap, bersantai, menikmati makanan dan minuman dalam satu tempat.'
)

@section('styles')
<style>
    .home-hero {
        min-height: 650px;
        display: flex;
        background-size: cover !important;
        background-position: center !important;
        background-repeat: no-repeat !important;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 90px 20px;

        background:
            linear-gradient(
                rgba(32, 49, 36, .88),
                rgba(32, 49, 36, .78)
            ),
            linear-gradient(
                135deg,
                #536b54,
                #28382b
            );

        color: white;
    }

    .hero-content {
        max-width: 850px;
    }

    .eyebrow {
        display: inline-block;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 3px;
        margin-bottom: 18px;
        color: #d9e6d6;
    }

    .home-hero h1 {
        font-size: clamp(42px, 7vw, 76px);
        line-height: 1.05;
        margin: 0 0 20px;
    }

    .home-hero p {
        font-size: 19px;
        line-height: 1.7;
        max-width: 700px;
        margin: 0 auto 32px;
        color: #e4ebe1;
    }

    .hero-buttons {
        display: flex;
        justify-content: center;
        gap: 14px;
        flex-wrap: wrap;
    }

    .hero-secondary {
        border: 1px solid rgba(255,255,255,.7);
        color: white;
    }

    .home-section {
        padding: 75px 7%;
    }

    .section-header {
        max-width: 720px;
        margin-bottom: 35px;
    }

    .section-header span {
        color: #73806e;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 12px;
    }

    .section-header h2 {
        font-size: 38px;
        margin: 10px 0;
    }

    .section-header p {
        color: #6d746b;
        line-height: 1.7;
    }

    .about {
        background: white;
    }

    .about-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 45px;
        align-items: center;
    }

    .about-visual {
        min-height: 380px;
        border-radius: 22px;
        background:
            linear-gradient(
                135deg,
                #dce4d5,
                #aebca8
            );

        display: flex;
        align-items: center;
        justify-content: center;

        color: #536051;
        font-size: 22px;
        text-align: center;
        padding: 30px;
    }

    .about-content h2 {
        font-size: 40px;
        margin: 0 0 18px;
    }

    .about-content p {
        color: #697168;
        line-height: 1.8;
        margin-bottom: 15px;
    }

    .features {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-top: 25px;
    }

    .feature {
        background: #f2f4ed;
        border-radius: 12px;
        padding: 17px;
    }

    .feature strong {
        display: block;
        margin-bottom: 6px;
    }

    .feature span {
        font-size: 13px;
        color: #737a71;
    }

    .rooms-section {
        background: #f7f5ef;
    }

    .card-grid {
        display: grid;
        grid-template-columns:
            repeat(auto-fit, minmax(260px, 1fr));
        gap: 22px;
    }

    .home-card {
        background: white;
        border-radius: 17px;
        overflow: hidden;
        box-shadow: 0 8px 28px rgba(0,0,0,.06);
    }

    .card-image {
        height: 210px;
        background: #dce3d6;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #727c6d;
        overflow: hidden;
    }

    .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .card-body {
        padding: 22px;
    }

    .card-body h3 {
        font-size: 21px;
        margin: 0 0 8px;
    }

    .card-description {
        color: #747b72;
        line-height: 1.6;
        min-height: 52px;
    }

    .card-bottom {
        margin-top: 18px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }

    .price {
        color: #31563a;
        font-weight: bold;
        font-size: 18px;
    }

    .small-link {
        color: #31563a;
        font-weight: bold;
    }

    .menu-section {
        background: white;
    }

    .menu-card {
        padding: 22px;
    }

    .menu-category {
        font-size: 12px;
        color: #74806f;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }

    .menu-price {
        margin-top: 15px;
        color: #31563a;
        font-size: 18px;
        font-weight: bold;
    }

    .services {
        background: #eef1e9;
    }

    .service-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 22px;
    }

    .service-card {
        background: white;
        padding: 30px;
        border-radius: 16px;
    }

    .service-card h3 {
        margin: 0 0 10px;
    }

    .service-card p {
        color: #727971;
        line-height: 1.7;
        margin-bottom: 20px;
    }

    .contact {
        background: #26372a;
        color: white;
        text-align: center;
        padding: 70px 7%;
    }

    .contact h2 {
        font-size: 40px;
        margin: 0 0 15px;
    }

    .contact p {
        max-width: 650px;
        margin: 0 auto 28px;
        line-height: 1.7;
        color: #d6dfd3;
    }

    .empty {
        background: white;
        padding: 30px;
        border-radius: 14px;
        color: #777;
    }


    .facility-grid {
        display: grid;
        grid-template-columns:
            repeat(auto-fit, minmax(200px, 1fr));
        gap: 18px;
    }

    .facility-card {
        background: white;
        border-radius: 16px;
        padding: 26px;
        text-align: center;
        box-shadow: 0 7px 25px rgba(0,0,0,.05);
        transition:
            transform .2s,
            box-shadow .2s;
    }

    .facility-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 35px rgba(0,0,0,.08);
    }

    .facility-icon {
        width: 58px;
        height: 58px;
        margin: 0 auto 16px;
        border-radius: 50%;
        background: #eef3e9;
        color: #31563a;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 25px;
    }

    .facility-card h3 {
        margin: 0 0 8px;
    }

    .facility-card p {
        margin: 0;
        color: #737a71;
        line-height: 1.6;
        font-size: 14px;
    }

    .gallery-section {
        background: white;
    }

    .gallery-grid {
        display: grid;
        grid-template-columns:
            repeat(3, 1fr);
        gap: 15px;
    }

    .gallery-item {
        position: relative;
        height: 260px;
        border-radius: 16px;
        overflow: hidden;
        background: #dce3d7;
    }

    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .35s;
    }

    .gallery-item:hover img {
        transform: scale(1.05);
    }

    .gallery-overlay {
        position: absolute;
        inset: auto 0 0 0;
        padding: 35px 18px 17px;
        color: white;
        background:
            linear-gradient(
                transparent,
                rgba(0,0,0,.72)
            );
    }

    .gallery-overlay strong {
        display: block;
    }

    .gallery-overlay span {
        display: block;
        margin-top: 3px;
        font-size: 12px;
        color: #e1e5df;
    }


    .contact-details {
        max-width: 1000px;
        margin: 35px auto 0;
        display: grid;
        grid-template-columns:
            repeat(auto-fit, minmax(210px, 1fr));
        gap: 16px;
        text-align: left;
    }

    .contact-card {
        background: rgba(255,255,255,.08);
        border: 1px solid rgba(255,255,255,.10);
        border-radius: 14px;
        padding: 20px;
    }

    .contact-card span {
        display: block;
        color: #bfcabd;
        font-size: 12px;
        margin-bottom: 7px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .contact-card strong {
        color: white;
        line-height: 1.6;
    }

    .contact-actions {
        margin-top: 28px;
        display: flex;
        justify-content: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .contact-outline {
        border: 1px solid rgba(255,255,255,.7);
        color: white;
    }


    .location-section {
        background: #f7f5ef;
    }

    .location-grid {
        display: grid;
        grid-template-columns: .85fr 1.15fr;
        gap: 28px;
        align-items: stretch;
    }

    .location-card {
        background: white;
        border-radius: 18px;
        padding: 30px;
        box-shadow: 0 8px 30px rgba(0,0,0,.06);
    }

    .location-card h3 {
        margin: 0 0 18px;
        font-size: 24px;
    }

    .location-info {
        margin-bottom: 20px;
    }

    .location-info span {
        display: block;
        margin-bottom: 5px;
        color: #777;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .location-info strong {
        display: block;
        line-height: 1.6;
    }

    .location-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 25px;
    }

    .map-wrapper {
        min-height: 420px;
        border-radius: 18px;
        overflow: hidden;
        background: #dde3d7;
        box-shadow: 0 8px 30px rgba(0,0,0,.06);
    }

    .map-wrapper iframe {
        width: 100%;
        height: 100%;
        min-height: 420px;
        border: 0;
        display: block;
    }

    @media (max-width: 850px) {
        .about-grid,
        .service-grid,
        .location-grid {
            grid-template-columns: 1fr;
        }

        .gallery-grid {
            grid-template-columns: 1fr 1fr;
        }

        .features {
            grid-template-columns: 1fr;
        }

        .home-hero {
            min-height: 560px;
        }

        .home-section {
            padding: 60px 5%;
        }
    }

    @media (max-width: 550px) {
        .home-hero h1 {
            font-size: 42px;
        }

        .home-hero p {
            font-size: 16px;
        }

        .section-header h2,
        .about-content h2,
        .contact h2 {
            font-size: 31px;
        }

        .card-bottom {
            align-items: flex-start;
            flex-direction: column;
        }

        .gallery-grid {
            grid-template-columns: 1fr;
        }

        .gallery-item {
            height: 230px;
        }
    }
</style>
@endsection


@section('content')

@php
    $heroRoom = $rooms->first(
        fn ($room) => !empty($room->image)
    );

    $heroImage = $heroRoom?->image;
@endphp

<section
    class="home-hero"
    @if ($heroImage)
        style="
            background-image:
                linear-gradient(
                    rgba(25, 40, 29, .72),
                    rgba(25, 40, 29, .78)
                ),
                url('{{ asset('storage/' . $heroImage) }}');
        "
    @endif
>

    <div class="hero-content">

        <span class="eyebrow">
            Homestay • Cafe • Resto
        </span>

        <h1>
            Selamat Datang di Gok Nauli
        </h1>

        <p>
            Nikmati pengalaman menginap yang nyaman,
            bersantai bersama keluarga, serta menikmati
            makanan dan minuman dalam satu tempat.
        </p>

        <div class="hero-buttons">

            <a
                class="btn btn-light"
                href="{{ route('rooms.index', [], false) }}"
            >
                Pesan Kamar
            </a>

            <a
                class="btn hero-secondary"
                href="{{ route('menu.index', [], false) }}"
            >
                Lihat Menu
            </a>

        </div>

    </div>

</section>


<section class="home-section about" id="about">

    <div class="about-grid">

        <div class="about-visual">
            Gok Nauli<br>
            Homestay Cafe & Resto
        </div>

        <div class="about-content">

            <span
                class="eyebrow"
                style="color:#72806f"
            >
                Tentang Kami
            </span>

            <h2>
                Nyaman untuk menginap,
                santai untuk menikmati.
            </h2>

            <p>
                Gok Nauli menghadirkan Homestay, Cafe,
                dan Resto dalam satu tempat untuk memberikan
                pengalaman yang praktis dan nyaman bagi tamu.
            </p>

            <p>
                Anda dapat memesan kamar, menikmati hidangan,
                melakukan reservasi meja, hingga memesan menu
                langsung melalui website.
            </p>

            <div class="features">

                <div class="feature">
                    <strong>Homestay</strong>
                    <span>
                        Kamar nyaman untuk beristirahat.
                    </span>
                </div>

                <div class="feature">
                    <strong>Cafe & Resto</strong>
                    <span>
                        Makanan, kopi, minuman dan camilan.
                    </span>
                </div>

                <div class="feature">
                    <strong>Reservasi Online</strong>
                    <span>
                        Pesan kamar dan meja lebih mudah.
                    </span>
                </div>

            </div>

        </div>

    </div>

</section>


<section class="home-section rooms-section">

    <div class="section-header">

        <span>
            Homestay
        </span>

        <h2>
            Pilihan Kamar
        </h2>

        <p>
            Pilih kamar yang sesuai untuk perjalanan,
            liburan, maupun waktu bersama keluarga.
        </p>

    </div>


    @if ($rooms->count())

        <div class="card-grid">

            @foreach ($rooms as $room)

                <article class="home-card">

                    <div class="card-image">

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

                    <div class="card-body">

                        <h3>
                            {{ $room->name }}
                        </h3>

                        <p class="card-description">

                            {{ $room->description
                                ?: (
                                    $room->roomType?->description
                                    ?: 'Kamar nyaman di Gok Nauli Homestay.'
                                ) }}

                        </p>

                        <div class="card-bottom">

                            <span class="price">

                                Rp {{ number_format(
                                    $room->price
                                        ?? $room->roomType?->base_price
                                        ?? 0,
                                    0,
                                    ',',
                                    '.'
                                ) }}
                                / malam

                            </span>

                            <a
                                class="small-link"
                                href="{{ route(
                                    'rooms.index',
                                    [],
                                    false
                                ) }}"
                            >
                                Lihat Kamar →
                            </a>

                        </div>

                    </div>

                </article>

            @endforeach

        </div>

    @else

        <div class="empty">
            Informasi kamar belum tersedia.
        </div>

    @endif


    <div style="margin-top:30px">

        <a
            class="btn btn-primary"
            href="{{ route('rooms.index', [], false) }}"
        >
            Lihat Semua Kamar
        </a>

    </div>

</section>


<section class="home-section menu-section">

    <div class="section-header">

        <span>
            Cafe & Resto
        </span>

        <h2>
            Menu Pilihan
        </h2>

        <p>
            Nikmati pilihan makanan, minuman,
            kopi, dan camilan di Gok Nauli.
        </p>

    </div>


    @if ($menus->count())

        <div class="card-grid">

            @foreach ($menus as $menu)

                <article class="home-card menu-card">

                    <div class="menu-category">
                        {{ $menu->category?->name ?? 'Menu' }}
                    </div>

                    <h3>
                        {{ $menu->name }}
                    </h3>

                    <p class="card-description">

                        {{ $menu->description
                            ?: 'Menu pilihan Cafe & Resto Gok Nauli.' }}

                    </p>

                    <div class="menu-price">

                        Rp {{ number_format(
                            $menu->price,
                            0,
                            ',',
                            '.'
                        ) }}

                    </div>

                </article>

            @endforeach

        </div>

    @else

        <div class="empty">
            Menu belum tersedia.
        </div>

    @endif


    <div style="margin-top:30px">

        <a
            class="btn btn-primary"
            href="{{ route('menu.index', [], false) }}"
        >
            Lihat Semua Menu
        </a>

    </div>

</section>


<section class="home-section services">

    <div class="section-header">

        <span>
            Layanan
        </span>

        <h2>
            Semua dalam satu tempat
        </h2>

    </div>


    <div class="service-grid">

        <div class="service-card">

            <h3>
                Pesan Kamar
            </h3>

            <p>
                Cek ketersediaan kamar dan lakukan
                booking Homestay secara online.
            </p>

            <a
                class="small-link"
                href="{{ route('rooms.index', [], false) }}"
            >
                Cari Kamar →
            </a>

        </div>


        <div class="service-card">

            <h3>
                Reservasi Meja
            </h3>

            <p>
                Rencanakan kunjungan ke Cafe & Resto
                dengan reservasi meja terlebih dahulu.
            </p>

            <a
                class="small-link"
                href="{{ route(
                    'reservations.create',
                    [],
                    false
                ) }}"
            >
                Reservasi Meja →
            </a>

        </div>


        <div class="service-card">

            <h3>
                Pesan Makanan
            </h3>

            <p>
                Pilih menu dan lakukan pemesanan
                Dine In maupun Takeaway.
            </p>

            <a
                class="small-link"
                href="{{ route('menu.index', [], false) }}"
            >
                Pesan Sekarang →
            </a>

        </div>

    </div>

</section>



<section class="home-section services">

    <div class="section-header">

        <span>
            Fasilitas
        </span>

        <h2>
            Kenyamanan selama di Gok Nauli
        </h2>

        <p>
            Fasilitas yang mendukung pengalaman menginap,
            bersantai, dan menikmati waktu bersama.
        </p>

    </div>


    <div class="facility-grid">

        <div class="facility-card">

            <div class="facility-icon">
                🛏
            </div>

            <h3>
                Kamar Nyaman
            </h3>

            <p>
                Pilihan kamar untuk perjalanan,
                istirahat, dan liburan keluarga.
            </p>

        </div>


        <div class="facility-card">

            <div class="facility-icon">
                ☕
            </div>

            <h3>
                Cafe & Resto
            </h3>

            <p>
                Nikmati makanan, kopi,
                minuman, dan camilan.
            </p>

        </div>


        <div class="facility-card">

            <div class="facility-icon">
                🍽
            </div>

            <h3>
                Reservasi Meja
            </h3>

            <p>
                Pesan meja lebih mudah
                langsung melalui website.
            </p>

        </div>


        <div class="facility-card">

            <div class="facility-icon">
                📱
            </div>

            <h3>
                Pemesanan Online
            </h3>

            <p>
                Booking kamar dan pesan menu
                secara praktis secara online.
            </p>

        </div>

    </div>

</section>


@php
    $roomImages = $rooms->filter(
        fn ($room) => !empty($room->image)
    );

    $menuImages = $menus->filter(
        fn ($menu) => !empty($menu->image)
    );

    $galleryCount =
        $roomImages->count()
        + $menuImages->count();
@endphp


@if ($galleryCount > 0)

<section class="home-section gallery-section">

    <div class="section-header">

        <span>
            Galeri
        </span>

        <h2>
            Lihat suasana Gok Nauli
        </h2>

        <p>
            Beberapa pilihan kamar dan hidangan
            yang tersedia di Gok Nauli.
        </p>

    </div>


    <div class="gallery-grid">

        @foreach ($roomImages as $room)

            <div class="gallery-item">

                <img
                    src="{{ asset(
                        'storage/' . $room->image
                    ) }}"
                    alt="{{ $room->name }}"
                >

                <div class="gallery-overlay">

                    <strong>
                        {{ $room->name }}
                    </strong>

                    <span>
                        Gok Nauli Homestay
                    </span>

                </div>

            </div>

        @endforeach


        @foreach ($menuImages as $menu)

            <div class="gallery-item">

                <img
                    src="{{ asset(
                        'storage/' . $menu->image
                    ) }}"
                    alt="{{ $menu->name }}"
                >

                <div class="gallery-overlay">

                    <strong>
                        {{ $menu->name }}
                    </strong>

                    <span>
                        {{ $menu->category?->name
                            ?? 'Cafe & Resto' }}
                    </span>

                </div>

            </div>

        @endforeach

    </div>

</section>

@endif



@if (config('goknauli.address'))

<section class="home-section location-section">

    <div class="section-header">

        <span>
            Lokasi
        </span>

        <h2>
            Temukan Gok Nauli
        </h2>

        <p>
            Gunakan peta berikut untuk melihat lokasi
            dan mendapatkan petunjuk arah menuju Gok Nauli.
        </p>

    </div>


    <div class="location-grid">

        <div class="location-card">

            <h3>
                Gok Nauli Homestay Cafe & Resto
            </h3>


            <div class="location-info">

                <span>
                    Alamat
                </span>

                <strong>
                    {{ config('goknauli.address') }}
                </strong>

            </div>


            @if (config('goknauli.cafe_hours'))

                <div class="location-info">

                    <span>
                        Jam Cafe & Resto
                    </span>

                    <strong>
                        {{ config('goknauli.cafe_hours') }}
                    </strong>

                </div>

            @endif


            @if (
                config('goknauli.checkin_time')
                || config('goknauli.checkout_time')
            )

                <div class="location-info">

                    <span>
                        Homestay
                    </span>

                    <strong>
                        Check-in:
                        {{ config('goknauli.checkin_time') ?: '-' }}

                        <br>

                        Check-out:
                        {{ config('goknauli.checkout_time') ?: '-' }}
                    </strong>

                </div>

            @endif


            <div class="location-actions">

                @if (config('goknauli.google_maps_url'))

                    <a
                        class="btn btn-primary"
                        href="{{ config('goknauli.google_maps_url') }}"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        Buka Google Maps
                    </a>

                @endif


                @if (config('goknauli.whatsapp_number'))

                    <a
                        class="btn"
                        style="
                            background:#eef3e9;
                            color:#31563a;
                        "
                        href="https://wa.me/{{ config('goknauli.whatsapp_number') }}"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        WhatsApp
                    </a>

                @endif

            </div>

        </div>


        <div class="map-wrapper">

            <iframe
                src="https://www.google.com/maps?q={{ urlencode(config('goknauli.address')) }}&output=embed"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                title="Lokasi Gok Nauli"
            ></iframe>

        </div>

    </div>

</section>

@endif


<section
    class="contact"
    id="contact"
>

    <h2>
        Hubungi Gok Nauli
    </h2>

    <p>
        Ada pertanyaan mengenai kamar, reservasi,
        Cafe & Resto, atau kunjungan Anda?
        Hubungi Gok Nauli melalui informasi berikut.
    </p>


    <div class="contact-details">

        @if (config('goknauli.address'))

            <div class="contact-card">

                <span>
                    Alamat
                </span>

                <strong>
                    {{ config('goknauli.address') }}
                </strong>

            </div>

        @endif


        @if (config('goknauli.cafe_hours'))

            <div class="contact-card">

                <span>
                    Jam Cafe & Resto
                </span>

                <strong>
                    {{ config('goknauli.cafe_hours') }}
                </strong>

            </div>

        @endif


        @if (
            config('goknauli.checkin_time')
            || config('goknauli.checkout_time')
        )

            <div class="contact-card">

                <span>
                    Homestay
                </span>

                <strong>
                    Check-in:
                    {{ config('goknauli.checkin_time') ?: '-' }}

                    <br>

                    Check-out:
                    {{ config('goknauli.checkout_time') ?: '-' }}
                </strong>

            </div>

        @endif

    </div>


    <div class="contact-actions">

        @if (config('goknauli.whatsapp_number'))

            <a
                class="btn btn-light"
                target="_blank"
                rel="noopener noreferrer"
                href="https://wa.me/{{ config(
                    'goknauli.whatsapp_number'
                ) }}"
            >
                WhatsApp
            </a>

        @endif


        @if (config('goknauli.google_maps_url'))

            <a
                class="btn contact-outline"
                target="_blank"
                rel="noopener noreferrer"
                href="{{ config('goknauli.google_maps_url') }}"
            >
                Google Maps
            </a>

        @endif


        @if (config('goknauli.instagram_url'))

            <a
                class="btn contact-outline"
                target="_blank"
                rel="noopener noreferrer"
                href="{{ config('goknauli.instagram_url') }}"
            >
                Instagram
            </a>

        @endif

    </div>

</section>

@endsection
