<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registracija - BookCut</title>
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
            max-width: 520px;
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

        .auth-group input[type="text"],
        .auth-group input[type="email"],
        .auth-group input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 15px;
        }

        .auth-radio-group {
            margin-top: 8px;
        }

        .auth-radio-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: normal;
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

        .auth-links a {
            color: #2563eb;
            text-decoration: none;
        }

        .auth-links a:hover {
            text-decoration: underline;
        }

        .auth-error {
            color: #dc2626;
            font-size: 14px;
            margin-top: 6px;
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
            <h1>Registracija</h1>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="auth-group">
                    <label for="name">Ime</label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        autocomplete="name"
                    >
                    @if ($errors->get('name'))
                        <div class="auth-error">{{ $errors->get('name')[0] }}</div>
                    @endif
                </div>

                <div class="auth-group">
                    <label for="email">Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
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
                        autocomplete="new-password"
                    >
                    @if ($errors->get('password'))
                        <div class="auth-error">{{ $errors->get('password')[0] }}</div>
                    @endif
                </div>

                <div class="auth-group">
                    <label for="password_confirmation">Potvrdi lozinku</label>
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                    >
                    @if ($errors->get('password_confirmation'))
                        <div class="auth-error">{{ $errors->get('password_confirmation')[0] }}</div>
                    @endif
                </div>

                <div class="auth-group">
                    <label>Tip naloga</label>

                    <div class="auth-radio-group">
                        <label>
                            <input type="radio" name="role" value="korisnik" {{ old('role', 'korisnik') == 'korisnik' ? 'checked' : '' }}>
                            Korisnik
                        </label>

                        <label>
                            <input type="radio" name="role" value="frizer" {{ old('role') == 'frizer' ? 'checked' : '' }}>
                            Frizer
                        </label>
                    </div>

                    @if ($errors->get('role'))
                        <div class="auth-error">{{ $errors->get('role')[0] }}</div>
                    @endif
                </div>

                <div style="margin-top: 22px;">
                    <button type="submit" class="auth-btn">Registruj se</button>
                </div>

                <div class="auth-links">
                    Već imaš nalog?
                    <a href="{{ route('login') }}">Prijavi se</a>
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