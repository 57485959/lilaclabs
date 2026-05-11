<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Dadi Madu</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            min-height: 100vh;
            background: #5c3d1e;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
            padding: 20px;
        }
        .login-wrap {
            width: 100%;
            max-width: 380px;
        }
        .login-card {
            background: #fff;
            border-radius: 24px;
            padding: 36px 32px;
            box-shadow: 0 20px 60px rgba(0,0,0,.25);
        }
        .logo-area {
            text-align: center;
            margin-bottom: 28px;
        }
        .logo-icon {
            font-size: 56px;
            display: block;
            margin-bottom: 8px;
        }
        .logo-area h2 {
            font-size: 22px;
            font-weight: 700;
            color: #3d2b1a;
            margin-bottom: 4px;
        }
        .logo-area p {
            font-size: 13px;
            color: #9b8878;
        }
        .form-group {
            margin-bottom: 18px;
        }
        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #3d2b1a;
            margin-bottom: 6px;
        }
        .form-group input {
            width: 100%;
            border: 1.5px solid #e8ddd5;
            border-radius: 12px;
            padding: 11px 14px;
            font-size: 14px;
            color: #3d2b1a;
            background: #fdf8f4;
            transition: border .2s;
            outline: none;
        }
        .form-group input::placeholder { color: #c4b5a8; }
        .form-group input:focus { border-color: #f59e0b; background: #fff; }
        .btn-login {
            width: 100%;
            background: #f59e0b;
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 13px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 8px;
            transition: background .2s;
        }
        .btn-login:hover { background: #d97706; }
        .error-msg {
            background: #fee2e2;
            color: #991b1b;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 13px;
            margin-bottom: 16px;
        }
        .footer-text {
            text-align: center;
            font-size: 12px;
            color: #c4b5a8;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="login-wrap">
    <div class="login-card">
        <div class="logo-area">
            <span class="logo-icon">🐝</span>
            <h2>Dadi Madu</h2>
            <p>Sistem Pencatatan Bisnis Madu</p>
        </div>

        @if($errors->any())
            <div class="error-msg">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Pengguna</label>
                <input type="text" name="username" placeholder="nama pengguna"
                       value="{{ old('username') }}" required autofocus>
            </div>
            <div class="form-group">
                <label>Kata Sandi</label>
                <input type="password" name="password" placeholder="kata sandi" required>
            </div>
            <button type="submit" class="btn-login">Masuk ke Sistem</button>
        </form>

        <p class="footer-text">Dadi Madu © {{ date('Y') }} — Lilac Labs</p>
    </div>
</div>
</body>
</html>
