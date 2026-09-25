<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Menu - Gok Nauli</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f5f1;
        }

        main {
            width: 90%;
            max-width: 800px;
            margin: 40px auto;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 16px;
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
            gap: 8px;
            margin: 15px 0;
        }

        .checkbox input {
            width: auto;
        }

        button {
            width: 100%;
            border: 0;
            padding: 14px;
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
    </style>
</head>

<body>

    <main>

        <div class="card">

            <h1>Edit Menu</h1>

            <form
                method="POST"
                enctype="multipart/form-data"
                action="{{ route('admin.menus.update', $menu, false) }}">
                @method('PUT')

                @include('admin.menus._form')
            </form>

        </div>

    </main>

</body>

</html>