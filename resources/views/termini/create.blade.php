<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj termin - BookCut</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <style>
        .page-wrapper {
            padding: 50px 0;
            background: #f7f7f7;
            min-height: calc(100vh - 140px);
        }

        .form-card {
            max-width: 700px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
        }

        .form-card h1 {
            font-size: 30px;
            margin-bottom: 25px;
            color: #111827;
            text-align: center;
        }

        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #111827;
        }

        .form-group input[type="date"],
        .form-group input[type="time"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 15px;
            background: white;
        }

        .submit-btn {
            display: inline-block;
            background: #111827;
            color: white;
            border: none;
            padding: 12px 18px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
        }

        .submit-btn:hover {
            opacity: 0.95;
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

        .success-msg {
            color: green;
            margin-bottom: 15px;
        }

        .error-box {
            color: red;
            margin-bottom: 15px;
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
            <div class="form-card">

                <a href="{{ route('moj.profil') }}" class="back-link">← Nazad na Moj Profil</a>

                <h1>Dodaj termin</h1>

                @if(session('success'))
                    <p class="success-msg">{{ session('success') }}</p>
                @endif

                @if(session('error'))
                    <p class="error-box">{{ session('error') }}</p>
                @endif

                @if ($errors->any())
                    <div class="error-box">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('termini.store') }}" method="POST" id="terminForm">
                    @csrf

                    <div class="form-group">
                        <label for="datum">Datum</label>
                        <input type="date" id="datum" name="datum" value="{{ old('datum') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="vreme">Vreme</label>
                        <input type="time" id="vreme" name="vreme" value="{{ old('vreme') }}" required>
                    </div>

                    <button type="submit" class="submit-btn">Dodaj termin</button>
                </form>

            </div>
        </div>
    </section>

    <footer class="site-footer">
        <div class="container">
            <p>BookCut &copy; 2026 - Sistem za povezivanje frizera i korisnika</p>
        </div>
    </footer>

    <script>
        document.getElementById('terminForm').addEventListener('submit', function (e) {
            document.querySelectorAll('.js-error').forEach(el => el.remove());

            const datumInput = document.getElementById('datum');
            const danas = new Date().toISOString().split('T')[0];

            if (datumInput.value < danas) {
                const greska = document.createElement('p');
                greska.className = 'error-box js-error';
                greska.textContent = 'Datum ne može biti u prošlosti.';
                datumInput.insertAdjacentElement('afterend', greska);
                e.preventDefault();
            }
        });
    </script>

</body>
</html>