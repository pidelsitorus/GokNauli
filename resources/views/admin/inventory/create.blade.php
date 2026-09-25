<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Tambah Inventory - Gok Nauli</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f5f1;
            color: #293229;
        }

        main {
            width: 94%;
            max-width: 900px;
            margin: 35px auto;
        }

        .card {
            background: white;
            padding: 28px;
            border-radius: 14px;
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
        }

        .form-grid {
            display: grid;
            grid-template-columns:
                repeat(2, 1fr);
            gap: 18px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
            font-size: 13px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #d5d9d3;
            border-radius: 8px;
            font-family: inherit;
        }

        textarea {
            min-height: 100px;
        }

        .checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .checkbox input {
            width: auto;
        }

        .actions {
            margin-top: 25px;
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 11px 16px;
            border: 0;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            background: #31563a;
            color: white;
        }

        .btn-secondary {
            background: #e9ece7;
            color: #293229;
        }

        .error-box {
            background: #fdebea;
            color: #a12822;
            padding: 15px;
            border-radius: 9px;
            margin-bottom: 20px;
        }

        @media (max-width: 700px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

@include('admin.partials.header')

<main>

    <h1>Tambah Barang</h1>

    <p>
        Tambahkan barang atau bahan baru
        ke inventory Gok Nauli.
    </p>


    <div class="card">

        <form
            method="POST"
            action="{{ route(
                'admin.inventory.store',
                [],
                false
            ) }}"
        >
            @csrf

            @include('admin.inventory._form')


            <div class="actions">

                <button
                    class="btn"
                    type="submit"
                >
                    Simpan Barang
                </button>

                <a
                    class="btn btn-secondary"
                    href="{{ route(
                        'admin.inventory.index',
                        [],
                        false
                    ) }}"
                >
                    Kembali
                </a>

            </div>

        </form>

    </div>

</main>

</body>

</html>
