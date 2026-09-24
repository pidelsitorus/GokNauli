<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login - Gok Nauli</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            background: #f4f2ea;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #293229;
        }

        .login {
            width: 90%;
            max-width: 430px;
            background: white;
            padding: 38px;
            border-radius: 18px;
            box-shadow: 0 12px 40px rgba(0,0,0,.10);
        }

        .brand {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand h1 {
            color: #31563a;
            margin-bottom: 8px;
        }

        .brand p {
            color: #777;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 13px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        .remember {
            display: flex;
            gap: 8px;
            align-items: center;
            margin-bottom: 20px;
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
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

<div class="login">

    <div class="brand">
        <h1>Gok Nauli</h1>
        <p>Administrator Dashboard</p>
    </div>

    @if ($errors->any())
        <div class="error">
            {{ $errors->first() }}
        </div>
    @endif

    <form
        method="POST"
        action="{{ route('admin.login.submit', [], false) }}"
    >
        @csrf

        <div class="form-group">
            <label>Email</label>

            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
            >
        </div>

        <div class="form-group">
            <label>Password</label>

            <input
                type="password"
                name="password"
                required
            >
        </div>

        <label class="remember">
            <input type="checkbox" name="remember">
            Ingat saya
        </label>

        <button type="submit">
            Login Administrator
        </button>

    </form>

</div>

</body>
</html>
