<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moji prihvaćeni termini - BookCut</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <style>
        .page-wrapper {
            padding: 50px 0;
            background: #f7f7f7;
            min-height: calc(100vh - 140px);
        }

        .page-card {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
        }

        .page-card h1 {
            font-size: 30px;
            margin-bottom: 25px;
            color: #111827;
            text-align: center;
        }

        .accepted-list {
            display: grid;
            gap: 16px;
        }

        .accepted-card {
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 18px;
            background: #f9fafb;
        }

        .accepted-card p {
            margin-bottom: 8px;
            color: #374151;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 999px;
            background: #dcfce7;
            color: #166534;
            font-weight: bold;
            font-size: 14px;
        }

        .back-link {
            display: inline-block;
            border: none;
            padding: 10px 16px;
            border-radius: 10px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .empty-box {
            text-align: center;
            color: #4b5563;
            padding: 20px 0;
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
            <div class="page-card">

                <a href="{{ route('moj.profil') }}" class="back-link">← Nazad na Moj Profil</a>

                <h1>Moji prihvaćeni termini</h1>

                @if($termini->count() > 0)
                    <div class="accepted-list">
                        @foreach($termini as $termin)
                            <div class="accepted-card">
                                <p><strong>Korisnik:</strong> {{ $termin->user->name ?? 'Nepoznat korisnik' }}</p>
                                <p><strong>Datum:</strong> {{ $termin->datum }}</p>
                                <p><strong>Vreme:</strong> {{ $termin->vreme }}</p>
                                <p><strong>Status:</strong> <span class="status-badge">{{ $termin->status }}</span></p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-box">
                        <p>Nemate prihvaćenih termina.</p>
                    </div>
                @endif

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