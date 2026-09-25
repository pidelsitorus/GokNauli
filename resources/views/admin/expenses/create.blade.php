<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Tambah Pengeluaran - Gok Nauli
    </title>

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
            border-radius: 14px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .full {
            grid-column: 1 / -1;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 7px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #d3d8d1;
            border-radius: 8px;
        }

        .actions {
            margin-top: 22px;
        }

        .btn {
            display: inline-block;
            padding: 11px 16px;
            border: 0;
            border-radius: 8px;
            background: #31563a;
            color: white;
            text-decoration: none;
            cursor: pointer;
        }

        .secondary {
            background: #6b726b;
        }

        .errors {
            background: #fdebea;
            padding: 14px;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        @media (max-width: 700px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .full {
                grid-column: auto;
            }
        }
    </style>
</head>

<body>

@include('admin.partials.header')

<main>

    <h1>Tambah Pengeluaran</h1>

    <p>
        Catat pengeluaran umum usaha yang tidak berasal
        dari Inventory atau Facilities.
    </p>


    @if ($errors->any())

        <div class="errors">

            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach

        </div>

    @endif


    <div class="card">

        <form
            method="POST"
            action="{{ route(
                'admin.expenses.store',
                [],
                false
            ) }}"
        >

            @csrf

            @include('admin.expenses._form')


            <div class="actions">

                <button
                    type="submit"
                    class="btn"
                >
                    Simpan Pengeluaran
                </button>

                <a
                    class="btn secondary"
                    href="{{ route(
                        'admin.expenses.index',
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
