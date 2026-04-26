@extends('admin.layouts.app')
@section('title', 'Administrateurs')

@push('head')
<style>
    .page-head { display:flex; justify-content:space-between; align-items:flex-start; gap:16px; margin-bottom:24px; flex-wrap:wrap }
    .page-head h1 { font-size:22px; font-weight:800; color:var(--ink); margin:0; letter-spacing:-.01em }
    .page-head .sub { color:var(--muted); font-size:13px; margin-top:3px }

    .card { background:#fff; border-radius:16px; border:1px solid var(--border); overflow:hidden }

    /* Invite form */
    .invite-card { background:#fff; border-radius:16px; border:1px solid var(--border); padding:28px 32px; margin-bottom:24px }
    .invite-card h2 { font-size:15px; font-weight:700; color:var(--ink); margin:0 0 20px }
    .form-row { display:grid; grid-template-columns:1fr 1fr; gap:14px }
    .form-group { display:flex; flex-direction:column; gap:6px }
    .form-group label { font-size:12px; font-weight:600; color:var(--muted); text-transform:uppercase; letter-spacing:.06em }
    .form-group input { border:1.5px solid var(--border); border-radius:10px; padding:10px 14px; font-size:14px; color:var(--ink); outline:none; transition:border-color .2s }
    .form-group input:focus { border-color:var(--primary) }
    .toggle-row { display:flex; align-items:center; justify-content:space-between; gap:12px; padding:14px 0; border-top:1px solid var(--border); margin-top:8px }
    .toggle-row-text strong { font-size:14px; font-weight:600; color:var(--ink) }
    .toggle-row-text span { font-size:12px; color:var(--muted); display:block; margin-top:2px }
    .toggle-switch { position:relative; width:44px; height:24px; flex-shrink:0 }
    .toggle-switch input { opacity:0; width:0; height:0 }
    .toggle-slider { position:absolute; inset:0; background:#D5C5B5; border-radius:24px; cursor:pointer; transition:.3s }
    .toggle-slider:before { content:''; position:absolute; width:18px; height:18px; left:3px; bottom:3px; background:#fff; border-radius:50%; transition:.3s }
    .toggle-switch input:checked + .toggle-slider { background:var(--primary) }
    .toggle-switch input:checked + .toggle-slider:before { transform:translateX(20px) }
    .btn-invite { background:linear-gradient(135deg,var(--primary),var(--primary-dark,#8B3D1A)); color:#fff; border:none; border-radius:10px; padding:11px 24px; font-size:14px; font-weight:600; cursor:pointer; transition:opacity .2s }
    .btn-invite:hover { opacity:.9 }
    .form-footer { display:flex; justify-content:flex-end; margin-top:20px }

    /* Table */
    .admins-table { width:100%; border-collapse:collapse }
    .admins-table th { padding:12px 20px; text-align:left; font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:.08em; border-bottom:1px solid var(--border); background:#FAFAF9 }
    .admins-table td { padding:14px 20px; border-bottom:1px solid var(--border); font-size:14px; color:var(--ink); vertical-align:middle }
    .admins-table tr:last-child td { border-bottom:none }
    .admin-info { display:flex; align-items:center; gap:12px }
    .admin-avatar { width:38px; height:38px; border-radius:50%; background:var(--primary); color:#fff; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:14px; flex-shrink:0 }
    .admin-name { font-weight:600; color:var(--ink) }
    .admin-email { font-size:12px; color:var(--muted); margin-top:1px }
    .badge { display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600 }
    .badge-green { background:#ECFDF5; color:#059669 }
    .badge-red { background:#FEF2F2; color:#DC2626 }
    .badge-purple { background:#F5F3FF; color:#7C3AED }
    .action-btn { border:none; background:none; cursor:pointer; padding:6px 10px; border-radius:8px; font-size:12px; font-weight:600; transition:background .2s }
    .action-btn:hover { background:var(--surface) }
    .action-btn.danger { color:#DC2626 }
    .action-btn.success { color:#059669 }
    .action-btn.purple { color:#7C3AED }
    .you-badge { font-size:10px; font-weight:700; background:#FDF3DD; color:#B45309; padding:2px 7px; border-radius:10px; margin-left:6px }

    @media(max-width:700px) {
        .form-row { grid-template-columns:1fr }
        .admins-table thead { display:none }
        .admins-table td { display:block; padding:8px 16px }
        .admins-table td:first-child { padding-top:16px }
        .admins-table td:last-child { padding-bottom:16px; border-bottom:1px solid var(--border) }
    }
</style>
@endpush

@section('content')
<div class="page-head">
    <div>
        <h1>Administrateurs</h1>
        <div class="sub">Gérez les comptes d'administration FeGArtisan</div>
    </div>
</div>

@if(session('success'))
    <div style="background:#ECFDF5;border:1px solid #A7F3D0;color:#065F46;padding:12px 18px;border-radius:10px;margin-bottom:20px;font-size:14px">
        ✓ {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div style="background:#FEF2F2;border:1px solid #FECACA;color:#991B1B;padding:12px 18px;border-radius:10px;margin-bottom:20px;font-size:14px">
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

{{-- Formulaire d'invitation --}}
<div class="invite-card">
    <h2>✉️ Inviter un nouvel administrateur</h2>
    <form method="POST" action="{{ route('admin.administrators.store') }}">
        @csrf
        <div class="form-row">
            <div class="form-group">
                <label>Prénom</label>
                <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="Ex: Jean" required>
            </div>
            <div class="form-group">
                <label>Nom</label>
                <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Ex: Dupont" required>
            </div>
        </div>
        <div class="form-group" style="margin-top:14px">
            <label>Adresse email</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@exemple.com" required>
        </div>

        <div class="toggle-row">
            <div class="toggle-row-text">
                <strong>Accès à la page Administrateurs</strong>
                <span>Ce compte pourra inviter et gérer d'autres administrateurs</span>
            </div>
            <label class="toggle-switch">
                <input type="checkbox" name="can_manage_admins" value="1" {{ old('can_manage_admins') ? 'checked' : '' }}>
                <span class="toggle-slider"></span>
            </label>
        </div>

        <div class="form-footer">
            <button type="submit" class="btn-invite">
                <i class="bi bi-send-fill" style="margin-right:6px"></i>Envoyer l'invitation
            </button>
        </div>
    </form>
</div>

{{-- Liste des admins --}}
<div class="card">
    <table class="admins-table">
        <thead>
            <tr>
                <th>Administrateur</th>
                <th>Statut</th>
                <th>Permissions</th>
                <th>Depuis</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($admins as $admin)
            <tr>
                <td>
                    <div class="admin-info">
                        <div class="admin-avatar">
                            {{ strtoupper(substr($admin->first_name ?? $admin->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="admin-name">
                                {{ $admin->name }}
                                @if($admin->id === auth()->id())
                                    <span class="you-badge">Vous</span>
                                @endif
                            </div>
                            <div class="admin-email">{{ $admin->email }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    @if($admin->is_active)
                        <span class="badge badge-green"><i class="bi bi-circle-fill" style="font-size:7px"></i> Actif</span>
                    @else
                        <span class="badge badge-red"><i class="bi bi-circle-fill" style="font-size:7px"></i> Suspendu</span>
                    @endif
                </td>
                <td>
                    @if($admin->can_manage_admins)
                        <span class="badge badge-purple"><i class="bi bi-shield-fill"></i> Peut gérer les admins</span>
                    @else
                        <span style="font-size:13px;color:var(--muted)">Standard</span>
                    @endif
                </td>
                <td style="color:var(--muted);font-size:13px">
                    {{ $admin->created_at->translatedFormat('j M Y') }}
                </td>
                <td>
                    @if($admin->id !== auth()->id())
                        <form method="POST" action="{{ route('admin.administrators.toggle-active', $admin) }}" style="display:inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="action-btn {{ $admin->is_active ? 'danger' : 'success' }}">
                                {{ $admin->is_active ? 'Suspendre' : 'Activer' }}
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.administrators.toggle-manage', $admin) }}" style="display:inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="action-btn purple">
                                {{ $admin->can_manage_admins ? 'Retirer accès admins' : 'Donner accès admins' }}
                            </button>
                        </form>
                    @else
                        <span style="font-size:12px;color:var(--muted)">—</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
