<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sve recenzije - BookCut</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <style>
        .page-wrapper {
            padding: 50px 0;
            background: #f7f7f7;
            min-height: calc(100vh - 140px);
        }

        .page-card {
            max-width: 950px;
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

        .review-list {
            display: grid;
            gap: 16px;
        }

        .review-card {
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 18px;
            background: #f9fafb;
        }

        .review-card p {
            margin-bottom: 8px;
            color: #374151;
        }

        .rating-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 999px;
            background: #fef3c7;
            color: #92400e;
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
            <div class="page-card">

                <a href="{{ route('moj.profil') }}" class="back-link">← Nazad na Moj Profil</a>

                <h1>Sve recenzije</h1>

                @if($reviews->count() > 0)
                    <div class="review-list">
                        @foreach($reviews as $review)
                            <div class="review-card">
                                <p>
                                    <strong>Korisnik:</strong>
                                    {{ $review->user->name ?? 'Nepoznat korisnik' }}
                                </p>

                                <p>
                                    <strong>Frizer:</strong>
                                    {{ $review->frizer->ime ?? '' }} {{ $review->frizer->prezime ?? '' }}
                                </p>

                                <p>
                                    <strong>Ocena:</strong>
                                    <span class="rating-badge">{{ $review->ocena }} / 5</span>
                                </p>

                                <p>
                                    <strong>Komentar:</strong>
                                    {{ $review->komentar ?: 'Nema komentara' }}
                                </p>

                                <p>
                                    <strong>Datum:</strong>
                                    {{ $review->created_at->format('d.m.Y H:i') }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-box">
                        <p>Nema recenzija.</p>
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