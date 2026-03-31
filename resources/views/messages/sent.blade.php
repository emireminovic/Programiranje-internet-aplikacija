<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moje poruke - BookCut</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <style>
        .page-wrapper { padding: 50px 0; background: #f7f7f7; min-height: calc(100vh - 140px); }
        .page-card { max-width: 950px; margin: 0 auto; background: white; border-radius: 16px; padding: 30px; box-shadow: 0 4px 14px rgba(0,0,0,0.08); }
        .page-card h1 { text-align: center; margin-bottom: 25px; }
        .msg-list { display: grid; gap: 16px; }
        .msg-card { border: 1px solid #e5e7eb; border-radius: 14px; padding: 18px; background: #f9fafb; }
        .back-link { display: inline-block; padding: 10px 16px; border-radius: 10px; background: #2563eb; color: white; text-decoration: none; font-weight: bold; margin-bottom: 20px; }
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
            <h1>Moje poruke</h1>

            @if($messages->count() > 0)
                <div class="msg-list">
                    @foreach($messages as $message)
                        <div class="msg-card">
                            <p><strong>Frizer:</strong> {{ $message->frizer->ime ?? '' }} {{ $message->frizer->prezime ?? '' }}</p>
                            <p><strong>Naslov:</strong> {{ $message->naslov }}</p>
                            <p><strong>Poruka:</strong> {{ $message->poruka }}</p>
                            <p><strong>Datum:</strong> {{ $message->created_at->format('d.m.Y H:i') }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p>Nema poslatih poruka.</p>
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