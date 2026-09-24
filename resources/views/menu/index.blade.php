@extends('layouts.public')

@section('title', 'Cafe & Resto - Gok Nauli')

@section(
    'description',
    'Nikmati pilihan makanan, minuman, kopi, dan camilan di Gok Nauli Cafe & Resto.'
)

@section('styles')
<style>
    .menu-hero {
        padding: 80px 20px;
        text-align: center;
        background: #e8ecdf;
    }

    .menu-hero span {
        display: inline-block;
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-size: 13px;
        color: #66735f;
    }

    .menu-hero h1 {
        font-size: 46px;
        margin: 0 0 15px;
    }

    .menu-hero p {
        max-width: 650px;
        margin: auto;
        color: #657064;
        line-height: 1.7;
        font-size: 17px;
    }

    .category-nav {
        background: white;
        padding: 18px 5%;
        display: flex;
        justify-content: center;
        gap: 12px;
        flex-wrap: wrap;
        position: sticky;
        top: 76px;
        z-index: 50;
        box-shadow: 0 3px 15px rgba(0,0,0,.04);
    }

    .category-nav a {
        text-decoration: none;
        color: #31563a;
        background: #edf1e8;
        padding: 9px 16px;
        border-radius: 30px;
        font-size: 14px;
    }

    .menu-main {
        width: 88%;
        max-width: 1200px;
        margin: 50px auto;
    }

    .category {
        margin-bottom: 65px;
        scroll-margin-top: 150px;
    }

    .category-heading {
        margin-bottom: 25px;
    }

    .category-heading h2 {
        font-size: 32px;
        margin: 0 0 8px;
    }

    .category-heading p {
        color: #71786e;
        margin: 0;
    }

    .menu-grid {
        display: grid;
        grid-template-columns:
            repeat(auto-fit, minmax(270px, 1fr));
        gap: 22px;
    }

    .menu-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 7px 25px rgba(0,0,0,.06);
        transition: transform .2s;
    }

    .menu-card:hover {
        transform: translateY(-3px);
    }

    .menu-image {
        height: 180px;
        background: #dde3d7;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #798176;
        overflow: hidden;
    }

    .menu-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .menu-content {
        padding: 20px;
    }

    .menu-top {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        align-items: flex-start;
    }

    .menu-top h3 {
        margin: 0;
        font-size: 20px;
    }

    .price {
        color: #31563a;
        font-weight: bold;
        white-space: nowrap;
    }

    .description {
        color: #71786e;
        margin-top: 10px;
        line-height: 1.6;
        min-height: 48px;
    }

    .status {
        display: inline-block;
        margin-top: 16px;
        padding: 6px 11px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
    }

    .available {
        color: #28723c;
        background: #e7f4e9;
    }

    .unavailable {
        color: #a13b34;
        background: #fbe9e7;
    }

    .order-button {
        width: 100%;
        margin-top: 12px;
        padding: 11px;
        border: 0;
        border-radius: 8px;
        background: #31563a;
        color: white;
        cursor: pointer;
        font-size: 14px;
        font-weight: bold;
    }

    .order-button:hover {
        background: #26462e;
    }

    .order-button:disabled {
        background: #aaa;
        cursor: not-allowed;
    }

    .empty {
        background: white;
        border-radius: 12px;
        padding: 30px;
        color: #777;
    }

    .menu-cta {
        background: #26372a;
        color: white;
        text-align: center;
        padding: 55px 20px;
    }

    .menu-cta h2 {
        font-size: 30px;
        margin: 0 0 12px;
    }

    .menu-cta p {
        color: #d4ddd1;
        margin: 0 0 25px;
    }

    .menu-cta-actions {
        display: flex;
        justify-content: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    @media (max-width: 850px) {
        .category-nav {
            top: 115px;
        }
    }

    @media (max-width: 700px) {
        .menu-hero h1 {
            font-size: 34px;
        }

        .menu-main {
            width: 92%;
        }

        .menu-top {
            flex-direction: column;
        }

        .category-nav {
            position: static;
        }
    }
</style>
@endsection


@section('content')

<section class="menu-hero">

    <span>
        Gok Nauli
    </span>

    <h1>
        Cafe & Resto
    </h1>

    <p>
        Nikmati pilihan makanan, minuman, kopi,
        dan camilan dalam suasana nyaman di Gok Nauli.
    </p>

</section>


@if ($categories->count())

    <div class="category-nav">

        @foreach ($categories as $category)

            <a href="#category-{{ $category->slug }}">
                {{ $category->name }}
            </a>

        @endforeach

    </div>

@endif


<main class="menu-main">

    @forelse ($categories as $category)

        <section
            class="category"
            id="category-{{ $category->slug }}"
        >

            <div class="category-heading">

                <h2>
                    {{ $category->name }}
                </h2>

                @if ($category->description)

                    <p>
                        {{ $category->description }}
                    </p>

                @endif

            </div>


            @if ($category->menus->count())

                <div class="menu-grid">

                    @foreach ($category->menus as $menu)

                        <article class="menu-card">

                            <div class="menu-image">

                                @if ($menu->image)

                                    <img
                                        src="{{ asset(
                                            'storage/' . $menu->image
                                        ) }}"
                                        alt="{{ $menu->name }}"
                                    >

                                @else

                                    Foto {{ $menu->name }}

                                @endif

                            </div>


                            <div class="menu-content">

                                <div class="menu-top">

                                    <h3>
                                        {{ $menu->name }}
                                    </h3>

                                    <div class="price">

                                        Rp {{ number_format(
                                            $menu->price,
                                            0,
                                            ',',
                                            '.'
                                        ) }}

                                    </div>

                                </div>


                                @if ($menu->description)

                                    <p class="description">
                                        {{ $menu->description }}
                                    </p>

                                @endif


                                @if ($menu->is_available)

                                    <span class="status available">
                                        Available
                                    </span>

                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'cart.add',
                                            $menu,
                                            false
                                        ) }}"
                                    >

                                        @csrf

                                        <input
                                            type="hidden"
                                            name="quantity"
                                            value="1"
                                        >

                                        <button
                                            class="order-button"
                                            type="submit"
                                        >
                                            + Tambah ke Pesanan
                                        </button>

                                    </form>

                                @else

                                    <span class="status unavailable">
                                        Habis
                                    </span>

                                    <button
                                        class="order-button"
                                        type="button"
                                        disabled
                                    >
                                        Tidak Tersedia
                                    </button>

                                @endif

                            </div>

                        </article>

                    @endforeach

                </div>

            @else

                <div class="empty">
                    Belum ada menu untuk kategori ini.
                </div>

            @endif

        </section>

    @empty

        <div class="empty">
            Menu Cafe & Resto belum tersedia.
        </div>

    @endforelse

</main>


<section class="menu-cta">

    <h2>
        Berencana makan di Gok Nauli?
    </h2>

    <p>
        Reservasi meja terlebih dahulu atau langsung
        pilih menu untuk pesanan Dine In dan Takeaway.
    </p>

    <div class="menu-cta-actions">

        <a
            class="btn btn-light"
            href="{{ route('reservations.create', [], false) }}"
        >
            Reservasi Meja
        </a>

        <a
            class="btn"
            style="
                border:1px solid white;
                color:white;
            "
            href="{{ route('cart.index', [], false) }}"
        >
            Lihat Keranjang
        </a>

    </div>

</section>

@endsection
