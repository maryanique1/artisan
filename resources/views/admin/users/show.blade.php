@extends('admin.layouts.app')
@section('title', $user->name)

@push('head')
    <style>
        .page-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 10px;
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

        .st-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 600
        }

        .st-chip::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor
        }

        .st-chip.warn {
            background: #FDF3DD;
            color: #A77914
        }

        .st-chip.ok {
            background: #E7F5EC;
            color: #2B6B43
        }

        .st-chip.danger {
            background: #FEE4E0;
            color: #A8332A
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--muted);
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 16px;
            text-decoration: none;
            transition: color .2s
        }

        .back-link:hover {
            color: var(--primary)
        }

        .dossier-grid {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 16px
        }

        @media(max-width:960px) {
            .dossier-grid {
                grid-template-columns: 1fr
            }
        }

        .info-card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid rgba(232, 213, 192, .55);
            padding: 0;
            margin-bottom: 16px;
            overflow: hidden
        }

        .info-card h3 {
            margin: 0;
            padding: 16px 22px;
            font-size: 15px;
            font-weight: 700;
            color: var(--ink);
            border-bottom: 1px solid var(--line)
        }

        .info-row {
            display: grid;
            grid-template-columns: 180px 1fr;
            gap: 16px;
            padding: 14px 22px;
            border-bottom: 1px solid rgba(232, 213, 192, .4)
        }

        .info-row:last-child {
            border-bottom: none
        }

        .info-row .lbl {
            color: var(--muted);
            font-size: 12.5px
        }

        .info-row .val {
            color: var(--ink);
            font-size: 13.5px;
            font-weight: 500
        }

        .info-row .val a {
            color: var(--accent);
            font-weight: 600
        }

        .info-row .val a:hover {
            color: var(--primary)
        }

        .side-card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid rgba(232, 213, 192, .55);
            padding: 22px;
            margin-bottom: 16px
        }

        .side-avatar-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center
        }

        .side-avatar {
            width: 96px;
            height: 96px;
            border-radius: 22px;
            background: linear-gradient(135deg, var(--accent), var(--secondary));
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 36px;
            margin-bottom: 14px;
            box-shadow: 0 8px 20px rgba(107, 45, 14, .25);
        }

        .side-name {
            font-size: 18px;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 4px
        }

        .side-meta {
            color: var(--accent);
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 10px
        }

        .doc-block {
            background: var(--bg-cream);
            border-radius: 12px;
            padding: 18px;
            text-align: center;
            margin-top: 6px;
        }

        .doc-icon {
            width: 60px;
            height: 60px;
            border-radius: 14px;
            background: #fff;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            margin: 0 auto 10px;
        }

        .doc-name {
            font-weight: 700;
            color: var(--ink);
            font-size: 13.5px;
            word-break: break-all
        }

        .doc-sub {
            font-size: 11.5px;
            color: var(--muted);
            margin-top: 2px;
            margin-bottom: 12px
        }

        .doc-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fff;
            color: var(--primary);
            border: 1px solid var(--line);
            padding: 8px 14px;
            border-radius: 9px;
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
            transition: all .2s;
        }

        .doc-btn:hover {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary)
        }

        .decision {
            margin-top: 4px
        }

        .decision h4 {
            font-size: 14px;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 12px
        }

        .btn-full {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 12px 16px;
            border: none;
            border-radius: 11px;
            font-weight: 700;
            font-size: 13.5px;
            cursor: pointer;
            font-family: inherit;
            transition: all .2s;
            margin-bottom: 10px;
        }

        .btn-validate {
            background: linear-gradient(135deg, #4A7C59, #2D5A3C);
            color: #fff;
            box-shadow: 0 6px 14px rgba(74, 124, 89, .25)
        }

        .btn-validate:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(74, 124, 89, .35)
        }

        .btn-reject {
            background: #FEE4E0;
            color: #A8332A
        }

        .btn-reject:hover {
            background: #C94A3A;
            color: #fff
        }

        .reason-input {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 11px;
            padding: 11px 14px;
            font-size: 13px;
            font-family: inherit;
            resize: vertical;
            min-height: 70px;
            margin-bottom: 10px;
            background: var(--bg-cream);
        }

        .reason-input:focus {
            outline: none;
            border-color: var(--accent);
            background: #fff
        }

        .suspend-toggle {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 11px 14px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            font-family: inherit;
            border: none;
            transition: all .2s;
        }

        .suspend-toggle.suspend {
            background: #FDF3DD;
            color: #A77914
        }

        .suspend-toggle.suspend:hover {
            background: #E8A020;
            color: #fff
        }

        .suspend-toggle.activate {
            background: #E7F5EC;
            color: #2B6B43
        }

        .suspend-toggle.activate:hover {
            background: #4A7C59;
            color: #fff
        }

        .delete-btn {
            background: #FEE4E0;
            color: #A8332A;
            margin-top: 6px
        }

        .delete-btn:hover {
            background: #C94A3A;
            color: #fff
        }

        .pills-row {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 6px
        }

        .top-bar {
            display: none
        }
    </style>
@endpush

@section('content')

    <div class="page-head">
        <div>
            @php
                $p = $user->artisanProfile;
                $isPending = $user->isArtisan() && (!$p || $p->isPending());
                $isArtisan = $user->isArtisan();
                $headerTitle = $isArtisan ? 'Dossier — ' . $user->name : $user->name;
                $headerSub = $isPending ? 'En attente de validation · Soumis ' . $p->created_at->diffForHumans() : ($isArtisan ? 'Profil artisan' : ucfirst($user->role));
            @endphp
            <h1>{{ $headerTitle }}</h1>
            <div class="sub">{{ $headerSub }}</div>
        </div>
        @if($isPending)
            <span class="st-chip warn">En attente</span>
        @elseif($p && $p->isApproved())
            <span class="st-chip ok">Validé</span>
        @elseif($p && $p->validation_status === 'rejected')
            <span class="st-chip danger">Refusé</span>
        @elseif(!$user->is_active)
            <span class="st-chip danger">Suspendu</span>
        @else
            <span class="st-chip ok">Actif</span>
        @endif
    </div>

    <a href="{{ route('admin.users.index', ['validation' => $isPending ? 'pending' : null, 'role' => $isArtisan ? 'artisan' : 'client']) }}"
        class="back-link">
        <i class="bi bi-chevron-left"></i> Retour à la liste
    </a>

    <div class="dossier-grid">

        {{-- ═════ COLONNE GAUCHE ═════ --}}
        <div>
            <div class="info-card">
                <h3>Informations personnelles</h3>
                <div class="info-row">
                    <span class="lbl">Nom complet</span>
                    <span class="val">{{ $user->name }}</span>
                </div>
                <div class="info-row">
                    <span class="lbl">Email</span>
                    <span class="val">{{ $user->email }}</span>
                </div>
                @if($user->phone)
                    <div class="info-row">
                        <span class="lbl">Téléphone</span>
                        <span class="val">{{ $user->phone }}</span>
                    </div>
                @endif
                <div class="info-row">
                    <span class="lbl">Ville</span>
                    <span class="val">{{ $user->ville ?? '—' }}@if($user->quartier) · {{ $user->quartier }}@endif</span>
                </div>
                <div class="info-row">
                    <span class="lbl">Inscrit le</span>
                    <span class="val">{{ $user->created_at->translatedFormat('j F Y \à H\hi') }}</span>
                </div>
                <div class="info-row">
                    <span class="lbl">Rôle</span>
                    <span class="val">{{ ucfirst($user->role) }}</span>
                </div>
            </div>

            @if($isArtisan && $p)
                <div class="info-card">
                    <h3>Informations professionnelles</h3>
                    <div class="info-row">
                        <span class="lbl">Catégorie</span>
                        <span class="val">{{ $p->category?->name ?? $p->metier ?? '—' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="lbl">Zone d'intervention</span>
                        <span class="val">{{ $p->ville }}@if($p->quartier) · {{ $p->quartier }}@endif</span>
                    </div>
                    @if($p->description)
                        <div class="info-row">
                            <span class="lbl">Description</span>
                            <span class="val">{{ $p->description }}</span>
                        </div>
                    @endif
                    @if($p->proof_type)
                        <div class="info-row">
                            <span class="lbl">Type de document</span>
                            <span class="val">{{ ucfirst(str_replace('_', ' ', $p->proof_type)) }}</span>
                        </div>
                    @endif
                    @if($p->proof_document)
                        <div class="info-row">
                            <span class="lbl">Fichier soumis</span>
                            <span class="val">
                                <a href="{{ asset('storage/' . $p->proof_document) }}" target="_blank">
                                    {{ basename($p->proof_document) }} <i class="bi bi-box-arrow-up-right"
                                        style="font-size:11px"></i>
                                </a>
                            </span>
                        </div>
                    @endif
                    @if($p->rating_count > 0)
                        <div class="info-row">
                            <span class="lbl">Note clients</span>
                            <span class="val">
                                <span style="color:#C17B4E">
                                    @for($j = 1; $j <= 5; $j++)
                                        <i class="bi bi-star{{ $j <= round($p->rating_avg) ? '-fill' : '' }}"></i>
                                    @endfor
                                </span>
                                <strong>{{ number_format($p->rating_avg, 1) }}/5</strong>
                                <small style="color:var(--muted)">({{ $p->rating_count }} avis)</small>
                            </span>
                        </div>
                    @endif
                    @if($p->rejection_reason)
                        <div class="info-row">
                            <span class="lbl">Motif du refus</span>
                            <span class="val" style="color:#A8332A">{{ $p->rejection_reason }}</span>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        {{-- ═════ COLONNE DROITE ═════ --}}
        <aside>
            <div class="side-card">
                <div class="side-avatar-wrap">
                    @php $initials = mb_strtoupper(mb_substr($user->first_name ?? $user->name, 0, 1) . mb_substr($user->last_name ?? '', 0, 1)); @endphp
                    <div class="side-avatar">{{ $initials ?: 'U' }}</div>
                    <div class="side-name">{{ $user->name }}</div>
                    @if($isArtisan && $p)
                        <div class="side-meta">{{ $p->category?->name ?? 'Artisan' }} · {{ $p->ville }}</div>
                    @else
                        <div class="side-meta">{{ ucfirst($user->role) }}</div>
                    @endif

                    <div class="pills-row">
                        @if($isPending)<span class="st-chip warn">En attente</span>
                        @elseif($p && $p->isApproved())<span class="st-chip ok">Validé</span>
                        @elseif($p && $p->validation_status === 'rejected')<span class="st-chip danger">Refusé</span>
                        @endif
                        @if(!$user->is_active)<span class="st-chip danger">Suspendu</span>@endif
                    </div>
                </div>

                @if($isArtisan && $p && $p->proof_document)
                    <div class="doc-block">
                        <div class="doc-icon"><i class="bi bi-file-earmark-text"></i></div>
                        <div class="doc-name">{{ basename($p->proof_document) }}</div>
                        <div class="doc-sub">{{ strtoupper(pathinfo($p->proof_document, PATHINFO_EXTENSION)) }}
                            @if($p->proof_type) · {{ ucfirst(str_replace('_', ' ', $p->proof_type)) }}@endif
                        </div>
                        <a href="{{ asset('storage/' . $p->proof_document) }}" target="_blank" class="doc-btn">
                            <i class="bi bi-eye"></i> Consulter le document
                        </a>
                    </div>
                @endif
            </div>

            @if($isPending)
                <div class="side-card">
                    <div class="decision">
                        <h4>Décision</h4>
                        <form action="{{ route('admin.users.verify-artisan', $user) }}" method="POST" style="margin:0">
                            @csrf @method('PATCH')
                            <button class="btn-full btn-validate"><i class="bi bi-check-lg"></i> Valider le compte</button>
                        </form>

                        <form action="{{ route('admin.users.reject-artisan', $user) }}" method="POST" style="margin:0">
                            @csrf @method('PATCH')
                            <textarea name="rejection_reason" class="reason-input"
                                placeholder="Motif de refus (optionnel)..."></textarea>
                            <button class="btn-full btn-reject"><i class="bi bi-x-lg"></i> Refuser le dossier</button>
                        </form>
                    </div>
                </div>
            @else
                <div class="side-card">
                    <h4 style="font-size:14px;font-weight:700;color:var(--ink);margin-bottom:12px">Actions</h4>
                    <form action="{{ route('admin.users.toggle-active', $user) }}" method="POST" style="margin:0">
                        @csrf @method('PATCH')
                        @if($user->is_active)
                            <button class="suspend-toggle suspend"><i class="bi bi-slash-circle"></i> Suspendre le compte</button>
                        @else
                            <button class="suspend-toggle activate"><i class="bi bi-check-lg"></i> Réactiver le compte</button>
                        @endif
                    </form>
                    @if(!$user->isAdmin())
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="margin:0;margin-top:8px"
                            data-confirm="Supprimer définitivement cet utilisateur ?">
                            @csrf @method('DELETE')
                            <button class="suspend-toggle delete-btn"><i class="bi bi-trash"></i> Supprimer le compte</button>
                        </form>
                    @endif
                </div>
            @endif
        </aside>

    </div>

@endsection