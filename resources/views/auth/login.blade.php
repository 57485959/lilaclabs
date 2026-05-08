<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Dadi Madu</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        body { background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; font-family: 'Segoe UI', sans-serif; }
        .login-card { background: #fff; border-radius: 20px; padding: 40px; width: 100%; max-width: 400px; box-shadow: 0 20px 60px rgba(0,0,0,.3); }
        .login-logo { text-align: center; margin-bottom: 28px; }
        .login-logo .emoji { font-size: 52px; display: block; }
        .login-logo h4 { font-weight: 700; color: #1a1a2e; margin: 8px 0 2px; font-size: 22px; }
        .login-logo p { color: #6c757d; font-size: 13px; margin: 0; }
        .form-label { font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 5px; }
        .form-control { border-radius: 10px; border: 1.5px solid #e5e7eb; padding: 10px 14px; font-size: 14px; transition: border .2s; }
        .form-control:focus { border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245,158,11,.15); outline: none; }
        .btn-login { background: #f59e0b; color: #fff; border: none; border-radius: 10px; padding: 12px; font-weight: 600; font-size: 15px; width: 100%; cursor: pointer; transition: background .2s; }
        .btn-login:hover { background: #d97706; }
        .alert-danger { background: #fee2e2; border: none; color: #991b1b; border-radius: 10px; font-size: 13px; padding: 10px 14px; margin-bottom: 16px; }
        .divider { text-align: center; color: #9ca3af; font-size: 12px; margin-top: 20px; }
    </style>
</head>
<body>
<div class="login-card">
    <div class="login-logo">
        <span class="emoji">🍯</span>
        <h4>Dadi Madu</h4>
        <p>Sistem Pencatatan Bisnis Madu</p>
    </div>

    @if($errors->any())
        <div class="alert-danger">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control"
                   placeholder="Masukkan username"
                   value="{{ old('username') }}" required autofocus>
        </div>
        <div class="mb-4">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control"
                   placeholder="••••••••" required>
        </div>
        <button type="submit" class="btn-login">Masuk ke Sistem</button>
    </form>

    <div class="divider">Dadi Madu © {{ date('Y') }} — Lilac Labs</div>
</div>
</body>
</html>
