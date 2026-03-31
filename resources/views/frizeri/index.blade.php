<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frizeri - BookCut</title>
    <link rel="stylesheet" href="{{ asset('css/frizeri.css') }}">
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

                @auth
                    <a href="{{ route('moj.profil') }}">Moj Profil</a>

                    <form method="POST" action="{{ route('logout') }}" class="logout-form">
                        @csrf
                        <button type="submit">Izloguj se</button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}">Prijava</a>
                    <a href="{{ route('register') }}" class="btn-nav">Registracija</a>
                @endguest
            </nav>
        </div>
    </header>

    <main class="container page-content">

        <div class="page-title-wrap">
            <h1>Nađi svog frizera</h1>
        </div>

        <form method="GET" action="{{ route('frizeri.index') }}" class="search-filter-box">
            <input
                type="text"
                name="search"
                class="search-input"
                placeholder="Pretraži po imenu ili prezimenu..."
                value="{{ request('search') }}"
            >

            <select name="rating" class="rating-select">
                <option value="">Sve ocene</option>
                <option value="3" {{ request('rating') == 3 ? 'selected' : '' }}>3+ ⭐</option>
                <option value="4" {{ request('rating') == 4 ? 'selected' : '' }}>4+ ⭐</option>
                <option value="5" {{ request('rating') == 5 ? 'selected' : '' }}>5 ⭐</option>
            </select>

            <button type="submit" class="search-btn">Pretraži</button>
        </form>

        @if($frizeri->count() > 0)
            <div class="frizer-grid">
                @foreach($frizeri as $frizer)
                    <div class="frizer-card">
                        <div class="frizer-image-wrap">
                            @if($frizer->slika)
                                <img src="{{ asset('storage/' . $frizer->slika) }}" alt="Profilna slika" class="frizer-image">
                            @else
                                <img src="https://via.placeholder.com/300x220?text=Frizer" alt="Profilna slika" class="frizer-image">
                            @endif
                        </div>

                        <div class="frizer-card-body">
                            <h2>{{ $frizer->ime }} {{ $frizer->prezime }}</h2>

                            <p class="rating">
                                Prosečna ocena:
                                <strong>
                                    {{ $frizer->reviews->count() > 0 ? round($frizer->reviews->avg('ocena'), 1) . ' ⭐' : 'Nema ocena' }}
                                </strong>
                            </p>

                            <p>
                                Slobodnih termina:
                                <strong>{{ $frizer->termini->where('status', 'slobodan')->count() }}</strong>
                            </p>

                            <p>
                                Cena šišanja:
                                <strong>
                                    {{ $frizer->cena ? $frizer->cena . ' RSD' : 'Nije uneta' }}
                                </strong>
                            </p>

                            <a href="{{ route('frizeri.show', $frizer->id) }}" class="details-btn">
                                Zakaži termin
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-results">
                <p>Nema rezultata za zadatu pretragu.</p>
            </div>
        @endif

    </main>

    <footer class="site-footer">
        <div class="container">
            <p>BookCut &copy; 2026 - Sistem za povezivanje frizera i korisnika</p>
        </div>
    </footer>

</body>
</html>