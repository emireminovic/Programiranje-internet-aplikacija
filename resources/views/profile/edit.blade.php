<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - BookCut</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <style>
        .page-wrapper {
            padding: 50px 0;
            background: #f7f7f7;
            min-height: calc(100vh - 140px);
        }

        .page-stack {
            max-width: 900px;
            margin: 0 auto;
            display: grid;
            gap: 20px;
        }

        .page-card {
            background: white;
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
        }

        .page-title {
            font-size: 30px;
            text-align: center;
            color: #111827;
            margin-bottom: 10px;
        }

        .section-title {
            font-size: 24px;
            color: #111827;
            margin-bottom: 20px;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #2563eb;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #111827;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"],
        .form-group input[type="file"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 15px;
            background: white;
        }

        .profile-preview {
            margin-bottom: 15px;
        }

        .profile-preview img {
            width: 130px;
            height: 130px;
            object-fit: cover;
            border-radius: 16px;
            border: 1px solid #ddd;
        }

        .profile-placeholder {
            width: 130px;
            height: 130px;
            border-radius: 16px;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-weight: bold;
        }

        .save-btn,
        .delete-btn {
            display: inline-block;
            border: none;
            padding: 12px 18px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
        }

        .save-btn {
            background: #111827;
            color: white;
        }

        .delete-btn {
            background: #dc2626;
            color: white;
        }

        .save-btn:hover,
        .delete-btn:hover {
            opacity: 0.95;
        }

        .success-msg {
            color: green;
            margin-bottom: 12px;
        }

        .error-msg {
            color: red;
            margin-top: 6px;
            font-size: 14px;
        }

        .helper-text {
            color: #4b5563;
            margin-bottom: 14px;
            line-height: 1.5;
        }
    </style>
</head>
<body>

<header class="site-header">
    <div class="container nav">
        <a href="{{ route('home') }}" class="logo">
    <img src="{{ asset('images/logo.png') }}" alt="BookCut logo">
    <span>BookCut</span>
</a>

        <nav>
            <a href="{{ route('home') }}">Početna</a>
            <a href="{{ route('frizeri.index') }}">Frizeri</a>
            <a href="{{ route('moj.profil') }}">Moj Profil</a>

            <form method="POST" action="{{ route('logout') }}" class="logout-form">
                @csrf
                <button type="submit">Izloguj se</button>
            </form>
        </nav>
    </div>
</header>

<section class="page-wrapper">
    <div class="container">
        <div class="page-stack">

            <div class="page-card">
                <a href="{{ route('moj.profil') }}" class="back-link">← Nazad na Moj Profil</a>
                <h1 class="page-title">Podešavanja profila</h1>
            </div>

            <!-- OSNOVNI PODACI + SLIKA -->
            <div class="page-card">
                <h2 class="section-title">Osnovni podaci</h2>

                @if (session('status') === 'profile-updated')
                    <p class="success-msg">Profil je uspešno ažuriran.</p>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label>Trenutna profilna slika</label>

                        @if(auth()->user()->slika)
                            <div class="profile-preview">
                                <img src="{{ asset('storage/' . auth()->user()->slika) }}" alt="Profilna slika">
                            </div>
                        @else
                            <div class="profile-preview">
                                <div class="profile-placeholder">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="slika">Nova profilna slika</label>
                        <input id="slika" name="slika" type="file">
                        @error('slika')
                            <div class="error-msg">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">Ime</label>
                        <input id="name" name="name" type="text" value="{{ old('name', auth()->user()->name) }}" required autofocus>
                        @error('name')
                            <div class="error-msg">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email', auth()->user()->email) }}" required>
                        @error('email')
                            <div class="error-msg">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="save-btn">Sačuvaj podatke</button>
                </form>
            </div>

            <!-- PROMENA LOZINKE -->
            <div class="page-card">
                <h2 class="section-title">Promena lozinke</h2>
                <p class="helper-text">
                    Unesite trenutnu lozinku i novu lozinku. Nova lozinka mora zadovoljiti pravila bezbednosti sistema. :contentReference[oaicite:1]{index=1}
                </p>

                @if (session('status') === 'password-updated')
                    <p class="success-msg">Lozinka je uspešno promenjena.</p>
                @endif

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="update_password_current_password">Trenutna lozinka</label>
                        <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password">
                        @if ($errors->updatePassword->get('current_password'))
                            <div class="error-msg">{{ $errors->updatePassword->get('current_password')[0] }}</div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="update_password_password">Nova lozinka</label>
                        <input id="update_password_password" name="password" type="password" autocomplete="new-password">
                        @if ($errors->updatePassword->get('password'))
                            <div class="error-msg">{{ $errors->updatePassword->get('password')[0] }}</div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="update_password_password_confirmation">Potvrdi novu lozinku</label>
                        <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password">
                        @if ($errors->updatePassword->get('password_confirmation'))
                            <div class="error-msg">{{ $errors->updatePassword->get('password_confirmation')[0] }}</div>
                        @endif
                    </div>

                    <button type="submit" class="save-btn">Promeni lozinku</button>
                </form>
            </div>

            <!-- BRISANJE NALOGA -->
            <div class="page-card">
                <h2 class="section-title">Brisanje naloga</h2>
                <p class="helper-text">
                    Ova akcija je trajna. Nakon brisanja naloga, svi povezani podaci mogu biti uklonjeni.
                </p>

                <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Da li ste sigurni da želite da obrišete svoj nalog?')">
                    @csrf
                    @method('DELETE')

                    <div class="form-group">
                        <label for="delete_password">Potvrdite lozinkom</label>
                        <input id="delete_password" name="password" type="password" placeholder="Unesite lozinku">
                        @if ($errors->userDeletion->get('password'))
                            <div class="error-msg">{{ $errors->userDeletion->get('password')[0] }}</div>
                        @endif
                    </div>

                    <button type="submit" class="delete-btn">Obriši nalog</button>
                </form>
            </div>

        </div>
    </div>
</section>

<footer class="site-footer">
    <div class="container">
        <p>BookCut &copy; 2026 - Sistem za povezivanje frizera i korisnika</p>
    </div>
</footer>

</body>
</html>