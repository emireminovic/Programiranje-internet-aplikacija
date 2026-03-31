<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zahtevi frizera - BookCut</title>
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

        .request-list {
            display: grid;
            gap: 16px;
        }

        .request-card {
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 18px;
            background: #f9fafb;
        }

        .request-card p {
            margin-bottom: 8px;
            color: #374151;
        }

        .request-actions {
            margin-top: 12px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .approve-btn,
        .reject-btn,
        .back-link {
            display: inline-block;
            border: none;
            padding: 10px 16px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
        }

        .approve-btn {
            background: #16a34a;
            color: white;
        }

        .reject-btn {
            background: #dc2626;
            color: white;
        }

        .back-link {
            background: #2563eb;
            color: white;
            margin-bottom: 20px;
        }

        .success-msg {
            color: green;
            margin-bottom: 15px;
        }

        .error-msg {
            color: red;
            margin-bottom: 15px;
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

                <h1>Zahtevi za registraciju frizera</h1>

                @if(session('success'))
                    <p class="success-msg">{{ session('success') }}</p>
                @endif

                @if(session('error'))
                    <p class="error-msg">{{ session('error') }}</p>
                @endif

                @if($frizeri->count() > 0)
                    <div class="request-list">
                        @foreach($frizeri as $frizer)
                            <div class="request-card">
                                <p><strong>Ime:</strong> {{ $frizer->name }}</p>
                                <p><strong>Email:</strong> {{ $frizer->email }}</p>
                                <p><strong>Uloga:</strong> {{ $frizer->role }}</p>
                                <p><strong>Status:</strong> {{ $frizer->status }}</p>

                                <div class="request-actions">
                                    <form action="{{ route('admin.approve', $frizer->id) }}" method="POST" onsubmit="return confirm('Da li želite da odobrite ovog frizera?')">
                                        @csrf
                                        <button type="submit" class="approve-btn">Prihvati</button>
                                    </form>

                                    <form action="{{ route('admin.reject', $frizer->id) }}" method="POST" onsubmit="return confirm('Da li želite da odbijete ovog frizera?')">
                                        @csrf
                                        <button type="submit" class="reject-btn">Odbij</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-box">
                        <p>Trenutno nema zahteva za registraciju frizera.</p>
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