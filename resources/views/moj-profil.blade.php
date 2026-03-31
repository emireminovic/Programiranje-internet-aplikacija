<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moj Profil - BookCut</title>
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
            width: 160px;
            height: 160px;
            border-radius: 50%;
            object-fit: cover;
            display: block;
            margin: 0 auto 18px auto;
            border: 4px solid #e5e7eb;
        }

        .profile-avatar-placeholder {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            margin: 0 auto 18px auto;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-weight: bold;
        }

        .profile-name {
            font-size: 28px;
            margin-bottom: 10px;
            color: #111827;
        }

        .profile-role {
            display: inline-block;
            padding: 6px 12px;
            background: #dbeafe;
            color: #1d4ed8;
            border-radius: 999px;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .profile-meta p {
            margin-bottom: 8px;
            color: #374151;
        }

        .section-title {
            font-size: 28px;
            margin-bottom: 20px;
            color: #111827;
        }

        .quick-links {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
        }

        .quick-link-card {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 18px;
            text-decoration: none;
            color: #111827;
            transition: 0.2s ease;
        }

        .quick-link-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .quick-link-card h3 {
            margin-bottom: 8px;
            font-size: 18px;
        }

        .quick-link-card p {
            font-size: 14px;
            color: #4b5563;
        }

        .warning-box {
            background: #fff7ed;
            border-left: 5px solid #f97316;
            border-radius: 10px;
            padding: 14px;
            margin-bottom: 18px;
        }

        .warning-box p {
            margin: 6px 0;
        }

        .profile-actions {
            margin-top: 18px;
        }

        .profile-actions a {
            display: inline-block;
            padding: 10px 16px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: bold;
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
                <a href="{{ route('moj.profil') }}">Moj Profil</a>

                <form method="POST" action="{{ route('logout') }}" class="logout-form">
                    @csrf
                    <button type="submit">Izloguj se</button>
                </form>
            </nav>
        </div>
    </header>

    <section class="profile-wrapper">
        <div class="container">

            @if(auth()->user()->warnings->count() > 0)
                <div class="warning-box">
                    <strong>Upozorenja:</strong>
                    @foreach(auth()->user()->warnings as $warning)
                        <p>⚠️ {{ $warning->poruka }}</p>
                    @endforeach
                </div>
            @endif

            <div class="profile-grid">

                <!-- LEVA KOLONA -->
                <div class="profile-card">
                    @if(auth()->user()->role === 'frizer' && auth()->user()->frizer && auth()->user()->frizer->slika)
                        <img src="{{ asset('storage/' . auth()->user()->frizer->slika) }}" alt="Profilna slika" class="profile-avatar">
                    @else
                        <div class="profile-avatar-placeholder">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif

                    <h1 class="profile-name">{{ auth()->user()->name }}</h1>

                    <div class="profile-role">
                        {{ ucfirst(auth()->user()->role) }}
                    </div>

                    <div class="profile-meta">
                        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>

                        @if(auth()->user()->role === 'frizer' && auth()->user()->frizer)
                            <p><strong>Cena:</strong>
                                {{ auth()->user()->frizer->cena ? auth()->user()->frizer->cena . ' RSD' : 'Nije uneta' }}
                            </p>
                        @endif
                    </div>

                    <div class="profile-actions">
                        <a href="{{ route('profile.edit') }}">Izmeni nalog</a>
                    </div>
                </div>

                <!-- DESNA KOLONA -->
                <div class="profile-section">
                    <h2 class="section-title">Moj Profil</h2>

                    <div class="quick-links">

                        <a href="{{ route('frizeri.index') }}" class="quick-link-card">
                            <h3>💇 Frizeri</h3>
                            <p>Pregled svih frizera i njihovih profila.</p>
                        </a>

                        @if(auth()->user()->role === 'korisnik')
    <a href="{{ route('termini.myBookings') }}" class="quick-link-card">
        <h3>📅 Moje rezervacije</h3>
        <p>Pregled svih tvojih rezervacija i zahteva.</p>
    </a>

    <a href="{{ route('reviews.my') }}" class="quick-link-card">
        <h3>⭐ Moje recenzije</h3>
        <p>Pregled recenzija koje si ostavio različitim frizerima.</p>
    </a>

        <a href="{{ route('messages.sent') }}" class="quick-link-card">
    <h3>✉️ Moje poruke</h3>
    <p>Pregled poruka koje si poslao frizerima i njihovih odgovora.</p>
</a>

    
@endif

                        @if(auth()->user()->role === 'frizer' && auth()->user()->frizer)
                            <a href="{{ route('frizeri.edit', auth()->user()->frizer->id) }}" class="quick-link-card">
                                <h3>👤 Uredi profil</h3>
                                <p>Promeni cenu, profilnu sliku i podatke o profilu.</p>
                            </a>

                            <a href="{{ route('termini.create') }}" class="quick-link-card">
                                <h3>➕ Dodaj termin</h3>
                                <p>Dodaj nove slobodne termine za rezervaciju.</p>
                            </a>

                            <a href="{{ route('termini.requests') }}" class="quick-link-card">
                                <h3>📩 Moji zahtevi</h3>
                                <p>Pregledaj zahteve korisnika za rezervaciju.</p>
                            </a>

                            <a href="{{ route('termini.myAccepted') }}" class="quick-link-card">
                                <h3>✅ Prihvaćeni termini</h3>
                                <p>Pregled svih potvrđenih termina.</p>
                            </a>

                            <a href="{{ route('messages.inbox') }}" class="quick-link-card">
                             <h3>📬 Primljene poruke</h3>
                             <p>Pregled poruka koje su ti poslali korisnici.</p>
                            </a>
                            
                    

                        @endif

                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.frizeri') }}" class="quick-link-card">
                                <h3>⚙️ Zahtevi frizera</h3>
                                <p>Odobri ili odbij prijave novih frizera.</p>
                            </a>

                            <a href="{{ route('admin.reviews') }}" class="quick-link-card">
                                <h3>⭐ Sve recenzije</h3>
                                <p>Pregled ocena i komentara svih korisnika.</p>
                            </a>

                            <a href="{{ route('admin.users') }}" class="quick-link-card">
                                <h3>👥 Svi korisnici</h3>
                                <p>Upravljanje korisnicima, upozorenjima i brisanjem.</p>
                            </a>
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