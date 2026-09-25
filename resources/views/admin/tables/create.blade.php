<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Tambah Meja - Gok Nauli</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f5f1;
            color: #293229;
        }

        main {
            width: 90%;
            max-width: 800px;
            margin: 45px auto;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 16px;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
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
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        .checkbox {
            display: flex;
            gap: 8px;
            margin: 20px 0;
        }

        .checkbox input {
            width: auto;
        }

        button {
            width: 100%;
            padding: 14px;
            border: 0;
            background: #31563a;
            color: white;
            border-radius: 8px;
            cursor: pointer;
        }

        .error {
            background: #fdebea;
            padding: 15px;
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

<main>

    <div class="card">

        <h1>Tambah Meja</h1>

        <p>
            Tambahkan meja baru untuk Cafe & Resto Gok Nauli.
        </p>

        <form
            method="POST"
            action="{{ route('admin.tables.store', [], false) }}"
        >

            @include('admin.tables._form')

        </form>

    </div>

</main>

</body>
</html>
