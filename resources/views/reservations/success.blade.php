@extends('layouts.public')

@section('title', 'Reservasi Berhasil - Gok Nauli')

@section('styles')
<style>
    .success-main {
        width: 90%;
        max-width: 700px;
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
        margin-bottom: 10px;
    }

    .success-intro {
        text-align: center;
        color: #70776f;
        line-height: 1.6;
    }

    .reservation-code {
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
        background: #fff4d6;
        color: #856311;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
    }

    .actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-top: 28px;
    }

    .action-button {
        text-align: center;
        padding: 13px;
        border-radius: 8px;
        font-weight: bold;
    }

    .menu-button {
        background: #31563a;
        color: white;
    }

    .home-button {
        background: #eef3e9;
        color: #31563a;
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
            Reservasi Berhasil Dibuat
        </h1>

        <p class="success-intro">
            Reservasi Anda sudah masuk dan sedang
            menunggu konfirmasi dari Gok Nauli.
        </p>


        <div class="reservation-code">
            {{ $reservation->reservation_code }}
        </div>


        <div class="detail-row">

            <span>Nama</span>

            <strong>
                {{ $reservation->guest_name }}
            </strong>

        </div>


        <div class="detail-row">

            <span>Tanggal</span>

            <strong>
                {{ $reservation->reservation_date->format('d M Y') }}
            </strong>

        </div>


        <div class="detail-row">

            <span>Waktu</span>

            <strong>
                {{ substr(
                    $reservation->reservation_time,
                    0,
                    5
                ) }}
            </strong>

        </div>


        <div class="detail-row">

            <span>Jumlah Tamu</span>

            <strong>
                {{ $reservation->guests }} orang
            </strong>

        </div>


        <div class="detail-row">

            <span>Meja</span>

            <strong>
                {{ $reservation
                    ->restaurantTable
                    ?->table_number ?? '-' }}
            </strong>

        </div>


        <div class="detail-row">

            <span>Lokasi</span>

            <strong>
                {{ $reservation
                    ->restaurantTable
                    ?->location ?? '-' }}
            </strong>

        </div>


        <div class="detail-row">

            <span>Status</span>

            <strong class="status">
                {{ ucfirst($reservation->status) }}
            </strong>

        </div>


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
                Lihat Cafe & Resto
            </a>

        </div>

    </div>

</main>

@endsection
