<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $frizer->ime }} {{ $frizer->prezime }} - BookCut</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <style>
        .profile-wrapper {
            padding: 50px 0;
            background: #f7f7f7;
            min-height: calc(100vh - 140px);
        }

        .profile-grid {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 25px;
            align-items: start;
        }

        .profile-card,
        .profile-section {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
        }

        .profile-card {
            text-align: center;
        }

        .profile-avatar {
            width: 220px;
            height: 220px;
            border-radius: 16px;
            object-fit: cover;
            display: block;
            margin: 0 auto 18px auto;
            border: 1px solid #ddd;
        }

        .profile-avatar-placeholder {
            width: 220px;
            height: 220px;
            border-radius: 16px;
            margin: 0 auto 18px auto;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-weight: bold;
        }

        .profile-name {
            font-size: 30px;
            margin-bottom: 12px;
            color: #111827;
        }

        .profile-meta p {
            margin-bottom: 8px;
            color: #374151;
        }

        .section-title {
            font-size: 28px;
            margin-bottom: 18px;
            color: #111827;
        }

        .section-block {
            margin-bottom: 28px;
        }

        .term-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 15px;
        }

        .term-card {
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 16px;
            background: #f9fafb;
        }

        .book-btn,
        .back-btn,
        .review-btn {
            display: inline-block;
            background: #111827;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
        }

        .book-btn:hover,
        .back-btn:hover,
        .review-btn:hover {
            opacity: 0.95;
        }

        .back-btn {
            background: #2563eb;
            margin-top: 10px;
        }

        .review-list {
            display: grid;
            gap: 12px;
        }

        .review-card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 15px;
            background: #f9fafb;
        }

        .msg-success {
            color: green;
            margin-bottom: 15px;
        }

        .msg-error {
            color: red;
            margin-bottom: 15px;
        }

        .review-form textarea,
        .review-form select {
            width: 100%;
            max-width: 500px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
            margin-top: 6px;
        }

        @media (max-width: 900px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }
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

    <section class="profile-wrapper">
        <div class="container">

            @if(session('success'))
                <p class="msg-success">{{ session('success') }}</p>
            @endif

            @if(session('error'))
                <p class="msg-error">{{ session('error') }}</p>
            @endif

            <div class="profile-grid">

                <div class="profile-card">
                    @if($frizer->slika)
                        <img src="{{ asset('storage/' . $frizer->slika) }}" alt="Profilna slika" class="profile-avatar">
                    @else
                        <div class="profile-avatar-placeholder">Nema slike</div>
                    @endif

                    <h1 class="profile-name">{{ $frizer->ime }} {{ $frizer->prezime }}</h1>

                    <div class="profile-meta">
                        <p><strong>Email:</strong> {{ $frizer->email }}</p>
                        <p><strong>Telefon:</strong> {{ $frizer->telefon }}</p>
                        <p><strong>Cena šišanja:</strong> {{ $frizer->cena ? $frizer->cena . ' RSD' : 'Nije uneta' }}</p>
                        <p><strong>Prosečna ocena:</strong>
                            {{ $frizer->reviews->count() > 0 ? round($frizer->reviews->avg('ocena'), 1) . ' ⭐' : 'Nema ocena' }}
                        </p>
                    </div>

                    <a href="{{ route('frizeri.index') }}" class="back-btn">Nazad na frizere</a>
                </div>

                <div class="profile-section">

                    <div class="section-block">
                        <h2 class="section-title">Slobodni termini</h2>

                        @if($termini->count() > 0)
                            <div class="term-grid">
                                @foreach($termini as $termin)
                                    <div class="term-card">
                                        <p><strong>Datum:</strong> {{ $termin->datum }}</p>
                                        <p><strong>Vreme:</strong> {{ $termin->vreme }}</p>

                                        @auth
                                            @if(auth()->user()->role === 'korisnik')
                                                <form action="{{ route('termini.book', $termin->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="book-btn">Pošalji zahtev</button>
                                                </form>
                                            @endif
                                        @endauth
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p>Trenutno nema slobodnih termina.</p>
                        @endif
                    </div>

                    @auth
    @if(auth()->user()->role === 'korisnik')
        <div class="section-block">
            <h2 class="section-title">Pošalji poruku frizeru</h2>

            <form action="{{ route('messages.store', $frizer->id) }}" method="POST" class="review-form">
                @csrf

                <label>Naslov</label><br>
                <input type="text" name="naslov" style="width: 100%; max-width: 500px; padding: 10px; border: 1px solid #ccc; border-radius: 10px; margin-top: 6px;">

                <br><br>

                <label>Poruka</label><br>
                <textarea name="poruka" rows="5" style="width: 100%; max-width: 500px; padding: 10px; border: 1px solid #ccc; border-radius: 10px; margin-top: 6px;"></textarea>

                <br><br>

                <button type="submit" class="review-btn">Pošalji poruku</button>
            </form>
        </div>
    @endif
@endauth
                    @auth
                        @if(auth()->user()->role === 'korisnik')
                            @php
                                $mojaRecenzija = $frizer->reviews->where('user_id', auth()->id())->first();
                            @endphp

                            <div class="section-block">
                                <h2 class="section-title">Ostavi recenziju</h2>

                                @if(!$mojaRecenzija)
                                    <form action="{{ route('reviews.store', $frizer->id) }}" method="POST" class="review-form">
                                        @csrf

                                        <label>Ocena</label><br>
                                        <select name="ocena">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>

                                        <br><br>

                                        <label>Komentar</label><br>
                                        <textarea name="komentar" rows="4"></textarea>

                                        <br><br>

                                        <button type="submit" class="review-btn">Pošalji recenziju</button>
                                    </form>
                                @else
                                    <p>Već ste ocenili ovog frizera.</p>
                                @endif
                            </div>
                        @endif
                    @endauth

                    <div class="section-block">
                        <h2 class="section-title">Recenzije</h2>

                        @if($frizer->reviews->count() > 0)
                            <div class="review-list">
                                @foreach($frizer->reviews as $review)
                                    <div class="review-card">
                                        <strong>{{ $review->user->name }}</strong><br>
                                        <span>Ocena: {{ $review->ocena }} / 5</span><br>
                                        <span>Komentar: {{ $review->komentar ?: 'Bez komentara' }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p>Nema recenzija.</p>
                        @endif
                    </div>

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