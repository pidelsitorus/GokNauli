<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Gok Nauli Homestay Cafe & Resto')
    </title>

    <meta
        name="description"
        content="@yield('description', 'Gok Nauli Homestay Cafe & Resto')"
    >

    <style>
        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f7f5ef;
            color: #283029;
        }

        a {
            text-decoration: none;
        }

        .site-header {
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

        .site-brand {
            color: white;
            font-size: 24px;
            font-weight: bold;
            white-space: nowrap;
        }

        .site-nav {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .site-nav a {
            color: white;
            font-size: 14px;
        }

        .site-nav a:hover {
            opacity: .8;
        }

        .site-nav .active {
            font-weight: bold;
            border-bottom: 2px solid #f2e5c5;
            padding-bottom: 5px;
        }

        .site-footer {
            background: #1b281e;
            color: #cdd6cb;
            padding: 28px 7%;
            display: flex;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 13px 20px;
            border-radius: 8px;
            font-weight: bold;
        }

        .btn-primary {
            background: #31563a;
            color: white;
        }

        .btn-light {
            background: #f2e5c5;
            color: #26372a;
        }

        @media (max-width: 850px) {
            .site-header {
                flex-direction: column;
            }

            .site-nav {
                justify-content: center;
            }
        }

        @media (max-width: 550px) {
            .site-nav {
                gap: 12px;
            }
        }
    </style>

    @yield('styles')

</head>

<body>

<header class="site-header">

    <a
        class="site-brand"
        href="{{ route('home', [], false) }}"
    >
        Gok Nauli
    </a>

    <nav class="site-nav">

        <a
            href="{{ route('home', [], false) }}"
            class="{{ request()->routeIs('home') ? 'active' : '' }}"
        >
            Home
        </a>

        <a
            href="{{ route('rooms.index', [], false) }}"
            class="{{ request()->routeIs('rooms.*') ? 'active' : '' }}"
        >
            Homestay
        </a>

        <a
            href="{{ route('menu.index', [], false) }}"
            class="{{ request()->routeIs('menu.*') ? 'active' : '' }}"
        >
            Cafe & Resto
        </a>

        <a
            href="{{ route('reservations.create', [], false) }}"
            class="{{ request()->routeIs('reservations.*') ? 'active' : '' }}"
        >
            Reservasi
        </a>

        <a
            href="{{ route('cart.index', [], false) }}"
            class="{{ request()->routeIs('cart.*') ? 'active' : '' }}"
        >
            Keranjang
        </a>

        <a href="{{ route('home', [], false) }}#contact">
            Contact
        </a>

    </nav>

</header>

@yield('content')

<footer class="site-footer">

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

@stack('scripts')

</body>

</html>
