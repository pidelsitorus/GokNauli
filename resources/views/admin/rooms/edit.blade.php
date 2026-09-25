<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit {{ $room->name }} - Gok Nauli</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f5f1;
            color: #293229;
        }

        header {
            background: #26372a;
            color: white;
            padding: 18px 5%;
        }

        header a {
            color: white;
            text-decoration: none;
        }

        main {
            width: 90%;
            max-width: 850px;
            margin: 40px auto;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 6px 25px rgba(0,0,0,.06);
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
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        textarea {
            min-height: 120px;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 20px 0;
        }

        .checkbox input {
            width: auto;
        }

        button {
            width: 100%;
            border: 0;
            padding: 14px;
            border-radius: 8px;
            background: #31563a;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .error {
            background: #fdebea;
            color: #a12822;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        @media (max-width: 650px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

@include('admin.partials.header')

<header>
    <a href="{{ route('admin.rooms.index', [], false) }}">
        ← Kembali ke Room Management
    </a>
</header>

<main>

    <div class="card">

        <h1>Edit Kamar</h1>

        <p>
            {{ $room->room_number }} —
            {{ $room->name }}
        </p>

        <form
            method="POST"
            enctype="multipart/form-data"
            action="{{ route('admin.rooms.update', $room, false) }}"
        >
            @method('PUT')

            @include('admin.rooms._form')

        </form>

    </div>

</main>

</body>
</html>
