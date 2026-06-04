<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookCut</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
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

                @guest
                    <a href="{{ route('login') }}">Prijava</a>
                    <a href="{{ route('register') }}" class="btn-nav">Registracija</a>
                @endguest

                @auth
                    <a href="{{ route('moj.profil') }}">Moj Profil</a>

                    <form method="POST" action="{{ route('logout') }}" class="logout-form">
                        @csrf
                        <button type="submit">Izloguj se</button>
                    </form>
                @endauth
            </nav>
        </div>
    </header>

    <section class="hero">
        <div class="container hero-content">
            <h1>Pronađi frizera i rezerviši termin lako</h1>
            <p>
                BookCut povezuje korisnike i frizere na jednom mestu.
                Pregledaj usluge, proveri slobodne termine i pronađi najbolje ocenjene frizere.
            </p>
            <div class="hero-actions">
                <a href="{{ route('frizeri.index') }}" class="btn-primary">Pogledaj frizere</a>

                @guest
                    <a href="{{ route('register') }}" class="btn-secondary">Kreiraj nalog</a>
                @endguest
            </div>
        </div>
    </section>

    

    <section class="section section-alt">
        <div class="container">
            <h2>Aktuelnosti i obaveštenja</h2>
            <div class="news-list">
                @foreach($aktuelnosti as $vest)
                    <div class="news-item">
                        {{ $vest }}
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <h2>Popularni frizeri</h2>

            @if($popularniFrizeri->count() > 0)
                <div class="card-grid">
                    @foreach($popularniFrizeri as $frizer)
                        <div class="card">
                            <h3>{{ $frizer->ime }} {{ $frizer->prezime }}</h3>
                            <p>Email: {{ $frizer->email }}</p>
                            <p>
                                Prosečna ocena:
                                {{ $frizer->reviews->count() > 0 ? round($frizer->reviews->avg('ocena'), 1) . ' ⭐' : 'Nema ocena' }}
                            </p>
                            <a href="{{ route('frizeri.show', $frizer->id) }}" class="card-link">Detalji</a>
                        </div>
                    @endforeach
                </div>
            @else
                <p>Trenutno nema dostupnih popularnih frizera.</p>
            @endif
        </div>
    </section>

    <footer class="site-footer">
        <div class="container">
            <p>BookCut &copy; 2026 - Sistem za povezivanje frizera i korisnika</p>
        </div>
    </footer>

</body>
</html>