@extends('admin.layouts.app')
@section('title', 'Mon profil')

@push('head')
<style>
    .page-head{display:flex;justify-content:space-between;align-items:flex-start;gap:16px;margin-bottom:18px;flex-wrap:wrap}
    .page-head h1{font-size:22px;font-weight:800;color:var(--ink);margin:0;letter-spacing:-.01em}
    .page-head .sub{color:var(--muted);font-size:13px;margin-top:3px}

    .profile-grid{display:grid;grid-template-columns:340px 1fr;gap:18px}
    @media(max-width:960px){.profile-grid{grid-template-columns:1fr}}

    /* ═════ ASIDE ═════ */
    .p-card{background:#fff;border-radius:16px;border:1px solid rgba(232,213,192,.55);padding:24px;margin-bottom:16px}

    .p-identity{display:flex;flex-direction:column;align-items:center;text-align:center;padding:6px 0 4px}
    .p-avatar{
        position:relative;width:110px;height:110px;border-radius:28px;
        background:linear-gradient(135deg,var(--accent),var(--secondary));
        color:#fff;display:flex;align-items:center;justify-content:center;
        font-weight:800;font-size:42px;margin-bottom:14px;
        box-shadow:0 12px 24px rgba(107,45,14,.22);overflow:hidden;
    }
    .p-avatar img{width:100%;height:100%;object-fit:cover}
    .p-avatar-edit{
        position:absolute;bottom:-2px;right:-2px;width:34px;height:34px;border-radius:50%;
        background:#fff;color:var(--primary);border:3px solid var(--bg);
        display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:14px;
        transition:all .2s;box-shadow:0 4px 10px rgba(0,0,0,.1);
    }
    .p-avatar-edit:hover{background:var(--primary);color:#fff}
    .p-avatar-edit input{position:absolute;inset:0;opacity:0;cursor:pointer}

    .p-name{font-size:19px;font-weight:800;color:var(--ink);margin-bottom:4px}
    .p-role{
        display:inline-flex;align-items:center;gap:6px;
        background:var(--bg-cream);color:var(--primary);
        padding:5px 14px;border-radius:100px;font-size:11.5px;font-weight:600;letter-spacing:.02em;
    }

    .p-section-title{font-size:11px;letter-spacing:.25em;text-transform:uppercase;color:var(--muted);font-weight:600;margin-bottom:10px;margin-top:14px}

    .p-meta-row{display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid rgba(232,213,192,.4);font-size:13px}
    .p-meta-row:last-child{border-bottom:none}
    .p-meta-row i{width:28px;height:28px;border-radius:8px;background:var(--bg-cream);color:var(--accent);display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0}
    .p-meta-row .lbl{color:var(--muted);min-width:70px;font-size:12px}
    .p-meta-row .val{color:var(--ink);font-weight:500;word-break:break-all}

    .p-stat{display:flex;align-items:center;gap:12px;padding:11px 0;border-bottom:1px solid rgba(232,213,192,.4)}
    .p-stat:last-child{border-bottom:none}
    .p-stat .ico{width:36px;height:36px;border-radius:10px;background:var(--bg-cream);color:var(--primary);display:flex;align-items:center;justify-content:center;font-size:15px}
    .p-stat .body{flex:1;min-width:0}
    .p-stat .val{font-weight:800;color:var(--ink);font-size:16px;line-height:1}
    .p-stat .lbl{color:var(--muted);font-size:11.5px;margin-top:2px}

    .btn-logout{
        width:100%;display:flex;align-items:center;justify-content:center;gap:8px;
        background:#FEE4E0;color:#A8332A;border:none;padding:11px 14px;border-radius:10px;
        font-weight:600;font-size:13px;cursor:pointer;font-family:inherit;transition:all .2s;
    }
    .btn-logout:hover{background:#C94A3A;color:#fff}

    /* ═════ MAIN ═════ */
    .card-head h3{margin:0;font-size:15px;font-weight:700;color:var(--ink)}
    .card-body{padding:4px 22px 22px}

    .field{margin-bottom:16px}
    .field label{display:block;font-size:11px;letter-spacing:.2em;text-transform:uppercase;color:var(--muted);font-weight:600;margin-bottom:8px}
    .field input, .field textarea{
        width:100%;border:1.5px solid var(--line);background:#fff;border-radius:10px;
        padding:11px 14px;font-size:13.5px;font-family:inherit;color:var(--ink);outline:none;transition:all .15s;
    }
    .field input:focus, .field textarea:focus{border-color:var(--accent);background:#fff;box-shadow:0 0 0 3px rgba(193,123,78,.1)}
    .field .hint{font-size:11.5px;color:var(--muted);margin-top:5px}
    .field.err input{border-color:#C94A3A}
    .field.err .hint{color:#A8332A}

    .row-2{display:grid;grid-template-columns:1fr 1fr;gap:14px}
    @media(max-width:600px){.row-2{grid-template-columns:1fr}}

    .form-actions{display:flex;gap:10px;justify-content:flex-end;margin-top:8px;padding-top:16px;border-top:1px solid var(--line)}
    .btn-save{background:linear-gradient(135deg,var(--primary),var(--secondary));color:#fff;border:none;padding:10px 20px;border-radius:10px;font-weight:600;font-size:13px;display:inline-flex;align-items:center;gap:8px;cursor:pointer;font-family:inherit;transition:all .2s}
    .btn-save:hover{transform:translateY(-1px);box-shadow:0 6px 16px rgba(107,45,14,.25)}
    .btn-ghost{background:transparent;color:var(--muted);border:1px solid var(--line);padding:10px 18px;border-radius:10px;font-weight:600;font-size:13px;cursor:pointer;font-family:inherit;transition:all .2s}
    .btn-ghost:hover{border-color:var(--primary);color:var(--primary)}

    .danger-zone{border:1px solid #FCA5A5;background:#FEF2F2;border-radius:12px;padding:16px;margin-top:16px}
    .danger-zone h4{color:#991B1B;font-size:13px;font-weight:700;margin:0 0 6px}
    .danger-zone p{color:#A8332A;font-size:12.5px;margin:0}
</style>
@endpush

@section('content')

<div class="page-head">
    <div>
        <h1>Mon profil</h1>
        <div class="sub">Gérez vos informations personnelles et votre sécurité</div>
    </div>
</div>

<div class="profile-grid">

    {{-- ═════ ASIDE ═════ --}}
    <aside>
        <div class="p-card">
            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" id="avatarForm">
                @csrf
                <div class="p-identity">
                    <div class="p-avatar">
                        @if($user->avatar)
                            <img src="{{ asset('storage/'.$user->avatar) }}" alt="{{ $user->name }}" id="avatarPreview">
                        @else
                            <span id="avatarInitials">{{ mb_strtoupper(mb_substr($user->first_name ?? 'A', 0, 1).mb_substr($user->last_name ?? '', 0, 1)) ?: 'A' }}</span>
                        @endif
                        <label class="p-avatar-edit" title="Changer la photo">
                            <i class="bi bi-camera-fill"></i>
                            <input type="file" name="avatar" accept="image/jpeg,image/png,image/webp" onchange="previewAvatar(this);document.getElementById('avatarForm').submit()">
                        </label>
                    </div>
                    <div class="p-name">{{ $user->name }}</div>
                    <span class="p-role"><i class="bi bi-shield-lock-fill" style="font-size:10px"></i> {{ ucfirst($user->role) }}</span>
                </div>

                {{-- keep hidden name fields to satisfy update endpoint on avatar-only submit --}}
                <input type="hidden" name="first_name" value="{{ $user->first_name }}">
                <input type="hidden" name="last_name" value="{{ $user->last_name }}">
                <input type="hidden" name="email" value="{{ $user->email }}">
                <input type="hidden" name="phone" value="{{ $user->phone }}">
                <input type="hidden" name="ville" value="{{ $user->ville }}">
            </form>

            <div class="p-section-title">Contact</div>
            <div class="p-meta-row">
                <i class="bi bi-envelope"></i>
                <span class="lbl">Email</span>
                <span class="val">{{ $user->email }}</span>
            </div>
            @if($user->phone)
            <div class="p-meta-row">
                <i class="bi bi-telephone"></i>
                <span class="lbl">Téléphone</span>
                <span class="val">{{ $user->phone }}</span>
            </div>
            @endif
            @if($user->ville)
            <div class="p-meta-row">
                <i class="bi bi-geo-alt"></i>
                <span class="lbl">Ville</span>
                <span class="val">{{ $user->ville }}</span>
            </div>
            @endif
            <div class="p-meta-row">
                <i class="bi bi-calendar"></i>
                <span class="lbl">Inscrit</span>
                <span class="val">{{ $user->created_at->translatedFormat('M Y') }}</span>
            </div>
        </div>

        <div class="p-card">
            <div class="p-section-title" style="margin-top:0">Statistiques</div>
            <div class="p-stat">
                <div class="ico"><i class="bi bi-patch-check"></i></div>
                <div class="body">
                    <div class="val">{{ number_format($stats['artisans_validated'], 0, ',', ' ') }}</div>
                    <div class="lbl">Artisans validés sur la plateforme</div>
                </div>
            </div>
            <div class="p-stat">
                <div class="ico"><i class="bi bi-flag"></i></div>
                <div class="body">
                    <div class="val">{{ number_format($stats['reports_handled'], 0, ',', ' ') }}</div>
                    <div class="lbl">Signalements traités</div>
                </div>
            </div>
            <div class="p-stat">
                <div class="ico"><i class="bi bi-people"></i></div>
                <div class="body">
                    <div class="val">{{ number_format($stats['total_users'], 0, ',', ' ') }}</div>
                    <div class="lbl">Utilisateurs total</div>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout"><i class="bi bi-box-arrow-right"></i> Se déconnecter</button>
        </form>
    </aside>

    {{-- ═════ MAIN ═════ --}}
    <div>
        {{-- Informations --}}
        <div class="card-feg" style="margin-bottom:16px">
            <div class="card-head">
                <h3>Informations personnelles</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row-2">
                        <div class="field {{ $errors->has('first_name') ? 'err' : '' }}">
                            <label>Prénom</label>
                            <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
                            @error('first_name')<div class="hint">{{ $message }}</div>@enderror
                        </div>
                        <div class="field {{ $errors->has('last_name') ? 'err' : '' }}">
                            <label>Nom</label>
                            <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
                            @error('last_name')<div class="hint">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="field {{ $errors->has('email') ? 'err' : '' }}">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')<div class="hint">{{ $message }}</div>@enderror
                    </div>
                    <div class="row-2">
                        <div class="field">
                            <label>Téléphone</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+229 ...">
                        </div>
                        <div class="field">
                            <label>Ville</label>
                            <input type="text" name="ville" value="{{ old('ville', $user->ville) }}" placeholder="Cotonou">
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="reset" class="btn-ghost">Annuler</button>
                        <button type="submit" class="btn-save"><i class="bi bi-check-lg"></i> Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Mot de passe --}}
        <div class="card-feg">
            <div class="card-head">
                <h3>Sécurité</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.profile.password') }}" method="POST">
                    @csrf
                    <div class="field {{ $errors->has('current_password') ? 'err' : '' }}">
                        <label>Mot de passe actuel</label>
                        <input type="password" name="current_password" required autocomplete="current-password">
                        @error('current_password')<div class="hint">{{ $message }}</div>@enderror
                    </div>
                    <div class="row-2">
                        <div class="field {{ $errors->has('password') ? 'err' : '' }}">
                            <label>Nouveau mot de passe</label>
                            <input type="password" name="password" required autocomplete="new-password">
                            @error('password')<div class="hint">{{ $message }}</div>@enderror
                        </div>
                        <div class="field">
                            <label>Confirmer</label>
                            <input type="password" name="password_confirmation" required autocomplete="new-password">
                            <div class="hint">8 caractères minimum</div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn-save"><i class="bi bi-shield-check"></i> Modifier le mot de passe</button>
                    </div>
                </form>

                @if($user->avatar)
                <div class="danger-zone">
                    <h4>Supprimer la photo</h4>
                    <p style="margin-bottom:10px">Retirer votre avatar actuel. Votre initiale s'affichera à la place.</p>
                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="first_name" value="{{ $user->first_name }}">
                        <input type="hidden" name="last_name" value="{{ $user->last_name }}">
                        <input type="hidden" name="email" value="{{ $user->email }}">
                        <input type="hidden" name="phone" value="{{ $user->phone }}">
                        <input type="hidden" name="ville" value="{{ $user->ville }}">
                        <input type="hidden" name="remove_avatar" value="1">
                        <button type="submit" class="btn-ghost" style="border-color:#FCA5A5;color:#A8332A">
                            <i class="bi bi-trash"></i> Retirer la photo
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>

        {{-- Suppression du compte --}}
        <div class="card-feg" id="delete-account" style="border-color:#FECACA">
            <div class="card-head" style="background:#FEF2F2">
                <h3 style="color:#991B1B">⚠️ Supprimer mon compte</h3>
            </div>
            <div class="card-body">
                <p style="color:#7F1D1D;font-size:13.5px;margin-bottom:16px;line-height:1.6">
                    Cette action est <strong>irréversible</strong>. Votre compte sera définitivement supprimé et vous serez déconnecté immédiatement.
                </p>
                <form action="{{ route('admin.profile.destroy') }}" method="POST"
                      data-confirm="Cette action est irréversible. Votre compte sera définitivement supprimé."
                      data-confirm-title="Supprimer mon compte">
                    @csrf
                    @method('DELETE')
                    <div class="field {{ $errors->has('confirm_password') ? 'err' : '' }}" style="max-width:360px;margin-bottom:12px">
                        <label>Confirmez votre mot de passe</label>
                        <input type="password" name="confirm_password" placeholder="Votre mot de passe actuel" required>
                        @error('confirm_password')<div class="hint">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn-ghost" style="border-color:#EF4444;color:#DC2626;font-weight:700">
                        <i class="bi bi-trash3-fill"></i> Supprimer définitivement mon compte
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
    function previewAvatar(input) {
        const file = input.files?.[0];
        if (!file) return;
        const img = document.getElementById('avatarPreview');
        if (img) {
            img.src = URL.createObjectURL(file);
        }
    }
</script>
@endpush
