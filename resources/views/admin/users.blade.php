<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Svi korisnici - BookCut</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <style>
        .page-wrapper {
            padding: 50px 0;
            background: #f7f7f7;
            min-height: calc(100vh - 140px);
        }

        .page-card {
            max-width: 1000px;
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

        .user-list {
            display: grid;
            gap: 18px;
        }

        .user-card {
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 18px;
            background: #f9fafb;
        }

        .user-card p {
            margin-bottom: 8px;
            color: #374151;
        }

        .warning-box {
            margin-top: 10px;
            background: #fff3cd;
            padding: 10px;
            border-radius: 10px;
        }

        .warning-box p {
            margin: 6px 0;
        }

        .form-area {
            margin-top: 14px;
        }

        .form-area textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
            min-height: 90px;
            resize: vertical;
        }

        .actions {
            margin-top: 12px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .warn-btn,
        .delete-btn,
        .back-link {
            display: inline-block;
            border: none;
            padding: 10px 16px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
        }

        .warn-btn {
            background: #f59e0b;
            color: white;
        }

        .delete-btn {
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

        .role-badge,
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: bold;
        }

        .role-admin {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .role-frizer {
            background: #dcfce7;
            color: #166534;
        }

        .role-korisnik {
            background: #f3e8ff;
            color: #7e22ce;
        }

        .status-approved {
            background: #dcfce7;
            color: #166534;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-rejected {
            background: #fee2e2;
            color: #991b1b;
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

                <h1>Svi registrovani korisnici</h1>

                @if(session('success'))
                    <p class="success-msg">{{ session('success') }}</p>
                @endif

                @if(session('error'))
                    <p class="error-msg">{{ session('error') }}</p>
                @endif

                @if($users->count() > 0)
                    <div class="user-list">
                        @foreach($users as $user)
                            <div class="user-card">

                                <p><strong>Ime:</strong> {{ $user->name }}</p>
                                <p><strong>Email:</strong> {{ $user->email }}</p>

                                <p>
                                    <strong>Uloga:</strong>
                                    @if($user->role === 'admin')
                                        <span class="role-badge role-admin">admin</span>
                                    @elseif($user->role === 'frizer')
                                        <span class="role-badge role-frizer">frizer</span>
                                    @else
                                        <span class="role-badge role-korisnik">korisnik</span>
                                    @endif
                                </p>

                                <p>
                                    <strong>Status:</strong>
                                    @if($user->status === 'approved')
                                        <span class="status-badge status-approved">approved</span>
                                    @elseif($user->status === 'pending')
                                        <span class="status-badge status-pending">pending</span>
                                    @elseif($user->status === 'rejected')
                                        <span class="status-badge status-rejected">rejected</span>
                                    @else
                                        <span class="status-badge">{{ $user->status }}</span>
                                    @endif
                                </p>

                                @if($user->warnings->count() > 0)
                                    <div class="warning-box">
                                        <strong>Upozorenja:</strong>
                                        @foreach($user->warnings as $warning)
                                            <p>⚠️ {{ $warning->poruka }}</p>
                                        @endforeach
                                    </div>
                                @endif

                                @if($user->role !== 'admin')

                                    <div class="form-area">
                                        <form action="{{ route('admin.users.warning', $user->id) }}" method="POST">
                                            @csrf

                                            <textarea name="poruka" placeholder="Unesite upozorenje..." required></textarea>

                                            <div class="actions">
                                                <button type="submit" class="warn-btn">⚠️ Pošalji upozorenje</button>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="actions">
                                        <form action="{{ route('admin.users.delete', $user->id) }}" method="POST"
                                              onsubmit="return confirm('Da li ste sigurni da želite da obrišete ovog korisnika?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete-btn">🗑️ Obriši korisnika</button>
                                        </form>
                                    </div>

                                @endif

                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-box">
                        <p>Nema registrovanih korisnika.</p>
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