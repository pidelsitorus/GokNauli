<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Tambah Fasilitas - Gok Nauli</title>

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
            max-width: 950px;
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
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 7px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #d5d9d3;
            border-radius: 8px;
        }

        textarea {
            min-height: 100px;
        }

        .checkbox {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .checkbox input {
            width: auto;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .btn {
            background: #31563a;
            color: white;
            padding: 11px 16px;
            border-radius: 8px;
            border: 0;
            text-decoration: none;
            cursor: pointer;
        }

        .secondary {
            background: #e8ece6;
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

    <h1>Tambah Fasilitas</h1>

    <p>
        Daftarkan aset Homestay atau Cafe & Resto.
    </p>


    <div class="card">

        <form
            method="POST"
            action="{{ route(
                'admin.facilities.store',
                [],
                false
            ) }}"
        >

            @csrf

            @include('admin.facilities._form')


            <div class="actions">

                <button
                    class="btn"
                    type="submit"
                >
                    Simpan Aset
                </button>

                <a
                    class="btn secondary"
                    href="{{ route(
                        'admin.facilities.index',
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
