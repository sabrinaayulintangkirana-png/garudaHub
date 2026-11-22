<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Garuda Hub</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f3f4f6;
            font-family: Arial, sans-serif;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 35px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-bottom: 8px;
            text-align: center;
        }

        .subtitle {
            margin-bottom: 25px;
            color: #777;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border: 1px solid #ddd;
            border-radius: 7px;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 7px;
            background: #2563eb;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .error {
            margin-bottom: 15px;
            padding: 10px;
            color: #b91c1c;
            background: #fee2e2;
            border-radius: 6px;
        }

        .success {
            margin-bottom: 15px;
            padding: 10px;
            color: #166534;
            background: #dcfce7;
            border-radius: 6px;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <h1>Garuda Hub</h1>
        <p class="subtitle">Silakan login ke akun Anda</p>

        @if (session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="error">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.process') }}" method="POST">
            @csrf

            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Masukkan email"
                required
                autofocus
            >

            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="Masukkan password"
                required
            >

            <button type="submit">Login</button>
        </form>
    </div>

</body>
</html>