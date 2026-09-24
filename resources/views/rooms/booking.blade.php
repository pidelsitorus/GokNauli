<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Booking {{ $room->name }} - Gok Nauli</title>

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
            padding: 20px 8%;
        }

        header a {
            color: white;
            text-decoration: none;
        }

        .container {
            width: 90%;
            max-width: 800px;
            margin: 50px auto;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0,0,0,.08);
        }

        .room-info {
            background: #f2f5ef;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
        }

        .room-info h2 {
            margin-top: 0;
        }

        .price {
            font-size: 22px;
            font-weight: bold;
            color: #355b3e;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        textarea {
            min-height: 100px;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .summary {
            background: #edf5ea;
            border: 1px solid #cbdcc6;
            border-radius: 10px;
            padding: 18px;
            margin: 20px 0;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .summary-total {
            font-size: 22px;
            font-weight: bold;
            color: #355b3e;
            border-top: 1px solid #cbdcc6;
            padding-top: 12px;
            margin-top: 12px;
        }

        button {
            width: 100%;
            padding: 14px;
            border: 0;
            border-radius: 8px;
            background: #355b3e;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .error {
            color: #b3261e;
            font-size: 14px;
            margin-top: 5px;
        }

        @media (max-width: 650px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<header>
    <a href="{{ route('rooms.index', [], false) }}">
        ← Kembali ke daftar kamar
    </a>
</header>

<div class="container">

    <div class="card">

        <div class="room-info">

            <h2>{{ $room->name }}</h2>

            <p>{{ $room->roomType->name }}</p>

            <p>
                Kapasitas:
                {{ $room->roomType->capacity }} tamu
            </p>

            <div class="price">
                Rp {{ number_format($room->price ?? $room->roomType->base_price, 0, ',', '.') }}
                / malam
            </div>

        </div>

        <h1>Booking Kamar</h1>

        <form method="POST"
              action="{{ route('rooms.booking.store', $room, false) }}">

            @csrf

            <div class="form-group">
                <label>Nama Tamu</label>

                <input
                    type="text"
                    name="guest_name"
                    value="{{ old('guest_name') }}"
                    required
                >

                @error('guest_name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="grid">

                <div class="form-group">
                    <label>Nomor WhatsApp / Telepon</label>

                    <input
                        type="text"
                        name="guest_phone"
                        value="{{ old('guest_phone') }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>Email</label>

                    <input
                        type="email"
                        name="guest_email"
                        value="{{ old('guest_email') }}"
                    >
                </div>

            </div>

            <div class="grid">

                <div class="form-group">
                    <label>Check-in</label>

                    <input
                        id="check_in"
                        type="date"
                        name="check_in"
                        value="{{ old('check_in', $checkIn ?? '') }}"
                        min="{{ date('Y-m-d') }}"
                        required
                    >

                    @error('check_in')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Check-out</label>

                    <input
                        id="check_out"
                        type="date"
                        name="check_out"
                        value="{{ old('check_out', $checkOut ?? '') }}"
                        min="{{ date('Y-m-d') }}"
                        required
                    >

                    @error('check_out')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="summary">

                <div class="summary-row">
                    <span>Harga per malam</span>

                    <strong>
                        Rp {{ number_format(
                            $room->price ?? $room->roomType->base_price,
                            0,
                            ',',
                            '.'
                        ) }}
                    </strong>
                </div>

                <div class="summary-row">
                    <span>Durasi</span>

                    <strong>
                        <span id="total-nights">0</span> malam
                    </strong>
                </div>

                <div class="summary-row summary-total">
                    <span>Total</span>

                    <span id="total-price">
                        Rp 0
                    </span>
                </div>

            </div>

            <div class="grid">

                <div class="form-group">
                    <label>Dewasa</label>

                    <input
                        type="number"
                        name="adults"
                        value="{{ old('adults', 1) }}"
                        min="1"
                        required
                    >
                </div>

                <div class="form-group">
                    <label>Anak-anak</label>

                    <input
                        type="number"
                        name="children"
                        value="{{ old('children', 0) }}"
                        min="0"
                    >
                </div>

            </div>

            <div class="form-group">

                <label>Catatan</label>

                <textarea name="notes">{{ old('notes') }}</textarea>

            </div>

            <button type="submit">
                Konfirmasi Booking
            </button>

        </form>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const checkInInput =
        document.getElementById('check_in');

    const checkOutInput =
        document.getElementById('check_out');

    const nightsElement =
        document.getElementById('total-nights');

    const totalElement =
        document.getElementById('total-price');

    const pricePerNight =
        Number(@json((float) ($room->price ?? $room->roomType->base_price)));

    function calculateTotal() {

        const checkInValue =
            checkInInput.value;

        const checkOutValue =
            checkOutInput.value;

        if (!checkInValue || !checkOutValue) {

            nightsElement.textContent = '0';
            totalElement.textContent = 'Rp 0';

            return;
        }

        const checkIn =
            new Date(checkInValue + 'T00:00:00');

        const checkOut =
            new Date(checkOutValue + 'T00:00:00');

        const millisecondsPerDay =
            1000 * 60 * 60 * 24;

        const nights =
            Math.round(
                (checkOut - checkIn) /
                millisecondsPerDay
            );

        if (nights <= 0) {

            nightsElement.textContent = '0';
            totalElement.textContent = 'Rp 0';

            return;
        }

        const total =
            nights * pricePerNight;

        nightsElement.textContent =
            nights;

        totalElement.textContent =
            'Rp ' + new Intl.NumberFormat('id-ID')
                .format(total);
    }

    checkInInput.addEventListener(
        'change',
        calculateTotal
    );

    checkOutInput.addEventListener(
        'change',
        calculateTotal
    );

    calculateTotal();

});
</script>

</body>
</html>
