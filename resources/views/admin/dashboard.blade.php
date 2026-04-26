@extends('admin.layouts.app')
@section('title', 'Tableau de bord')

@push('head')
    <style>
        /* ═════ TOPBAR (override local) ═════ */
        /* inherits .topbar from layout */

        /* ═════ STAT CARDS ═════ */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 18px
        }

        .sc {
            background: #fff;
            border: 1px solid rgba(232, 213, 192, .55);
            border-radius: 14px;
            padding: 14px 16px 14px;
            position: relative;
            overflow: hidden;
            transition: transform .2s, box-shadow .2s;
        }

        .sc:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(44, 26, 14, .05)
        }

        .sc::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--c, var(--primary));
            border-radius: 14px 14px 0 0
        }

        .sc-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px
        }

        .sc-ico {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: var(--ico-bg, #FDF3E6);
            color: var(--c, var(--primary));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
        }

        .sc-badge {
            font-size: 10.5px;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 100px;
            display: inline-flex;
            align-items: center;
            gap: 3px;
            white-space: nowrap
        }

        .sc-badge.ok {
            background: #E7F5EC;
            color: #2B6B43
        }

        .sc-badge.warn {
            background: #FDF3DD;
            color: #A77914
        }

        .sc-badge.danger {
            background: #FEE4E0;
            color: #A8332A
        }

        .sc-val {
            font-size: 24px;
            font-weight: 800;
            color: var(--ink);
            line-height: 1;
            letter-spacing: -.02em;
            margin-bottom: 4px
        }

        .sc-label {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--ink)
        }

        .sc-sub {
            font-size: 11px;
            color: var(--muted);
            margin-top: 1px
        }

        /* variants */
        .sc.c-primary {
            --c: var(--primary);
            --ico-bg: #FDF3E6
        }

        .sc.c-accent {
            --c: var(--accent);
            --ico-bg: #FAEEDD
        }

        .sc.c-gold {
            --c: var(--warning);
            --ico-bg: #FDF3DD
        }

        .sc.c-danger {
            --c: var(--danger);
            --ico-bg: #FBE8E4
        }

        /* ═════ 2-COL LAYOUT ═════ */
        .grid-2 {
            display: grid;
            grid-template-columns: 1.7fr 1fr;
            gap: 14px;
            margin-bottom: 14px
        }

        .grid-3 {
            display: grid;
            grid-template-columns: 1.7fr 1fr;
            gap: 14px
        }

        /* ═════ AVATARS ═════ */
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

        .cell-user {
            display: flex;
            align-items: center;
            gap: 12px
        }

        .cell-user .name {
            font-weight: 600;
            color: var(--ink);
            font-size: 13.5px;
            line-height: 1.3
        }

        .cell-user .mail {
            font-size: 12px;
            color: var(--muted)
        }

        /* ═════ DONUT ═════ */
        .donut-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 8px 18px 16px;
            position: relative
        }

        .donut-box {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 4px auto 14px
        }

        .donut-center {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            pointer-events: none
        }

        .donut-center .val {
            font-size: 22px;
            font-weight: 800;
            color: var(--ink);
            line-height: 1
        }

        .donut-center .lbl {
            font-size: 10.5px;
            color: var(--muted);
            margin-top: 3px
        }

        .legend {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 7px;
            padding: 0 4px
        }

        .legend-row {
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 12px
        }

        .legend-dot {
            width: 9px;
            height: 9px;
            border-radius: 3px;
            flex-shrink: 0
        }

        .legend-name {
            flex: 1;
            color: var(--ink);
            font-weight: 500
        }

        .legend-val {
            font-weight: 700;
            color: var(--ink)
        }

        .legend-pct {
            font-size: 11.5px;
            color: var(--muted);
            width: 38px;
            text-align: right
        }

        /* ═════ ACTIVITY FEED ═════ */
        .feed {
            padding: 4px 18px 12px
        }

        .feed-item {
            display: flex;
            gap: 11px;
            padding: 10px 0;
            border-bottom: 1px solid rgba(232, 213, 192, .5)
        }

        .feed-item:last-child {
            border-bottom: none
        }

        .feed-ico {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: var(--bg-cream);
            color: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            flex-shrink: 0;
        }

        .feed-body {
            flex: 1;
            min-width: 0
        }

        .feed-body .t {
            font-size: 12.5px;
            color: var(--ink);
            line-height: 1.4
        }

        .feed-body .t b {
            font-weight: 700
        }

        .feed-body .m {
            font-size: 10.5px;
            color: var(--muted);
            margin-top: 2px
        }

        .empty-row {
            padding: 22px;
            text-align: center;
            color: var(--muted);
            font-size: 12.5px
        }

        @media(max-width:1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr)
            }

            .grid-2,
            .grid-3 {
                grid-template-columns: 1fr
            }
        }

        @media(max-width:640px) {
            .stats-grid {
                grid-template-columns: 1fr
            }
        }
    </style>
@endpush

@section('content')

    {{-- ═════ TOP BAR ═════ --}}
    <div class="topbar">
        <div class="topbar-left">
            <h1>Tableau de bord</h1>
            <div class="sub">FeGArtisan Admin · Vue d'ensemble</div>
        </div>
        <div class="topbar-search">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Rechercher..." aria-label="Rechercher">
        </div>
    </div>

    {{-- ═════ STAT CARDS ═════ --}}
    <div class="stats-grid">
        <div class="sc c-primary">
            <div class="sc-head">
                <div class="sc-ico"><i class="bi bi-people"></i></div>
                @if($stats['clients_this_month'] > 0)
                    <span class="sc-badge ok"><i class="bi bi-arrow-up"></i> +{{ $stats['clients_this_month'] }} ce mois</span>
                @endif
            </div>
            <div class="sc-val">{{ number_format($stats['total_clients'], 0, ',', ' ') }}</div>
            <div class="sc-label">Clients inscrits</div>
            <div class="sc-sub">Total cumulé depuis le lancement</div>
        </div>

        <div class="sc c-accent">
            <div class="sc-head">
                <div class="sc-ico"><i class="bi bi-tools"></i></div>
                @if($stats['artisans_this_month'] > 0)
                    <span class="sc-badge ok"><i class="bi bi-arrow-up"></i> +{{ $stats['artisans_this_month'] }} ce mois</span>
                @endif
            </div>
            <div class="sc-val">{{ number_format($stats['total_artisans_approved'], 0, ',', ' ') }}</div>
            <div class="sc-label">Artisans validés</div>
            <div class="sc-sub">Comptes actifs sur la plateforme</div>
        </div>

        <div class="sc c-gold">
            <div class="sc-head">
                <div class="sc-ico"><i class="bi bi-clock-history"></i></div>
                @if($stats['pending_validations'] > 0)
                    <span class="sc-badge warn"><i class="bi bi-exclamation-triangle"></i> À traiter</span>
                @endif
            </div>
            <div class="sc-val">{{ $stats['pending_validations'] }}</div>
            <div class="sc-label">Comptes en attente</div>
            <div class="sc-sub">Dossiers artisans à valider</div>
        </div>

        <div class="sc c-danger">
            <div class="sc-head">
                <div class="sc-ico"><i class="bi bi-exclamation-triangle"></i></div>
                @if($stats['pending_reports'] > 0)
                    <span class="sc-badge danger">{{ $stats['pending_reports'] }} non
                        traité{{ $stats['pending_reports'] > 1 ? 's' : '' }}</span>
                @endif
            </div>
            <div class="sc-val">{{ $stats['pending_reports'] }}</div>
            <div class="sc-label">Signalements actifs</div>
            <div class="sc-sub">Profils et publications signalés</div>
        </div>
    </div>

    {{-- ═════ DOSSIERS + RÉPARTITION ═════ --}}
    <div class="grid-2">

        {{-- Comptes artisans en attente --}}
        <div class="card-feg">
            <div class="card-head">
                <h3>Comptes artisans en attente de validation</h3>
                <span class="chip warn">{{ $stats['pending_validations'] }}
                    dossier{{ $stats['pending_validations'] > 1 ? 's' : '' }}</span>
            </div>
            @if($pendingArtisans->count())
                <div style="overflow-x:auto">
                    <table class="table-feg">
                        <thead>
                            <tr>
                                <th>Artisan</th>
                                <th>Catégorie</th>
                                <th>Zone</th>
                                <th>Soumis le</th>
                                <th>Document</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingArtisans as $i => $p)
                                <tr onclick="window.location='{{ route('admin.users.show', $p->user) }}'" style="cursor:pointer">
                                    <td>
                                        <div class="cell-user">
                                            <div class="avatar-sq p{{ ($i % 5) + 1 }}">
                                                {{ mb_strtoupper(mb_substr($p->user->first_name ?? $p->user->name, 0, 1)) }}</div>
                                            <div>
                                                <div class="name">{{ $p->user->name }}</div>
                                                <div class="mail">{{ $p->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $p->category?->name ?? $p->metier ?? '—' }}</td>
                                    <td>{{ $p->ville }}@if($p->quartier) · {{ $p->quartier }}@endif</td>
                                    <td style="color:var(--muted)">
                                        @php
                                            $created = $p->created_at;
                                            $label = $created->isToday() ? "Aujourd'hui"
                                                : ($created->isYesterday() ? "Hier"
                                                    : "Il y a " . (int) $created->diffInDays(now()) . "j");
                                        @endphp
                                        {{ $label }}
                                    </td>
                                    <td>
                                        @if($p->proof_type)
                                            <span class="chip warn">{{ ucfirst(str_replace('_', ' ', $p->proof_type)) }}</span>
                                        @else
                                            <span style="color:var(--muted)">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-row"><i class="bi bi-check-circle"></i> Aucun dossier en attente</div>
            @endif
        </div>

        {{-- Répartition artisans --}}
        <div class="card-feg">
            <div class="card-head">
                <h3>Répartition artisans</h3>
            </div>
            <div class="donut-wrap">
                <div class="donut-box">
                    <canvas id="donutCats" width="200" height="200"></canvas>
                    <div class="donut-center">
                        <span class="val">{{ $stats['total_artisans_approved'] }}</span>
                        <span class="lbl">artisans</span>
                    </div>
                </div>
                <div class="legend">
                    @php
                        $palette = ['#C17B4E', '#E8B088', '#C94A3A', '#E8D5C0', '#6B2D0E'];
                        $total = max(1, collect($distribution)->sum('total'));
                    @endphp
                    @forelse($distribution as $i => $cat)
                        <div class="legend-row">
                            <span class="legend-dot" style="background:{{ $palette[$i] ?? '#9A7A64' }}"></span>
                            <span class="legend-name">{{ $cat['name'] }}</span>
                            <span class="legend-val">{{ $cat['total'] }}</span>
                            <span class="legend-pct">{{ round($cat['total'] / $total * 100) }}%</span>
                        </div>
                    @empty
                        <div class="empty-row">Aucune donnée</div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

    {{-- ═════ SIGNALEMENTS + ACTIVITÉ ═════ --}}
    <div class="grid-3">

        {{-- Signalements --}}
        <div class="card-feg">
            <div class="card-head">
                <h3>Signalements récents</h3>
                @if($recentReports->count())
                    <span class="chip danger">{{ $recentReports->count() }} non
                        traité{{ $recentReports->count() > 1 ? 's' : '' }}</span>
                @endif
            </div>
            @if($recentReports->count())
                <div style="overflow-x:auto">
                    <table class="table-feg">
                        <thead>
                            <tr>
                                <th>Signalé par</th>
                                <th>Type</th>
                                <th>Motif</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentReports as $i => $r)
                                <tr>
                                    <td>
                                        <div class="cell-user">
                                            <div class="avatar-sq p{{ ($i % 5) + 1 }}"
                                                style="width:32px;height:32px;font-size:12px">
                                                {{ mb_strtoupper(mb_substr($r->reporter->first_name ?? $r->reporter->name, 0, 1)) }}
                                            </div>
                                            <div class="name">{{ $r->reporter->name }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="chip neutral">{{ $r->target_type === 'publication' ? 'Publication' : 'Profil' }}</span>
                                    </td>
                                    <td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                                        {{ $r->reason }}</td>
                                    <td style="color:var(--muted)">{{ $r->created_at->diffForHumans() }}</td>
                                    <td>
                                        <a href="{{ route('admin.reports.index') }}" class="btn-feg-outline"
                                            style="padding:5px 10px;font-size:12px">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-row"><i class="bi bi-check-circle"></i> Aucun signalement en attente</div>
            @endif
        </div>

        {{-- Activité récente --}}
        <div class="card-feg">
            <div class="card-head">
                <h3>Activité récente</h3>
            </div>
            <div class="feed">
                @forelse($recentActivity as $act)
                    <div class="feed-item">
                        <div class="feed-ico"><i class="bi {{ $act['icon'] }}"></i></div>
                        <div class="feed-body">
                            <div class="t"><b>{{ $act['title'] }}</b> — {{ $act['body'] }}</div>
                            <div class="m">{{ $act['at']->diffForHumans() }}</div>
                        </div>
                    </div>
                @empty
                    <div class="empty-row">Aucune activité récente</div>
                @endforelse
            </div>
        </div>

    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        const data = @json($distribution);
        const labels = data.map(d => d.name);
        const values = data.map(d => d.total);
        const colors = ['#C17B4E', '#E8B088', '#C94A3A', '#E8D5C0', '#6B2D0E'];

        if (values.length) {
            new Chart(document.getElementById('donutCats'), {
                type: 'doughnut',
                data: {
                    labels,
                    datasets: [{
                        data: values,
                        backgroundColor: colors.slice(0, values.length),
                        borderWidth: 0,
                        hoverOffset: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '72%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#2C1A0E',
                            padding: 10,
                            titleFont: { weight: '600' },
                            cornerRadius: 8,
                        }
                    }
                }
            });
        }
    </script>
@endpush