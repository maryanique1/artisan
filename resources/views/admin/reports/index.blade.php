@extends('admin.layouts.app')
@section('title', 'Signalements')

@push('head')
<style>
    .page-head{display:flex;justify-content:space-between;align-items:flex-start;gap:16px;margin-bottom:18px;flex-wrap:wrap}
    .page-head h1{font-size:22px;font-weight:800;color:var(--ink);margin:0;letter-spacing:-.01em}
    .page-head .sub{color:var(--muted);font-size:13px;margin-top:3px}
    .count-chip{display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:100px;font-size:12px;font-weight:600}
    .count-chip.danger{background:#FEE4E0;color:#A8332A}
    .count-chip.warn{background:#FDF3DD;color:#A77914}

    .filters{display:flex;gap:8px;padding:14px 18px;border-bottom:1px solid var(--line);flex-wrap:wrap;align-items:center}
    .seg{display:flex;gap:6px;flex-wrap:wrap}
    .seg .seg-btn{border:1px solid var(--line);background:#fff;color:var(--text);padding:7px 16px;border-radius:9px;font-size:12.5px;font-weight:600;cursor:pointer;font-family:inherit;transition:all .2s;text-decoration:none}
    .seg .seg-btn:hover{border-color:var(--accent);color:var(--primary)}
    .seg .seg-btn.active{background:var(--primary);color:#fff;border-color:var(--primary)}

    .cell-user{display:flex;align-items:center;gap:10px}
    .cell-user .nm{font-weight:600;color:var(--ink);font-size:13px;line-height:1.3}
    .cell-user .sub{font-size:11px;color:var(--muted)}

    .avatar-sq.p1{background:linear-gradient(135deg,#C17B4E,#8B3D1A)}
    .avatar-sq.p2{background:linear-gradient(135deg,#4A7C59,#2D5A3C)}
    .avatar-sq.p3{background:linear-gradient(135deg,#2C4A6B,#1A2F48)}
    .avatar-sq.p4{background:linear-gradient(135deg,#8B3D1A,#5A2610)}
    .avatar-sq.p5{background:linear-gradient(135deg,#6B2D0E,#3A1608)}

    .st-chip{display:inline-flex;align-items:center;gap:5px;padding:4px 11px;border-radius:100px;font-size:11.5px;font-weight:600;white-space:nowrap}
    .st-chip::before{content:"";width:6px;height:6px;border-radius:50%;background:currentColor}
    .st-chip.warn{background:#FDF3DD;color:#A77914}
    .st-chip.ok{background:#E7F5EC;color:#2B6B43}
    .st-chip.danger{background:#FEE4E0;color:#A8332A}
    .st-chip.neutral{background:var(--bg-cream);color:var(--primary)}
    .st-chip.info{background:#E1EDF7;color:#2C5A85}

    .type-chip{display:inline-flex;align-items:center;gap:5px;padding:4px 11px;border-radius:100px;font-size:11.5px;font-weight:600}
    .type-chip.pub{background:#FEE4E0;color:#A8332A}
    .type-chip.pub::before{content:"";width:6px;height:6px;border-radius:50%;background:currentColor}
    .type-chip.prof{background:#FDF3DD;color:#A77914}
    .type-chip.prof::before{content:"";width:6px;height:6px;border-radius:50%;background:currentColor}

    .act-btn{display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:9px;font-size:12px;font-weight:600;border:none;cursor:pointer;text-decoration:none;font-family:inherit;transition:all .2s}
    .act-view{background:var(--bg-cream);color:var(--primary)}
    .act-view:hover{background:var(--primary);color:#fff}
    .act-warn{background:#FDF3DD;color:#A77914}
    .act-warn:hover{background:#E8A020;color:#fff}
    .act-ok{background:#E7F5EC;color:#2B6B43}
    .act-ok:hover{background:#4A7C59;color:#fff}
    .act-danger{background:#FEE4E0;color:#A8332A}
    .act-danger:hover{background:#C94A3A;color:#fff}

    .pager{display:flex;justify-content:space-between;align-items:center;padding:14px 18px;border-top:1px solid var(--line);gap:10px;flex-wrap:wrap}
    .pager-info{font-size:12.5px;color:var(--muted)}
    .pager .pagination{margin:0;gap:4px;flex-wrap:wrap}
    .pager .page-link{border:1px solid var(--line);color:var(--text);background:#fff;padding:6px 12px;font-size:12.5px;border-radius:8px !important}
    .pager .page-item.active .page-link{background:var(--primary);border-color:var(--primary);color:#fff}
    .pager .page-item.disabled .page-link{opacity:.5}
</style>
@endpush

@section('content')

<div class="page-head">
    <div>
        <h1>Signalements</h1>
        <div class="sub">{{ $countPending }} signalement{{ $countPending > 1 ? 's' : '' }} non traité{{ $countPending > 1 ? 's' : '' }}</div>
    </div>
    @if($countPending > 0)
        <span class="count-chip danger">{{ $countPending }} urgent{{ $countPending > 1 ? 's' : '' }}</span>
    @endif
</div>

<div class="card-feg">
    <div class="card-head">
        <h3>Tous les signalements</h3>
        <div style="display:flex;gap:8px">
            @if($countPending > 0)
                <span class="count-chip danger">{{ $countPending }} non traité{{ $countPending > 1 ? 's' : '' }}</span>
            @endif
            <span class="count-chip warn">{{ $countHandled }} traité{{ $countHandled > 1 ? 's' : '' }}</span>
        </div>
    </div>

    <form method="GET" class="filters">
        <div class="seg">
            <a class="seg-btn {{ request('status') === 'pending' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['status'=>'pending','target_type'=>null]) }}">Non traités</a>
            <a class="seg-btn {{ !request('status') && !request('target_type') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">Tous</a>
            <a class="seg-btn {{ request('target_type') === 'profile' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['target_type'=>'profile','status'=>null]) }}">Profils</a>
            <a class="seg-btn {{ request('target_type') === 'publication' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['target_type'=>'publication','status'=>null]) }}">Publications</a>
        </div>
    </form>

    <div style="overflow-x:auto">
    <table class="table-feg">
        <thead>
            <tr>
                <th>Signalé par</th>
                <th>Cible</th>
                <th>Type</th>
                <th>Motif</th>
                <th>Date</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reports as $i => $r)
            @php
                $reporter = $r->reporter;
                $target = $r->target;
                $targetUser = $r->target_type === 'profile' ? $target?->user : $target?->artisanProfile?->user;
                $targetName = $r->target_type === 'publication'
                    ? ('Publication #'.$r->target_id)
                    : ($targetUser?->name ?? 'Profil #'.$r->target_id);
                $targetSub = $r->target_type === 'publication'
                    ? ($targetUser?->name ?? 'Inconnu')
                    : 'Profil artisan';
            @endphp
            <tr>
                <td>
                    <div class="cell-user">
                        <div class="avatar-sq p{{ ($i % 5) + 1 }}">{{ mb_strtoupper(mb_substr($reporter->first_name ?? $reporter->name, 0, 1)) }}</div>
                        <div>
                            <div class="nm">{{ $reporter->name }}</div>
                            <div class="sub">{{ ucfirst($reporter->role) }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="cell-user">
                        @if($targetUser)
                            <div class="avatar-sq p{{ (($i+2) % 5) + 1 }}">{{ mb_strtoupper(mb_substr($targetUser->first_name ?? $targetUser->name, 0, 1)) }}</div>
                        @else
                            <div class="avatar-sq p1"><i class="bi bi-question"></i></div>
                        @endif
                        <div>
                            <div class="nm">{{ $targetName }}</div>
                            <div class="sub">{{ $targetSub }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    @if($r->target_type === 'publication')
                        <span class="type-chip pub">Publication</span>
                    @else
                        <span class="type-chip prof">Profil</span>
                    @endif
                </td>
                <td style="max-width:200px">{{ Str::limit($r->reason, 40) }}</td>
                <td style="color:var(--muted)">
                    @php
                        $c = $r->created_at;
                        $label = $c->isToday() ? "Aujourd'hui" : ($c->isYesterday() ? "Hier" : "Il y a ".(int)$c->diffInDays(now())."j");
                    @endphp
                    {{ $label }}
                </td>
                <td>
                    @php
                        $statusMap = [
                            'pending' => ['warn', 'En attente'],
                            'reviewed' => ['info', 'Examiné'],
                            'resolved' => ['ok', 'Résolu'],
                            'dismissed' => ['neutral', 'Rejeté'],
                        ];
                        [$cls, $lbl] = $statusMap[$r->status] ?? ['neutral', ucfirst($r->status)];
                    @endphp
                    <span class="st-chip {{ $cls }}">{{ $lbl }}</span>
                </td>
                <td>
                    <div style="display:flex;gap:6px;flex-wrap:wrap">
                        <button type="button" class="act-btn act-view" data-bs-toggle="modal" data-bs-target="#report{{ $r->id }}">
                            <i class="bi bi-eye"></i> Voir
                        </button>
                        @if($r->target_type === 'profile' && $targetUser)
                            <form action="{{ route('admin.users.toggle-active', $targetUser) }}" method="POST" style="margin:0">
                                @csrf @method('PATCH')
                                <button class="act-btn act-warn"><i class="bi bi-slash-circle"></i> Suspendre</button>
                            </form>
                        @elseif($r->target_type === 'publication' && $target)
                            <form action="{{ route('admin.publications.destroy', $target) }}" method="POST" style="margin:0" data-confirm="Supprimer cette publication ?">
                                @csrf @method('DELETE')
                                <button class="act-btn act-danger"><i class="bi bi-trash"></i> Supprimer</button>
                            </form>
                        @endif
                        <form action="{{ route('admin.reports.update', $r) }}" method="POST" style="margin:0">
                            @csrf @method('PUT')
                            <input type="hidden" name="status" value="dismissed">
                            <button class="act-btn act-ok"><i class="bi bi-check-lg"></i> Ignorer</button>
                        </form>
                    </div>
                </td>
            </tr>

            {{-- Modal détails --}}
            <div class="modal fade" id="report{{ $r->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content" style="border-radius:14px;border:none">
                        <form action="{{ route('admin.reports.update', $r) }}" method="POST">
                            @csrf @method('PUT')
                            <div class="modal-header" style="background:var(--bg-cream);border-radius:14px 14px 0 0">
                                <h5 class="modal-title" style="color:var(--primary);font-weight:700">Signalement #{{ $r->id }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Signalé par :</strong> {{ $reporter->name }}</p>
                                <p><strong>Cible :</strong> {{ $targetName }} — {{ $targetSub }}</p>
                                <p><strong>Motif :</strong> {{ $r->reason }}</p>
                                @if($r->description)<p><strong>Description :</strong> {{ $r->description }}</p>@endif
                                <hr>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Décision</label>
                                    <select name="status" class="form-select" required>
                                        <option value="reviewed" {{ $r->status === 'reviewed' ? 'selected' : '' }}>Examiné</option>
                                        <option value="resolved" {{ $r->status === 'resolved' ? 'selected' : '' }}>Résolu</option>
                                        <option value="dismissed" {{ $r->status === 'dismissed' ? 'selected' : '' }}>Rejeté</option>
                                    </select>
                                </div>
                                @if($r->target_type === 'publication')
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="delete_target" value="1" id="del{{ $r->id }}">
                                        <label class="form-check-label" for="del{{ $r->id }}">Supprimer la publication (si Résolu)</label>
                                    </div>
                                @endif
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Notes admin</label>
                                    <textarea name="admin_notes" class="form-control" rows="3">{{ $r->admin_notes }}</textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" class="act-btn act-view" style="padding:9px 18px">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <tr><td colspan="7" style="padding:40px;text-align:center;color:var(--muted)"><i class="bi bi-check-circle"></i> Aucun signalement</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>

    <div class="pager">
        <div class="pager-info">
            @if($reports->total() > 0)
                Affichage {{ $reports->firstItem() }}–{{ $reports->lastItem() }} sur {{ $reports->total() }} signalement{{ $reports->total() > 1 ? 's' : '' }}
            @endif
        </div>
        {{ $reports->withQueryString()->onEachSide(1)->links() }}
    </div>
</div>

@endsection
