@extends('admin.layouts.app')

@php
    $role = request('role');
    $validation = request('validation');

    if ($validation === 'pending') {
        $pageMode = 'pending';
        $title = 'Comptes en attente';
        $subtitle = $users->total() . ' dossier' . ($users->total() > 1 ? 's' : '') . ' artisan' . ($users->total() > 1 ? 's' : '') . ' à examiner';
        $placeholder = 'Rechercher...';
    } elseif ($role === 'artisan') {
        $pageMode = 'artisans';
        $title = 'Artisans validés';
        $subtitle = $users->total() . ' artisan' . ($users->total() > 1 ? 's' : '') . ' actif' . ($users->total() > 1 ? 's' : '') . ' sur la plateforme';
        $placeholder = 'Rechercher un artisan...';
    } elseif ($role === 'client') {
        $pageMode = 'clients';
        $title = 'Clients';
        $subtitle = 'Gestion des comptes clients';
        $placeholder = 'Rechercher un client...';
    } else {
        $pageMode = 'all';
        $title = 'Utilisateurs';
        $subtitle = $users->total() . ' utilisateur' . ($users->total() > 1 ? 's' : '');
        $placeholder = 'Nom ou email...';
    }
@endphp

@section('title', $title)

@push('head')
    <style>
        .page-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 18px;
            flex-wrap: wrap
        }

        .page-head h1 {
            font-size: 22px;
            font-weight: 800;
            color: var(--ink);
            margin: 0;
            letter-spacing: -.01em
        }

        .page-head .sub {
            color: var(--muted);
            font-size: 13px;
            margin-top: 3px
        }

        .page-head-right {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap
        }

        .search-pill {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 9px 14px;
            min-width: 260px;
        }

        .search-pill i {
            color: var(--muted)
        }

        .search-pill input {
            border: none;
            outline: none;
            background: transparent;
            font-size: 13px;
            flex: 1;
            font-family: inherit;
            color: var(--ink)
        }

        .count-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 600
        }

        .count-chip.warn {
            background: #FDF3DD;
            color: #A77914
        }

        .count-chip.danger {
            background: #FEE4E0;
            color: #A8332A
        }

        .filters {
            display: flex;
            gap: 8px;
            padding: 14px 18px;
            border-bottom: 1px solid var(--line);
            flex-wrap: wrap;
            align-items: center;
        }

        .filters-right {
            margin-left: auto;
            display: flex;
            gap: 8px;
            flex-wrap: wrap
        }

        .seg {
            display: flex;
            gap: 6px;
            flex-wrap: wrap
        }

        .seg .seg-btn {
            border: 1px solid var(--line);
            background: #fff;
            color: var(--text);
            padding: 7px 16px;
            border-radius: 9px;
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
            font-family: inherit;
            transition: all .2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .seg .seg-btn:hover {
            border-color: var(--accent);
            color: var(--primary)
        }

        .seg .seg-btn.active {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary)
        }

        .mini-select,
        .mini-input {
            border: 1px solid var(--line);
            background: #fff;
            border-radius: 9px;
            padding: 7px 12px;
            font-size: 12.5px;
            font-family: inherit;
            color: var(--ink);
            outline: none;
            min-width: 140px;
        }

        .mini-select:focus,
        .mini-input:focus {
            border-color: var(--accent)
        }

        .st-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 11px;
            border-radius: 100px;
            font-size: 11.5px;
            font-weight: 600;
            white-space: nowrap
        }

        .st-chip::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor
        }

        .st-chip.ok {
            background: #E7F5EC;
            color: #2B6B43
        }

        .st-chip.danger {
            background: #FEE4E0;
            color: #A8332A
        }

        .st-chip.warn {
            background: #FDF3DD;
            color: #A77914
        }

        .act-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 12px;
            border-radius: 9px;
            font-size: 12px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            text-decoration: none;
            font-family: inherit;
            transition: all .2s;
        }

        .act-view {
            background: var(--bg-cream);
            color: var(--primary)
        }

        .act-view:hover {
            background: var(--primary);
            color: #fff
        }

        .act-warn {
            background: #FDF3DD;
            color: #A77914
        }

        .act-warn:hover {
            background: #E8A020;
            color: #fff
        }

        .act-ok {
            background: #E7F5EC;
            color: #2B6B43
        }

        .act-ok:hover {
            background: #4A7C59;
            color: #fff
        }

        .act-danger {
            background: #FEE4E0;
            color: #A8332A
        }

        .act-danger:hover {
            background: #C94A3A;
            color: #fff
        }

        .pager {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 18px;
            border-top: 1px solid var(--line);
            gap: 10px;
            flex-wrap: wrap;
        }

        .pager-info {
            font-size: 12.5px;
            color: var(--muted)
        }

        .pager nav {
            margin: 0
        }

        .pager .pagination {
            margin: 0;
            gap: 4px;
            flex-wrap: wrap
        }

        .pager .page-link {
            border: 1px solid var(--line);
            color: var(--text);
            background: #fff;
            padding: 6px 12px;
            font-size: 12.5px;
            border-radius: 8px !important;
        }

        .pager .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff
        }

        .pager .page-item.disabled .page-link {
            opacity: .5
        }

        .cell-user {
            display: flex;
            align-items: center;
            gap: 11px
        }

        .cell-user .nm {
            font-weight: 600;
            color: var(--ink);
            font-size: 13px;
            line-height: 1.3
        }

        .cell-user .em {
            font-size: 11.5px;
            color: var(--muted)
        }

        .avatar-sq.p1 {
            background: linear-gradient(135deg, #C17B4E, #8B3D1A)
        }

        .avatar-sq.p2 {
            background: linear-gradient(135deg, #4A7C59, #2D5A3C)
        }

        .avatar-sq.p3 {
            background: linear-gradient(135deg, #2C4A6B, #1A2F48)
        }

        .avatar-sq.p4 {
            background: linear-gradient(135deg, #8B3D1A, #5A2610)
        }

        .avatar-sq.p5 {
            background: linear-gradient(135deg, #6B2D0E, #3A1608)
        }

        .tip {
            font-size: 12.5px;
            color: var(--muted);
            display: inline-flex;
            align-items: center;
            gap: 6px
        }

        @media(max-width:768px) {
            .page-head {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
                margin-bottom: 14px
            }

            .page-head-right {
                flex-direction: column;
                align-items: stretch
            }

            .search-pill {
                min-width: unset;
                width: 100%
            }

            .filters {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
                padding: 12px 14px
            }

            .filters-right {
                margin-left: 0;
                flex-direction: column;
                gap: 10px
            }

            .seg {
                overflow-x: auto;
                flex-wrap: nowrap;
                padding-bottom: 6px;
                margin: 0 -4px;
                display: flex
            }

            .seg .seg-btn {
                white-space: nowrap;
                flex-shrink: 0;
                padding: 8px 14px;
                font-size: 12.5px
            }

            .mini-select,
            .mini-input {
                min-width: unset;
                width: 100%;
                height: 38px
            }

            /* Mode "Carte" adaptatif pour la table */
            .table-feg thead {
                display: none;
            }

            .table-feg,
            .table-feg tbody,
            .table-feg tr,
            .table-feg td {
                display: block;
                width: 100%;
            }

            .table-feg tr {
                margin-bottom: 15px;
                border: 1px solid var(--line);
                border-radius: 14px;
                background: #fff;
                padding: 10px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
            }

            .table-feg td {
                padding: 8px 10px !important;
                border: none !important;
                display: flex;
                justify-content: space-between;
                align-items: center;
                text-align: right;
                font-size: 13px;
            }

            .table-feg td::before {
                content: attr(data-label);
                font-weight: 700;
                text-transform: uppercase;
                font-size: 10px;
                color: var(--muted);
                text-align: left;
                margin-right: 15px;
                flex-shrink: 0;
            }

            .table-feg td:first-child {
                background: var(--bg-cream);
                border-radius: 10px;
                margin-bottom: 10px;
                text-align: left;
                flex-direction: row-reverse;
                justify-content: space-between;
                padding: 12px 10px !important;
            }

            .table-feg td:first-child::before {
                display: none;
            }

            .table-feg td:last-child {
                margin-top: 10px;
                border-top: 1px solid var(--line) !important;
                padding-top: 14px !important;
                justify-content: center;
                gap: 8px;
            }

            .cell-user .nm {
                font-size: 14px
            }

            .cell-user .em {
                font-size: 12px
            }

            .act-btn {
                padding: 8px 14px;
                font-size: 12.5px;
                flex: 1;
                justify-content: center
            }

            .act-btn i {
                font-size: 15px
            }

            .pager {
                flex-direction: column;
                align-items: center;
                gap: 12px;
                text-align: center;
                padding: 16px
            }

            .pager .pagination {
                justify-content: center
            }
        }

        @media(max-width:480px) {
            .act-btn span {
                display: none;
            }

            .act-btn i {
                margin: 0;
            }

            .table-feg td {
                font-size: 12.5px;
            }

            .table-feg td:first-child .nm {
                font-size: 13px;
            }
        }

        /* ── Custom category dropdown ── */
        .cat-dd {
            position: relative;
            display: inline-block;
        }

        .cat-dd-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 7px 12px;
            border: 1px solid var(--line);
            background: #fff;
            border-radius: 9px;
            font-size: 12.5px;
            font-family: inherit;
            color: var(--ink);
            cursor: pointer;
            min-width: 165px;
            justify-content: space-between;
            transition: border-color .15s, color .15s;
            white-space: nowrap;
        }

        .cat-dd-btn:hover,
        .cat-dd-btn.open {
            border-color: var(--accent);
            color: var(--primary);
        }

        .cat-dd-btn .chev {
            font-size: 11px;
            color: var(--muted);
            transition: transform .2s;
            flex-shrink: 0;
        }

        .cat-dd-btn.open .chev {
            transform: rotate(180deg);
        }

        .cat-dd-panel {
            display: none;
            position: absolute;
            top: calc(100% + 6px);
            right: 0;
            min-width: 220px;
            max-height: 280px;
            overflow-y: auto;
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 12px;
            box-shadow: 0 8px 28px rgba(44, 16, 6, .13);
            z-index: 500;
            padding: 5px;
        }

        .cat-dd-panel.open {
            display: block;
            animation: ddSlide .13s ease;
        }

        @keyframes ddSlide {
            from {
                opacity: 0;
                transform: translateY(-5px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        .cat-dd-item {
            padding: 9px 13px;
            border-radius: 8px;
            font-size: 12.5px;
            color: var(--text);
            cursor: pointer;
            transition: background .12s;
        }

        .cat-dd-item:hover {
            background: var(--bg-cream);
        }

        .cat-dd-item.sel {
            background: var(--bg-cream);
            color: var(--primary);
            font-weight: 600;
        }

        @media(max-width:768px) {
            .cat-dd {
                width: 100%;
                display: block;
            }

            .cat-dd-btn {
                width: 100%;
                min-width: unset;
                height: 38px;
            }

            .cat-dd-panel {
                left: 0;
                right: 0;
                min-width: unset;
                max-height: 45vh;
                position: absolute;
                top: calc(100% + 6px);
                border-radius: 14px;
                box-shadow: 0 12px 32px rgba(44, 16, 6, .18);
            }
        }
    </style>
@endpush

@section('content')

    <div class="page-head">
        <div>
            <h1>{{ $title }}</h1>
            <div class="sub">{{ $subtitle }}</div>
        </div>
        <div class="page-head-right">
            <form method="GET" class="search-pill">
                @if($role)<input type="hidden" name="role" value="{{ $role }}">@endif
                @if($validation)<input type="hidden" name="validation" value="{{ $validation }}">@endif
                <i class="bi bi-search"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ $placeholder }}">
            </form>
            @if($pageMode === 'pending')
                <span class="count-chip warn">{{ $users->total() }} en attente</span>
            @endif
        </div>
    </div>

    <div class="card-feg">

        <div class="card-head">
            @if($pageMode === 'pending')
                <h3>Dossiers en attente de validation</h3>
                <span class="tip"><i class="bi bi-eye"></i> Cliquer sur une ligne pour voir le dossier</span>
            @else
                <h3>
                    @if($pageMode === 'artisans') Liste des artisans
                    @elseif($pageMode === 'clients') Tous les clients ({{ number_format($users->total(), 0, ',', ' ') }})
                    @else Liste des utilisateurs
                    @endif
                </h3>
                <div style="display:flex;gap:8px">
                    <span class="count-chip" style="background:#E7F5EC;color:#2B6B43">
                        {{ $activeCount ?? '—' }} actifs
                    </span>
                    <span class="count-chip danger">
                        {{ $suspendedCount ?? '—' }} suspendus
                    </span>
                </div>
            @endif
        </div>

        <form method="GET" class="filters">
            @if($role)<input type="hidden" name="role" value="{{ $role }}">@endif
            @if($validation)<input type="hidden" name="validation" value="{{ $validation }}">@endif
            @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif

            @if($pageMode === 'pending')
                <div class="seg">
                    <a class="seg-btn {{ !request('period') ? 'active' : '' }}"
                        href="{{ request()->fullUrlWithQuery(['period' => null]) }}">Tous ({{ $users->total() }})</a>
                    <a class="seg-btn {{ request('period') === 'today' ? 'active' : '' }}"
                        href="{{ request()->fullUrlWithQuery(['period' => 'today']) }}">Aujourd'hui ({{ $countToday ?? 0 }})</a>
                    <a class="seg-btn {{ request('period') === 'week' ? 'active' : '' }}"
                        href="{{ request()->fullUrlWithQuery(['period' => 'week']) }}">Cette semaine ({{ $countWeek ?? 0 }})</a>
                </div>
                <div class="filters-right">
                    @php $selCat = collect($categories ?? [])->firstWhere('id', (int) request('category')); @endphp
                    <div class="cat-dd">
                        <button type="button" class="cat-dd-btn" onclick="catDDToggle(this)">
                            <span class="cat-dd-label">{{ $selCat ? $selCat->name : 'Toutes catégories' }}</span>
                            <i class="bi bi-chevron-down chev"></i>
                        </button>
                        <div class="cat-dd-panel">
                            <div class="cat-dd-item {{ !request('category') ? 'sel' : '' }}"
                                onclick="catDDSelect(this, '')">Toutes catégories</div>
                            @foreach($categories ?? [] as $cat)
                                <div class="cat-dd-item {{ (string) request('category') === (string) $cat->id ? 'sel' : '' }}"
                                    onclick="catDDSelect(this, '{{ $cat->id }}')">{{ $cat->name }}</div>
                            @endforeach
                        </div>
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    </div>
                </div>
            @else
                <div class="seg">
                    <a class="seg-btn {{ !request('status') ? 'active' : '' }}"
                        href="{{ request()->fullUrlWithQuery(['status' => null]) }}">Tous</a>
                    <a class="seg-btn {{ request('status') === 'active' ? 'active' : '' }}"
                        href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}">Actifs</a>
                    <a class="seg-btn {{ request('status') === 'suspended' ? 'active' : '' }}"
                        href="{{ request()->fullUrlWithQuery(['status' => 'suspended']) }}">Suspendus</a>
                </div>
                <div class="filters-right">
                    @if($pageMode === 'artisans')
                        @php $selCat2 = collect($categories ?? [])->firstWhere('id', (int) request('category')); @endphp
                        <div class="cat-dd">
                            <button type="button" class="cat-dd-btn" onclick="catDDToggle(this)">
                                <span class="cat-dd-label">{{ $selCat2 ? $selCat2->name : 'Toutes catégories' }}</span>
                                <i class="bi bi-chevron-down chev"></i>
                            </button>
                            <div class="cat-dd-panel">
                                <div class="cat-dd-item {{ !request('category') ? 'sel' : '' }}"
                                    onclick="catDDSelect(this, '')">Toutes catégories</div>
                                @foreach($categories ?? [] as $cat)
                                    <div class="cat-dd-item {{ (string) request('category') === (string) $cat->id ? 'sel' : '' }}"
                                        onclick="catDDSelect(this, '{{ $cat->id }}')">{{ $cat->name }}</div>
                                @endforeach
                            </div>
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        </div>
                    @endif
                    <input type="text" name="city" class="mini-input" placeholder="Filtrer par ville..."
                        value="{{ request('city') }}">
                </div>
            @endif
        </form>

        <div style="overflow-x:auto">
            <table class="table-feg">
                <thead>
                    <tr>
                        @if($pageMode === 'pending')
                            <th>Artisan</th>
                            <th>Catégorie</th>
                            <th>Zone</th>
                            <th>Document</th>
                            <th>Soumis le</th>
                            <th>Actions rapides</th>
                        @elseif($pageMode === 'artisans')
                            <th>Artisan</th>
                            <th>Catégorie</th>
                            <th>Zone</th>
                            <th>Inscrit</th>
                            <th>Avis</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        @elseif($pageMode === 'clients')
                            <th>Client</th>
                            <th>Téléphone</th>
                            <th>Ville</th>
                            <th>Inscrit le</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        @else
                            <th>Utilisateur</th>
                            <th>Rôle</th>
                            <th>Ville</th>
                            <th>Inscrit le</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $i => $user)
                        <tr @if($pageMode === 'pending') onclick="window.location='{{ route('admin.users.show', $user) }}'"
                        style="cursor:pointer" @endif>
                            {{-- ══ Colonne principale (nom + email) ══ --}}
                            <td>
                                <div class="cell-user">
                                    <div class="avatar-sq p{{ ($i % 5) + 1 }}">
                                        {{ mb_strtoupper(mb_substr($user->first_name ?? $user->name, 0, 1)) }}</div>
                                    <div>
                                        <div class="nm">{{ $user->name }}</div>
                                        <div class="em">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>

                            @php $p = $user->artisanProfile; @endphp

                            @if($pageMode === 'pending')
                                <td data-label="Catégorie">{{ $p?->category?->name ?? $p?->metier ?? '—' }}</td>
                                <td data-label="Zone">{{ $p?->ville ?? '—' }}@if($p?->quartier) · {{ $p->quartier }}@endif</td>
                                <td data-label="Document">
                                    @if($p?->proof_type)
                                        <span class="st-chip warn">{{ ucfirst(str_replace('_', ' ', $p->proof_type)) }}</span>
                                    @else <span style="color:var(--muted);font-size:.8rem">Dossier non soumis</span> @endif
                                </td>
                                <td data-label="Soumis le" style="color:var(--muted)">
                                    @if($p)
                                        @php
                                            $c = $p->created_at;
                                            $label = $c->isToday() ? "Aujourd'hui · " . $c->format('H\\hi')
                                                : ($c->isYesterday() ? "Hier · " . $c->format('H\\hi')
                                                    : "Il y a " . (int) $c->diffInDays(now()) . "j · " . $c->format('H\\hi'));
                                        @endphp
                                        {{ $label }}
                                    @else
                                        <span style="font-size:.8rem">—</span>
                                    @endif
                                </td>
                                <td data-label="Actions rapides" onclick="event.stopPropagation()">
                                    <div style="display:flex;gap:6px;flex-wrap:wrap">
                                        <a href="{{ route('admin.users.show', $user) }}" class="act-btn act-view"><i
                                                class="bi bi-eye"></i> Voir dossier</a>
                                        <form action="{{ route('admin.users.verify-artisan', $user) }}" method="POST"
                                            style="margin:0">
                                            @csrf @method('PATCH')
                                            <button class="act-btn act-ok"><i class="bi bi-check-lg"></i> Valider</button>
                                        </form>
                                        <form action="{{ route('admin.users.reject-artisan', $user) }}" method="POST"
                                            style="margin:0"
                                            onsubmit="return (this.querySelector('[name=rejection_reason]').value = prompt('Motif du refus :') || '') !== ''">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="rejection_reason">
                                            <button class="act-btn act-danger"><i class="bi bi-x-lg"></i> Refuser</button>
                                        </form>
                                    </div>
                                </td>

                            @elseif($pageMode === 'artisans')
                                <td data-label="Catégorie">{{ $p?->category?->name ?? '—' }}</td>
                                <td data-label="Zone">{{ $p?->ville }}@if($p?->quartier) · {{ $p->quartier }}@endif</td>
                                <td data-label="Inscrit" style="color:var(--muted)">{{ $user->created_at->translatedFormat('M Y') }}
                                </td>
                                <td data-label="Avis">
                                    @if($p && $p->rating_count > 0)
                                        <span style="color:#C17B4E"><i class="bi bi-star-fill"></i></span>
                                        {{ $p->rating_count }} avis
                                    @else
                                        <span class="tip">—</span>
                                    @endif
                                </td>
                                <td data-label="Statut">
                                    @if($user->is_active)
                                        <span class="st-chip ok">Actif</span>
                                    @else
                                        <span class="st-chip danger">Suspendu</span>
                                    @endif
                                </td>
                                <td data-label="Actions">
                                    <div style="display:flex;gap:6px">
                                        <a href="{{ route('admin.users.show', $user) }}" class="act-btn act-view"><i
                                                class="bi bi-eye"></i> Voir</a>
                                        <form action="{{ route('admin.users.toggle-active', $user) }}" method="POST"
                                            style="margin:0">
                                            @csrf @method('PATCH')
                                            @if($user->is_active)
                                                <button class="act-btn act-warn"><i class="bi bi-slash-circle"></i> Suspendre</button>
                                            @else
                                                <button class="act-btn act-ok"><i class="bi bi-check-lg"></i> Réactiver</button>
                                            @endif
                                        </form>
                                    </div>
                                </td>

                            @elseif($pageMode === 'clients')
                                <td>{{ $user->phone ?: '—' }}</td>
                                <td>{{ $user->ville ?: '—' }}</td>
                                <td style="color:var(--muted)">{{ $user->created_at->translatedFormat('j M Y') }}</td>
                                <td>
                                    @if($user->is_active)
                                        <span class="st-chip ok">Actif</span>
                                    @else
                                        <span class="st-chip danger">Suspendu</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display:flex;gap:6px">
                                        <a href="{{ route('admin.users.show', $user) }}" class="act-btn act-view"><i
                                                class="bi bi-eye"></i> Voir</a>
                                        <form action="{{ route('admin.users.toggle-active', $user) }}" method="POST"
                                            style="margin:0">
                                            @csrf @method('PATCH')
                                            @if($user->is_active)
                                                <button class="act-btn act-warn"><i class="bi bi-slash-circle"></i> Suspendre</button>
                                            @else
                                                <button class="act-btn act-ok"><i class="bi bi-check-lg"></i> Réactiver</button>
                                            @endif
                                        </form>
                                    </div>
                                </td>

                            @else
                                <td><span class="st-chip"
                                        style="background:var(--bg-cream);color:var(--primary)">{{ ucfirst($user->role) }}</span>
                                </td>
                                <td>{{ $user->ville ?: '—' }}</td>
                                <td style="color:var(--muted)">{{ $user->created_at->format('d/m/Y') }}</td>
                                <td>
                                    @if($user->is_active)<span class="st-chip ok">Actif</span>@else<span
                                    class="st-chip danger">Suspendu</span>@endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.users.show', $user) }}" class="act-btn act-view"><i
                                            class="bi bi-eye"></i> Voir</a>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-row" style="padding:40px;text-align:center;color:var(--muted)">
                                <i class="bi bi-inbox"></i> Aucun résultat
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pager">
            <div class="pager-info">
                @if($users->total() > 0)
                    Affichage {{ $users->firstItem() }}–{{ $users->lastItem() }} sur
                    {{ number_format($users->total(), 0, ',', ' ') }}
                    @if($pageMode === 'pending') dossiers
                    @elseif($pageMode === 'artisans') artisans
                    @elseif($pageMode === 'clients') clients
                    @else utilisateurs
                    @endif
                @else
                    Aucun résultat
                @endif
            </div>
            {{ $users->withQueryString()->onEachSide(1)->links() }}
        </div>

    </div>

@endsection

@push('scripts')
<script>
    function catDDToggle(btn) {
        const dd = btn.closest('.cat-dd');
        const panel = dd.querySelector('.cat-dd-panel');
        const isOpen = panel.classList.contains('open');
        closeAllCatDD();
        if (!isOpen) {
            panel.classList.add('open');
            btn.classList.add('open');
        }
    }

    function catDDSelect(item, catId) {
        const dd = item.closest('.cat-dd');
        dd.querySelector('input[type=hidden][name=category]').value = catId;
        dd.querySelectorAll('.cat-dd-item').forEach(i => i.classList.remove('sel'));
        item.classList.add('sel');
        dd.querySelector('.cat-dd-label').textContent = item.textContent.trim();
        closeAllCatDD();
        item.closest('form').submit();
    }

    function closeAllCatDD() {
        document.querySelectorAll('.cat-dd-panel.open').forEach(p => p.classList.remove('open'));
        document.querySelectorAll('.cat-dd-btn.open').forEach(b => b.classList.remove('open'));
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.cat-dd')) closeAllCatDD();
    });
</script>
@endpush