<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uredi profil - BookCut</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <style>
        .edit-wrapper {
            padding: 50px 0;
            background: #f7f7f7;
            min-height: calc(100vh - 140px);
        }

        .edit-card {
            max-width: 700px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
        }

        .edit-card h1 {
            font-size: 30px;
            margin-bottom: 25px;
            color: #111827;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #111827;
        }

        .form-group input[type="number"],
        .form-group input[type="file"] {
            width: 100%;
            max-width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 15px;
            background: white;
        }

        .current-image {
            margin-bottom: 15px;
        }

        .current-image img {
            width: 160px;
            height: 160px;
            object-fit: cover;
            border-radius: 16px;
            border: 1px solid #ddd;
        }

        .save-btn {
            display: inline-block;
            background: #111827;
            color: white;
            border: none;
            padding: 12px 18px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
        }

        .save-btn:hover {
            opacity: 0.95;
        }

        .success-msg {
            color: green;
            margin-bottom: 15px;
        }

        .error-box {
            color: red;
            margin-bottom: 15px;
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

    <section class="edit-wrapper">
        <div class="container">
            <div class="edit-card">

                <a href="{{ route('moj.profil') }}" class="back-link">← Nazad na Moj Profil</a>

                <h1>Uredi profil frizera</h1>

                @if(session('success'))
                    <p class="success-msg">{{ session('success') }}</p>
                @endif

                @if ($errors->any())
                    <div class="error-box">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('frizeri.update', $frizer->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="cena">Cena (RSD)</label>
                        <input type="number" id="cena" name="cena" value="{{ old('cena', $frizer->cena) }}">
                    </div>

                    @if($frizer->slika)
                        <div class="current-image">
                            <label>Trenutna profilna slika:</label>
                            <img src="{{ asset('storage/' . $frizer->slika) }}" alt="Profilna slika">
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="slika">Nova profilna slika</label>
                        <input type="file" id="slika" name="slika">
                    </div>

                    <button type="submit" class="save-btn">Sačuvaj izmene</button>
                </form>
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