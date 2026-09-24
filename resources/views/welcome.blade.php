<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Gok Nauli Homestay Cafe & Resto</title>

    <meta
        name="description"
        content="Gok Nauli Homestay Cafe & Resto - tempat menginap, bersantai, menikmati makanan dan minuman dalam satu tempat."
    >

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f7f5ef;
            color: #283029;
        }

        a {
            text-decoration: none;
        }

        header {
            position: sticky;
            top: 0;
            z-index: 100;
            background: #26372a;
            color: white;
            padding: 18px 7%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            box-shadow: 0 3px 20px rgba(0,0,0,.12);
        }

        .brand {
            font-size: 24px;
            font-weight: bold;
            color: white;
            white-space: nowrap;
        }

        nav {
            display: flex;
            align-items: center;
            gap: 22px;
            flex-wrap: wrap;
        }

        nav a {
            color: #fff;
            font-size: 14px;
        }

        nav a:hover {
            opacity: .8;
        }

        .hero {
            min-height: 650px;
            display: flex;
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

        .hero h1 {
            font-size: clamp(42px, 7vw, 76px);
            line-height: 1.05;
            margin-bottom: 20px;
        }

        .hero p {
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

        .btn {
            display: inline-block;
            padding: 14px 22px;
            border-radius: 9px;
            font-weight: bold;
            transition: .2s;
        }

        .btn-primary {
            background: #f2e5c5;
            color: #26372a;
        }

        .btn-secondary {
            border: 1px solid rgba(255,255,255,.7);
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        section {
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
            margin-bottom: 18px;
        }

        .about-content p {
            color: #697168;
            line-height: 1.8;
            margin-bottom: 15px;
        }

        .features {
            display: grid;
            grid-template-columns:
                repeat(3, 1fr);
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

        .rooms {
            background: #f7f5ef;
        }

        .card-grid {
            display: grid;
            grid-template-columns:
                repeat(auto-fit, minmax(260px, 1fr));
            gap: 22px;
        }

        .card {
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
            margin-bottom: 8px;
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
            grid-template-columns:
                repeat(3, 1fr);
            gap: 22px;
        }

        .service-card {
            background: white;
            padding: 30px;
            border-radius: 16px;
        }

        .service-card h3 {
            margin-bottom: 10px;
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
        }

        .contact h2 {
            font-size: 40px;
            margin-bottom: 15px;
        }

        .contact p {
            max-width: 650px;
            margin: 0 auto 28px;
            line-height: 1.7;
            color: #d6dfd3;
        }

        footer {
            padding: 27px 7%;
            background: #1b281e;
            color: #cdd6cb;
            display: flex;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }

        .empty {
            background: white;
            padding: 30px;
            border-radius: 14px;
            color: #777;
        }

        @media (max-width: 850px) {
            header {
                flex-direction: column;
            }

            nav {
                justify-content: center;
            }

            .about-grid,
            .service-grid {
                grid-template-columns: 1fr;
            }

            .features {
                grid-template-columns: 1fr;
            }

            .hero {
                min-height: 560px;
            }

            section {
                padding: 60px 5%;
            }
        }

        @media (max-width: 550px) {
            nav {
                gap: 13px;
            }

            .hero h1 {
                font-size: 42px;
            }

            .hero p {
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
        }
    </style>

</head>

<body>

<header>

    <a
        class="brand"
        href="{{ route('home', [], false) }}"
    >
        Gok Nauli
    </a>

    <nav>

        <a href="{{ route('home', [], false) }}">
            Home
        </a>

        <a href="{{ route('rooms.index', [], false) }}">
            Homestay
        </a>

        <a href="{{ route('menu.index', [], false) }}">
            Cafe & Resto
        </a>

        <a href="{{ route('reservations.create', [], false) }}">
            Reservasi
        </a>

        <a href="{{ route('cart.index', [], false) }}">
            Keranjang
        </a>

        <a href="#contact">
            Contact
        </a>

    </nav>

</header>


<section class="hero">

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
                class="btn btn-primary"
                href="{{ route('rooms.index', [], false) }}"
            >
                Pesan Kamar
            </a>

            <a
                class="btn btn-secondary"
                href="{{ route('menu.index', [], false) }}"
            >
                Lihat Menu
            </a>

        </div>

    </div>

</section>


<section class="about" id="about">

    <div class="about-grid">

        <div class="about-visual">
            Gok Nauli<br>
            Homestay Cafe & Resto
        </div>

        <div class="about-content">

            <span class="eyebrow"
                  style="color:#72806f">
                Tentang Kami
            </span>

            <h2>
                Nyaman untuk menginap, santai untuk menikmati.
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
                    <span>Kamar nyaman untuk beristirahat.</span>
                </div>

                <div class="feature">
                    <strong>Cafe & Resto</strong>
                    <span>Makanan, kopi, minuman dan camilan.</span>
                </div>

                <div class="feature">
                    <strong>Reservasi Online</strong>
                    <span>Pesan kamar dan meja lebih mudah.</span>
                </div>

            </div>

        </div>

    </div>

</section>


<section class="rooms">

    <div class="section-header">

        <span>Homestay</span>

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

                <article class="card">

                    <div class="card-image">

                        @if ($room->image)

                            <img
                                src="{{ asset('storage/' . $room->image) }}"
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
                                ?: ($room->roomType?->description
                                    ?: 'Kamar nyaman di Gok Nauli Homestay.') }}
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
                                href="{{ route('rooms.index', [], false) }}"
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
            class="btn"
            style="background:#31563a;color:white"
            href="{{ route('rooms.index', [], false) }}"
        >
            Lihat Semua Kamar
        </a>

    </div>

</section>


<section class="menu-section">

    <div class="section-header">

        <span>Cafe & Resto</span>

        <h2>
            Menu Pilihan
        </h2>

        <p>
            Nikmati pilihan makanan, minuman, kopi,
            dan camilan di Gok Nauli.
        </p>

    </div>


    @if ($menus->count())

        <div class="card-grid">

            @foreach ($menus as $menu)

                <article class="card menu-card">

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
            class="btn"
            style="background:#31563a;color:white"
            href="{{ route('menu.index', [], false) }}"
        >
            Lihat Semua Menu
        </a>

    </div>

</section>


<section class="services">

    <div class="section-header">

        <span>Layanan</span>

        <h2>
            Semua dalam satu tempat
        </h2>

    </div>

    <div class="service-grid">

        <div class="service-card">

            <h3>Pesan Kamar</h3>

            <p>
                Cek ketersediaan kamar dan lakukan booking
                Homestay secara online.
            </p>

            <a
                class="small-link"
                href="{{ route('rooms.index', [], false) }}"
            >
                Cari Kamar →
            </a>

        </div>


        <div class="service-card">

            <h3>Reservasi Meja</h3>

            <p>
                Rencanakan kunjungan ke Cafe & Resto
                dengan reservasi meja terlebih dahulu.
            </p>

            <a
                class="small-link"
                href="{{ route('reservations.create', [], false) }}"
            >
                Reservasi Meja →
            </a>

        </div>


        <div class="service-card">

            <h3>Pesan Makanan</h3>

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


<section
    class="contact"
    id="contact"
>

    <h2>
        Hubungi Gok Nauli
    </h2>

    <p>
        Ada pertanyaan mengenai kamar, reservasi,
        atau Cafe & Resto? Hubungi kami melalui WhatsApp.
    </p>

    @if (config('goknauli.whatsapp_number'))

        <a
            class="btn btn-primary"
            target="_blank"
            rel="noopener noreferrer"
            href="https://wa.me/{{ config('goknauli.whatsapp_number') }}"
        >
            Hubungi via WhatsApp
        </a>

    @endif

</section>


<footer>

    <div>
        <strong>
            Gok Nauli Homestay Cafe & Resto
        </strong>
    </div>

    <div>
        © {{ date('Y') }} Gok Nauli.
        All rights reserved.
    </div>

</footer>

</body>

</html>
