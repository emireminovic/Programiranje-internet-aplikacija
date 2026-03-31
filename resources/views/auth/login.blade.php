<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prijava - BookCut</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <style>
        .auth-section {
            min-height: calc(100vh - 140px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 20px;
            background: #f7f7f7;
        }

        .auth-card {
            width: 100%;
            max-width: 460px;
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
        }

        .auth-card h1 {
            text-align: center;
            margin-bottom: 25px;
            color: #111827;
        }

        .auth-group {
            margin-bottom: 18px;
        }

        .auth-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #111827;
        }

        .auth-group input[type="email"],
        .auth-group input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 15px;
        }

        .auth-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-top: 10px;
            flex-wrap: wrap;
        }

        .auth-check {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #111827;
        }

        .auth-btn {
            background: #111827;
            color: white;
            border: none;
            padding: 12px 18px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
        }

        .auth-btn:hover {
            opacity: 0.95;
        }

        .auth-links {
            margin-top: 18px;
            text-align: center;
        }

        .auth-links a,
        .auth-row a {
            color: #2563eb;
            text-decoration: none;
        }

        .auth-links a:hover,
        .auth-row a:hover {
            text-decoration: underline;
        }

        .auth-error {
            color: #dc2626;
            font-size: 14px;
            margin-top: 6px;
        }

        .auth-status {
            background: #dcfce7;
            color: #166534;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 18px;
        }
    </style>
</head>
<body>

    <header class="site-header">
        <div class="container nav">
            <div class="logo">BookCut</div>

            <nav>
                <a href="{{ route('home') }}">Početna</a>
                <a href="{{ route('frizeri.index') }}">Frizeri</a>
                <a href="{{ route('login') }}">Prijava</a>
                <a href="{{ route('register') }}" class="btn-nav">Registracija</a>
            </nav>
        </div>
    </header>

    <section class="auth-section">
        <div class="auth-card">
            <h1>Prijava</h1>

            @if (session('status'))
                <div class="auth-status">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="auth-group">
                    <label for="email">Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                    >
                    @if ($errors->get('email'))
                        <div class="auth-error">{{ $errors->get('email')[0] }}</div>
                    @endif
                </div>

                <div class="auth-group">
                    <label for="password">Lozinka</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                    >
                    @if ($errors->get('password'))
                        <div class="auth-error">{{ $errors->get('password')[0] }}</div>
                    @endif
                </div>

                <div class="auth-row">
                    <label class="auth-check" for="remember_me">
                        <input id="remember_me" type="checkbox" name="remember">
                        <span>Zapamti me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Zaboravljena lozinka?</a>
                    @endif
                </div>

                <div style="margin-top: 22px;">
                    <button type="submit" class="auth-btn">Prijava</button>
                </div>

                <div class="auth-links">
                    Nemaš nalog?
                    <a href="{{ route('register') }}">Registruj se</a>
                </div>
            </form>
        </div>
    </section>

    <footer class="site-footer">
        <div class="container">
            <p>BookCut &copy; 2026 - Sistem za povezivanje frizera i korisnika</p>
        </div>
    </footer>

</body>
</html>