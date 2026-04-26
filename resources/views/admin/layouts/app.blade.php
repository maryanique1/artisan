<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — FeGArtisan Admin</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,700;0,800;1,400;1,500&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --primary: #6B2D0E;
            --secondary: #8B3D1A;
            --accent: #C17B4E;
            --accent-light: #E8B088;
            --darker: #2C1006;
            --dark: #3A1608;
            --bg: #FAF3E8;
            --bg-cream: #F5EDE0;
            --ink: #2C1A0E;
            --text: #4A3424;
            --muted: #9A7A64;
            --line: #E8D5C0;
            --success: #4A7C59;
            --warning: #E8A020;
            --danger: #C94A3A;
        }

        * {
            box-sizing: border-box
        }

        html,
        body {
            height: 100%
        }

        body {
            margin: 0;
            font-family: 'Poppins', system-ui, sans-serif;
            background: var(--bg);
            color: var(--text);
            font-size: 14px;
            line-height: 1.55;
            -webkit-font-smoothing: antialiased;
        }

        .serif {
            font-family: 'Playfair Display', Georgia, serif
        }

        a {
            color: inherit;
            text-decoration: none
        }

        button {
            font-family: inherit
        }

        /* ══════ SIDEBAR ══════ */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 260px;
            z-index: 1000;
            background:
                radial-gradient(circle at 80% 10%, rgba(232, 176, 136, .08) 0, transparent 50%),
                linear-gradient(180deg, var(--darker) 0%, var(--primary) 100%);
            color: #fff;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(255, 255, 255, .04);
        }

        .sb-brand {
            padding: 18px 24px 14px
        }

        .sb-brand-name {
            font-family: 'Playfair Display', serif;
            font-weight: 800;
            font-size: 28px;
            letter-spacing: -.01em;
            line-height: 1;
            color: #fff
        }

        .sb-brand-name .gold {
            color: var(--accent-light)
        }

        .sb-brand-tag {
            margin-top: 6px;
            font-size: 10px;
            letter-spacing: .3em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .45);
            font-weight: 500
        }

        .sb-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 16px;
            background: rgba(232, 176, 136, .08);
            border: 1px solid rgba(232, 176, 136, .18);
            padding: 6px 14px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 500;
            color: var(--accent-light);
        }

        .sb-brand-head {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sb-close-btn {
            display: none;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .1);
            color: rgba(255, 255, 255, .8);
            font-size: 17px;
            cursor: pointer;
            flex-shrink: 0;
            transition: background .2s, color .2s;
        }

        .sb-close-btn:hover {
            background: rgba(255, 255, 255, .16);
            color: #fff;
        }

        @media(max-width:960px) {
            .sb-close-btn {
                display: flex;
            }
        }

        .sb-section {
            padding: 14px 24px 8px;
            font-size: 10px;
            letter-spacing: .3em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, .28);
            font-weight: 600;
            margin-top: 14px
        }

        .sb-nav {
            padding: 0 14px;
            flex: 1;
            overflow-y: auto;
            scrollbar-width: none
        }
        .sb-nav::-webkit-scrollbar { display: none }

        .sb-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 9px 14px;
            margin-bottom: 1px;
            border-radius: 10px;
            color: rgba(255, 255, 255, .65);
            font-weight: 500;
            font-size: 13.5px;
            transition: all .2s;
            position: relative;
        }

        .sb-item i {
            font-size: 17px;
            width: 20px;
            text-align: center;
            color: rgba(255, 255, 255, .55)
        }

        .sb-item:hover {
            background: rgba(255, 255, 255, .04);
            color: #fff
        }

        .sb-item:hover i {
            color: var(--accent-light)
        }

        .sb-item.active {
            background: linear-gradient(90deg, rgba(232, 176, 136, .14), rgba(232, 176, 136, .04));
            color: #fff;
            font-weight: 600;
        }

        .sb-item.active i {
            color: var(--accent-light)
        }

        .sb-item.active::before {
            content: "";
            position: absolute;
            left: -14px;
            top: 10px;
            bottom: 10px;
            width: 3px;
            background: var(--accent-light);
            border-radius: 0 3px 3px 0;
        }

        .sb-item .label {
            flex: 1
        }

        .sb-badge {
            font-size: 11px;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 100px;
            background: rgba(255, 255, 255, .08);
            color: rgba(255, 255, 255, .75);
        }

        .sb-badge.warn {
            background: rgba(232, 176, 136, .2);
            color: var(--accent-light)
        }

        .sb-badge.danger {
            background: rgba(201, 74, 58, .22);
            color: #F4A99F
        }

        .sb-footer {
            padding: 16px;
            border-top: 1px solid rgba(255, 255, 255, .06)
        }

        .sb-user {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 6px
        }

        .sb-avatar {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--accent), var(--secondary));
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 15px;
        }

        .sb-user-info {
            flex: 1;
            min-width: 0
        }

        .sb-user-info strong {
            display: block;
            color: #fff;
            font-weight: 600;
            font-size: 13px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis
        }

        .sb-user-info span {
            font-size: 11px;
            color: rgba(255, 255, 255, .5)
        }

        .sb-logout {
            background: rgba(255, 255, 255, .05);
            border: 1px solid rgba(255, 255, 255, .08);
            color: rgba(255, 255, 255, .7);
            width: 36px;
            height: 36px;
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .2s;
        }

        .sb-logout:hover {
            background: var(--danger);
            border-color: var(--danger);
            color: #fff
        }

        /* ══════ FIXED NAVBAR ══════ */
        .navbar-top {
            position: fixed;
            top: 0;
            left: 260px;
            right: 0;
            height: 64px;
            z-index: 900;
            background: rgba(250, 243, 232, .88);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--line);
            display: flex;
            align-items: center;
            padding: 0 28px;
            gap: 16px;
        }

        .nav-date {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--text);
            font-weight: 500;
        }

        .nav-date i {
            color: var(--accent);
            font-size: 15px
        }

        .nav-date span::first-letter {
            text-transform: uppercase
        }

        .nav-date-short {
            display: none;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: auto
        }

        .nav-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: #fff;
            border: 1px solid var(--line);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            cursor: pointer;
            position: relative;
            transition: all .2s;
            text-decoration: none;
        }

        .nav-btn:hover {
            background: var(--bg-cream);
            color: var(--primary)
        }

        .nav-btn i {
            font-size: 16px
        }

        .nav-btn .ping {
            position: absolute;
            top: 8px;
            right: 9px;
            width: 8px;
            height: 8px;
            background: var(--danger);
            border-radius: 50%;
            border: 2px solid #fff;
        }

        .nav-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 14px 6px 6px;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 100px;
            cursor: pointer;
            transition: all .2s;
        }

        .nav-user:hover {
            background: var(--bg-cream)
        }

        .nav-user .av {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            overflow: hidden;
            background: linear-gradient(135deg, var(--accent), var(--secondary));
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 12px;
        }

        .nav-user .av img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block
        }

        .nav-user .nm {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--ink);
            line-height: 1.1
        }

        .nav-user .rl {
            font-size: 10.5px;
            color: var(--muted)
        }

        /* ══════ MAIN ══════ */
        .main {
            margin-left: 260px;
            min-height: 100vh;
            padding: 88px 34px 40px
        }

        /* Top bar */
        .topbar {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 18px;
            flex-wrap: wrap
        }

        .topbar-left {
            flex: 1;
            min-width: 220px
        }

        .topbar-left h1 {
            font-weight: 800;
            color: var(--ink);
            font-size: 22px;
            margin: 0;
            letter-spacing: -.01em;
            font-family: 'Poppins', sans-serif
        }

        .topbar-left .sub {
            color: var(--muted);
            font-size: 12px;
            margin-top: 2px
        }

        .topbar-search {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 7px 12px;
            min-width: 240px;
            max-width: 320px;
            flex: 1;
        }

        .topbar-search i {
            color: var(--muted);
            font-size: 13px
        }

        .topbar-search input {
            border: none;
            outline: none;
            background: transparent;
            font-size: 12.5px;
            flex: 1;
            font-family: inherit;
            color: var(--ink)
        }


        /* ══════ ALERTS ══════ */
        .alert-feg {
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 13.5px;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
            border: 1px solid;
        }

        .alert-feg.success {
            background: #F0FAF4;
            border-color: #B6E2C4;
            color: #1F6A3A
        }

        .alert-feg.error {
            background: #FEF2F2;
            border-color: #FCA5A5;
            color: #991B1B
        }

        .alert-feg .close {
            margin-left: auto;
            background: none;
            border: none;
            color: inherit;
            opacity: .6;
            cursor: pointer;
            font-size: 16px
        }

        .alert-feg .close:hover {
            opacity: 1
        }

        /* ══════ CARDS (generic) ══════ */
        .card-feg {
            background: #fff;
            border-radius: 14px;
            border: 1px solid rgba(232, 213, 192, .5);
            box-shadow: 0 1px 3px rgba(44, 26, 14, .03);
        }

        .card-feg .card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 18px 12px;
            gap: 10px;
            flex-wrap: wrap;
        }

        .card-feg .card-head h3 {
            margin: 0;
            font-size: 14px;
            font-weight: 700;
            color: var(--ink);
            letter-spacing: -.01em
        }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 600;
        }

        .chip.neutral {
            background: var(--bg-cream);
            color: var(--primary)
        }

        .chip.warn {
            background: #FDF3DD;
            color: #A77914
        }

        .chip.danger {
            background: #FEE4E0;
            color: #A8332A
        }

        .chip.success {
            background: #E7F5EC;
            color: #2B6B43
        }

        /* ══════ BUTTONS ══════ */
        .btn-feg {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #fff;
            border: none;
            font-weight: 600;
            font-size: 13.5px;
            padding: 10px 18px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all .2s;
        }

        .btn-feg:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(107, 45, 14, .25);
            color: #fff
        }

        .btn-feg-outline {
            border: 1.5px solid var(--line);
            color: var(--primary);
            background: #fff;
            font-weight: 600;
            font-size: 13px;
            padding: 8px 14px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: all .2s;
        }

        .btn-feg-outline:hover {
            border-color: var(--primary);
            background: var(--primary);
            color: #fff
        }

        /* ══════ TABLE ══════ */
        .table-feg {
            width: 100%;
            border-collapse: collapse
        }

        .table-feg thead th {
            text-align: left;
            padding: 10px 18px;
            font-size: 9.5px;
            letter-spacing: .22em;
            text-transform: uppercase;
            color: var(--muted);
            font-weight: 600;
            background: #FCF7EE;
            border-top: 1px solid var(--line);
            border-bottom: 1px solid var(--line);
        }

        .table-feg tbody td {
            padding: 11px 18px;
            border-bottom: 1px solid rgba(232, 213, 192, .4);
            vertical-align: middle;
            font-size: 12.5px;
            color: var(--text)
        }

        .table-feg tbody tr:last-child td {
            border-bottom: none
        }

        .table-feg tbody tr:hover {
            background: #FCF7EE
        }

        .avatar-sq {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 12.5px;
            flex-shrink: 0;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
            gap: 12px;
            flex-wrap: wrap;
        }

        .top-bar h1 {
            font-size: 22px;
            font-weight: 700;
            color: var(--primary);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px
        }

        .badge-role-client {
            background: var(--primary);
            color: #fff
        }

        .badge-role-artisan {
            background: var(--secondary);
            color: #fff
        }

        .badge-role-admin {
            background: var(--success);
            color: #fff
        }

        /* ══════ RESPONSIVE ══════ */
        @media(max-width:960px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform .25s
            }

            .sidebar.open {
                transform: translateX(0)
            }

            .navbar-top {
                left: 0;
                padding: 0 14px 0 66px
            }

            .main {
                margin-left: 0;
                padding: 80px 18px 40px;
                overflow-x: hidden;
                max-width: 100vw
            }

            .nav-date {
                position: absolute;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
                font-size: 13px;
                font-weight: 600;
                white-space: nowrap;
                color: var(--ink);
                gap: 0;
            }

            .nav-date i,
            .nav-date > span:not(.nav-date-short) {
                display: none;
            }

            .nav-date-short {
                display: block;
            }

            .nav-user .txt {
                display: none
            }

            .burger-open {
                position: fixed;
                top: 12px;
                left: 12px;
                z-index: 1001;
                width: 40px;
                height: 40px;
                border-radius: 10px;
                background: var(--primary);
                color: #fff;
                border: none;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 20px;
                cursor: pointer;
            }
        }

        @media(min-width:961px) {
            .burger-open {
                display: none
            }
        }

        /* legacy compat (cards feg existantes) */
        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid var(--line)
        }

        .stat-card .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem
        }

        .stat-card .stat-value {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--primary)
        }

        .stat-card .stat-label {
            font-size: .8rem;
            color: var(--muted)
        }

        .card-feg .card-header {
            background: var(--bg-cream);
            border-bottom: 1px solid var(--line);
            font-weight: 700;
            color: var(--primary);
            font-size: .9rem;
            border-radius: 18px 18px 0 0
        }

        .table th {
            background: var(--bg-cream);
            color: var(--primary);
            font-weight: 700;
            font-size: .8rem;
            text-transform: uppercase;
            letter-spacing: .5px
        }

        .table td {
            vertical-align: middle;
            font-size: .85rem
        }
    </style>
    @stack('head')
</head>

<body>

    <button class="burger-open d-md-none" id="burgerOpen" aria-label="Menu"><i class="bi bi-list"></i></button>

    @php
        $currentUser = Auth::user();
        $initials = collect(explode(' ', $currentUser->name))->filter()->take(2)->map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)))->implode('');

        $navCounts = [
            'clients' => \App\Models\User::where('role', 'client')->where('is_active', true)->count(),
            'artisans' => \App\Models\User::where('role', 'artisan')->where('is_active', true)->whereHas('artisanProfile', fn($q) => $q->where('validation_status', 'approved'))->count(),
            'pending' => \App\Models\ArtisanProfile::where('validation_status', 'pending')->count() + \App\Models\User::where('role', 'artisan')->whereDoesntHave('artisanProfile')->count(),
            'reports' => \App\Models\Report::where('status', 'pending')->count(),
        ];

        $fmt = fn($n) => $n >= 1000 ? number_format($n / 1000, 1, ',', '') . 'k' : $n;
    @endphp

    <aside class="sidebar" id="sidebar">
        <div class="sb-brand">
            <div class="sb-brand-head">
                <button class="sb-close-btn" id="burgerClose" aria-label="Fermer le menu">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <div>
                    <div class="sb-brand-name serif">FeG<span class="gold">Artisan</span></div>
                    <div class="sb-brand-tag">Administration</div>
                </div>
            </div>
            <span class="sb-pill"><i class="bi bi-shield-lock-fill" style="font-size:11px"></i> Super Admin</span>
        </div>

        <div class="sb-section">Navigation</div>

        <nav class="sb-nav">
            <a href="{{ route('admin.dashboard') }}"
                class="sb-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                <span class="label">Tableau de bord</span>
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'client']) }}"
                class="sb-item {{ request()->routeIs('admin.users.*') && request('role') === 'client' ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i>
                <span class="label">Clients</span>
                <span class="sb-badge">{{ $fmt($navCounts['clients']) }}</span>
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'artisan']) }}"
                class="sb-item {{ request()->routeIs('admin.users.*') && request('role') === 'artisan' ? 'active' : '' }}">
                <i class="bi bi-tools"></i>
                <span class="label">Artisans</span>
                <span class="sb-badge">{{ $fmt($navCounts['artisans']) }}</span>
            </a>
            <a href="{{ route('admin.users.index', ['validation' => 'pending']) }}"
                class="sb-item {{ request()->routeIs('admin.users.*') && request('validation') === 'pending' ? 'active' : '' }}">
                <i class="bi bi-hourglass-split"></i>
                <span class="label">En attente</span>
                @if($navCounts['pending'] > 0)<span class="sb-badge warn">{{ $navCounts['pending'] }}</span>@endif
            </a>
            <a href="{{ route('admin.reports.index') }}"
                class="sb-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                <i class="bi bi-flag-fill"></i>
                <span class="label">Signalements</span>
                @if($navCounts['reports'] > 0)<span class="sb-badge danger">{{ $navCounts['reports'] }}</span>@endif
            </a>
            <a href="{{ route('admin.publications.index') }}"
                class="sb-item {{ request()->routeIs('admin.publications.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text-fill"></i>
                <span class="label">Publications</span>
            </a>
            <a href="{{ route('admin.categories.index') }}"
                class="sb-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                <i class="bi bi-tags-fill"></i>
                <span class="label">Catégories</span>
            </a>
            @if($currentUser->can_manage_admins)
            <a href="{{ route('admin.administrators.index') }}"
                class="sb-item {{ request()->routeIs('admin.administrators.*') ? 'active' : '' }}">
                <i class="bi bi-shield-lock-fill"></i>
                <span class="label">Administrateurs</span>
            </a>
            @endif
        </nav>

        <div class="sb-footer">
            <div class="sb-user">
                <a href="{{ route('admin.profile') }}" class="sb-user-link"
                    style="display:flex;align-items:center;gap:12px;flex:1;min-width:0;text-decoration:none">
                    @if($currentUser->avatar)
                        <div class="sb-avatar" style="padding:0;overflow:hidden">
                            <img src="{{ asset('storage/' . $currentUser->avatar) }}?v={{ $currentUser->updated_at->timestamp }}"
                                alt="" style="width:100%;height:100%;object-fit:cover">
                        </div>
                    @else
                        <div class="sb-avatar">{{ $initials ?: 'A' }}</div>
                    @endif
                    <div class="sb-user-info">
                        <strong>{{ $currentUser->name }}</strong>
                        <span>Mon profil</span>
                    </div>
                </a>
                <form action="{{ route('admin.logout') }}" method="POST" style="margin:0">
                    @csrf
                    <button type="submit" class="sb-logout" title="Déconnexion" aria-label="Déconnexion">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <header class="navbar-top">
        <div class="nav-date">
            <i class="bi bi-calendar3"></i>
            <span>{{ \Illuminate\Support\Carbon::now()->translatedFormat('l j F Y') }}</span>
            <span class="nav-date-short">{{ \Illuminate\Support\Carbon::now()->translatedFormat('j M Y') }}</span>
        </div>
        <div class="nav-actions">
            <a href="{{ route('admin.profile') }}" class="nav-user" title="Mon profil">
                <div class="av">
                    @if($currentUser->avatar)
                        <img src="{{ asset('storage/' . $currentUser->avatar) }}?v={{ $currentUser->updated_at->timestamp }}"
                            alt="">
                    @else
                        {{ $initials ?: 'A' }}
                    @endif
                </div>
                <div class="txt">
                    <div class="nm">{{ $currentUser->name }}</div>
                    <div class="rl">Super Admin</div>
                </div>
            </a>
        </div>
    </header>

    <main class="main">
        @if(session('success'))
            <div class="alert-feg success">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('success') }}</span>
                <button class="close" onclick="this.parentElement.remove()">&times;</button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert-feg error">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span>{{ session('error') }}</span>
                <button class="close" onclick="this.parentElement.remove()">&times;</button>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const burger = document.getElementById('burgerOpen');
        const closeBtn = document.getElementById('burgerClose');

        function setSidebarState(open) {
            sidebar.classList.toggle('open', open);
            if (burger) burger.style.display = open ? 'none' : 'flex';
        }

        if (burger) burger.addEventListener('click', () => setSidebarState(true));
        if (closeBtn) closeBtn.addEventListener('click', () => setSidebarState(false));

        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 960 && sidebar.classList.contains('open')
                && !sidebar.contains(e.target) && e.target !== burger && !burger.contains(e.target)) {
                setSidebarState(false);
            }
        });
    </script>
    @stack('scripts')

    {{-- Modal de confirmation global --}}
    <div id="feg-confirm-overlay" style="display:none;position:fixed;inset:0;background:rgba(44,16,6,.45);z-index:9999;align-items:center;justify-content:center">
        <div style="background:#fff;border-radius:20px;padding:36px 40px;max-width:420px;width:90%;box-shadow:0 24px 64px rgba(44,16,6,.18);text-align:center">
            <div style="width:60px;height:60px;border-radius:50%;background:#FEF2F2;border:2px solid #FECACA;display:flex;align-items:center;justify-content:center;font-size:1.6rem;margin:0 auto 20px">⚠️</div>
            <h3 style="font-size:1.1rem;font-weight:800;color:#4A3424;margin:0 0 10px" id="feg-confirm-title">Confirmer l'action</h3>
            <p style="font-size:.9rem;color:#9A7A64;margin:0 0 28px;line-height:1.6" id="feg-confirm-msg"></p>
            <div style="display:flex;gap:12px;justify-content:center">
                <button onclick="fegConfirmCancel()" style="flex:1;padding:11px 20px;border-radius:10px;border:1.5px solid #E8D5C0;background:#fff;color:#6B2D0E;font-weight:600;font-size:.9rem;cursor:pointer">Annuler</button>
                <button id="feg-confirm-ok" style="flex:1;padding:11px 20px;border-radius:10px;border:none;background:linear-gradient(135deg,#DC2626,#B91C1C);color:#fff;font-weight:700;font-size:.9rem;cursor:pointer">Confirmer</button>
            </div>
        </div>
    </div>
    <script>
        let _fegConfirmForm = null;
        const _overlay = document.getElementById('feg-confirm-overlay');

        function fegConfirmShow(msg, form, title) {
            _fegConfirmForm = form;
            document.getElementById('feg-confirm-msg').textContent = msg;
            document.getElementById('feg-confirm-title').textContent = title || 'Confirmer l\'action';
            _overlay.style.display = 'flex';
        }
        function fegConfirmCancel() {
            _overlay.style.display = 'none';
            _fegConfirmForm = null;
        }
        document.getElementById('feg-confirm-ok').addEventListener('click', () => {
            _overlay.style.display = 'none';
            if (_fegConfirmForm) {
                _fegConfirmForm.removeAttribute('data-confirm');
                _fegConfirmForm.submit();
            }
        });
        document.addEventListener('submit', function(e) {
            const form = e.target;
            const msg = form.getAttribute('data-confirm');
            if (msg) {
                e.preventDefault();
                fegConfirmShow(msg, form, form.getAttribute('data-confirm-title'));
            }
        });
        _overlay.addEventListener('click', (e) => { if (e.target === _overlay) fegConfirmCancel(); });
    </script>
</body>

</html>