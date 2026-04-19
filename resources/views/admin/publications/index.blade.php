@extends('admin.layouts.app')
@section('title', 'Publications')

@push('head')
<style>
    .page-head{display:flex;justify-content:space-between;align-items:flex-start;gap:16px;margin-bottom:18px;flex-wrap:wrap}
    .page-head h1{font-size:22px;font-weight:800;color:var(--ink);margin:0;letter-spacing:-.01em}
    .page-head .sub{color:var(--muted);font-size:13px;margin-top:3px}
    .page-head-right{display:flex;gap:10px;align-items:center;flex-wrap:wrap}
    .search-pill{display:flex;align-items:center;gap:8px;background:#fff;border:1px solid var(--line);border-radius:10px;padding:9px 14px;min-width:260px}
    .search-pill i{color:var(--muted)}
    .search-pill input{border:none;outline:none;background:transparent;font-size:13px;flex:1;font-family:inherit;color:var(--ink)}
    .count-chip{display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:100px;font-size:12px;font-weight:600}
    .count-chip.neutral{background:var(--bg-cream);color:var(--primary)}
    .count-chip.danger{background:#FEE4E0;color:#A8332A}

    .filters{display:flex;gap:8px;padding:14px 18px;border-bottom:1px solid var(--line);flex-wrap:wrap;align-items:center}
    .filters-right{margin-left:auto}
    .seg{display:flex;gap:6px;flex-wrap:wrap}
    .seg .seg-btn{border:1px solid var(--line);background:#fff;color:var(--text);padding:7px 16px;border-radius:9px;font-size:12.5px;font-weight:600;cursor:pointer;font-family:inherit;transition:all .2s;text-decoration:none}
    .seg .seg-btn:hover{border-color:var(--accent);color:var(--primary)}
    .seg .seg-btn.active{background:var(--primary);color:#fff;border-color:var(--primary)}
    .mini-select{border:1px solid var(--line);background:#fff;border-radius:9px;padding:7px 12px;font-size:12.5px;font-family:inherit;color:var(--ink);outline:none;min-width:160px}

    .thumb{
        width:48px;height:48px;border-radius:10px;flex-shrink:0;
        display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,.85);
    }
    .thumb.p1{background:linear-gradient(135deg,#E8B088,#C17B4E)}
    .thumb.p2{background:linear-gradient(135deg,#B4D4A2,#7BA35E)}
    .thumb.p3{background:linear-gradient(135deg,#A8C5DD,#6B8FB0)}
    .thumb.p4{background:linear-gradient(135deg,#D4B896,#A88868)}
    .thumb.p5{background:linear-gradient(135deg,#B8D4A8,#6B8F5E)}

    .pub-cell{display:flex;align-items:flex-start;gap:12px}
    .pub-cell .t{font-weight:600;color:var(--ink);font-size:13px;line-height:1.3;margin-bottom:3px}
    .pub-cell .sub{font-size:11.5px;color:var(--muted)}

    .art-cell{display:flex;align-items:center;gap:10px}
    .art-cell .nm{font-weight:600;color:var(--ink);font-size:12.5px}

    .avatar-sq.p1{background:linear-gradient(135deg,#C17B4E,#8B3D1A)}
    .avatar-sq.p2{background:linear-gradient(135deg,#4A7C59,#2D5A3C)}
    .avatar-sq.p3{background:linear-gradient(135deg,#2C4A6B,#1A2F48)}
    .avatar-sq.p4{background:linear-gradient(135deg,#8B3D1A,#5A2610)}
    .avatar-sq.p5{background:linear-gradient(135deg,#6B2D0E,#3A1608)}

    .metrics{font-size:12px;color:var(--muted);white-space:nowrap;display:flex;align-items:center;gap:10px;flex-wrap:wrap}
    .metrics .m{display:inline-flex;align-items:center;gap:4px}
    .metrics .m i{font-size:13px}
    .metrics .m.heart i{color:#C94A3A}
    .metrics .m.chat i{color:var(--accent)}
    .metrics .m.eye i{color:var(--muted)}

    .st-chip{display:inline-flex;align-items:center;gap:5px;padding:4px 11px;border-radius:100px;font-size:11.5px;font-weight:600}
    .st-chip.danger{background:#FEE4E0;color:#A8332A}

    .act-btn{display:inline-flex;align-items:center;gap:5px;padding:6px 12px;border-radius:9px;font-size:12px;font-weight:600;border:none;cursor:pointer;text-decoration:none;font-family:inherit;transition:all .2s}
    .act-view{background:var(--bg-cream);color:var(--primary)}
    .act-view:hover{background:var(--primary);color:#fff}
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
        <h1>Publications</h1>
        <div class="sub">Modération des publications artisans</div>
    </div>
    <div class="page-head-right">
        <form method="GET" class="search-pill">
            @if(request('filter'))<input type="hidden" name="filter" value="{{ request('filter') }}">@endif
            <i class="bi bi-search"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher une publication...">
        </form>
        @if($totalReported > 0)
            <span class="count-chip danger">{{ $totalReported }} signalée{{ $totalReported > 1 ? 's' : '' }}</span>
        @endif
    </div>
</div>

<div class="card-feg">
    <div class="card-head">
        <h3>Toutes les publications ({{ number_format($publications->total(), 0, ',', ' ') }})</h3>
        <div style="display:flex;gap:8px">
            <span class="count-chip neutral">{{ $totalNormal }} normales</span>
            @if($totalReported > 0)
                <span class="count-chip danger">{{ $totalReported }} signalée{{ $totalReported > 1 ? 's' : '' }}</span>
            @endif
        </div>
    </div>

    <form method="GET" class="filters">
        @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}">@endif
        <div class="seg">
            <a class="seg-btn {{ !request('filter') ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['filter'=>null]) }}">Toutes</a>
            <a class="seg-btn {{ request('filter') === 'reported' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['filter'=>'reported']) }}">Signalées</a>
            <a class="seg-btn {{ request('filter') === 'recent' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['filter'=>'recent']) }}">Récentes</a>
        </div>
        <div class="filters-right">
            <select name="category" class="mini-select" onchange="this.form.submit()">
                <option value="">Toutes catégories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ (string)request('category') === (string)$cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
    </form>

    <div style="overflow-x:auto">
    <table class="table-feg">
        <thead>
            <tr>
                <th>Publication</th>
                <th>Artisan</th>
                <th>Catégorie</th>
                <th>Date</th>
                <th>Interactions</th>
                <th>Signalements</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($publications as $i => $p)
            @php
                $user = $p->artisanProfile?->user;
                $initial = $user ? mb_strtoupper(mb_substr($user->first_name ?? $user->name, 0, 1)) : '?';
                $hasMedia = (bool) $p->media_url;
                $typeLabel = $hasMedia ? 'Texte + '.($p->type === 'video' ? 'Vidéo' : 'Image') : 'Texte seulement';
                $thumbIcon = match($p->type) {
                    'video' => 'bi-camera-video',
                    'image' => 'bi-image',
                    default => 'bi-image'
                };
            @endphp
            <tr>
                <td>
                    <div class="pub-cell">
                        <div class="thumb p{{ ($i % 5) + 1 }}">
                            <i class="bi {{ $thumbIcon }}" style="font-size:20px"></i>
                        </div>
                        <div>
                            <div class="t">{{ Str::limit($p->content ?? '(média)', 48) }}</div>
                            <div class="sub">{{ $typeLabel }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="art-cell">
                        <div class="avatar-sq p{{ ($i % 5) + 1 }}">{{ $initial }}</div>
                        <div class="nm">{{ $user?->name ?? '—' }}</div>
                    </div>
                </td>
                <td>{{ $p->artisanProfile?->category?->name ?? '—' }}</td>
                <td style="color:var(--muted)">
                    @php
                        $c = $p->created_at;
                        $label = $c->isToday() ? "Aujourd'hui" : ($c->isYesterday() ? "Hier" : "Il y a ".(int)$c->diffInDays(now())."j");
                    @endphp
                    {{ $label }}
                </td>
                <td>
                    <div class="metrics">
                        <span class="m heart"><i class="bi bi-heart-fill"></i> {{ $p->likes_count ?? 0 }}</span>
                        <span class="m chat"><i class="bi bi-chat-fill"></i> {{ $p->comments_count ?? 0 }}</span>
                    </div>
                </td>
                <td>
                    @if($p->reports_count > 0)
                        <span class="st-chip danger"><i class="bi bi-exclamation-triangle-fill"></i> {{ $p->reports_count }} signalement{{ $p->reports_count > 1 ? 's' : '' }}</span>
                    @else
                        <span style="color:var(--muted);font-size:13px">—</span>
                    @endif
                </td>
                <td>
                    <div style="display:flex;gap:6px">
                        <button type="button" class="act-btn act-view" data-bs-toggle="modal" data-bs-target="#viewPub{{ $p->id }}">
                            <i class="bi bi-eye"></i> Voir
                        </button>
                        <form action="{{ route('admin.publications.destroy', $p) }}" method="POST" style="margin:0" onsubmit="return confirm('Supprimer cette publication ?')">
                            @csrf @method('DELETE')
                            <button class="act-btn act-danger"><i class="bi bi-trash"></i> Supprimer</button>
                        </form>
                    </div>
                </td>
            </tr>

            {{-- Modal voir --}}
            <div class="modal fade" id="viewPub{{ $p->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content" style="border-radius:14px;border:none">
                        <div class="modal-header" style="background:var(--bg-cream);border-radius:14px 14px 0 0">
                            <h5 class="modal-title" style="color:var(--primary);font-weight:700">Publication #{{ $p->id }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>Artisan :</strong> {{ $user?->name ?? '—' }}</p>
                            <p><strong>Catégorie :</strong> {{ $p->artisanProfile?->category?->name ?? '—' }}</p>
                            <p><strong>Date :</strong> {{ $p->created_at->format('d/m/Y H:i') }}</p>
                            <hr>
                            <p>{{ $p->content }}</p>
                            @if($p->media_url)
                                <img src="{{ asset('storage/'.$p->media_url) }}" alt="media" style="max-width:100%;border-radius:10px;margin-top:10px">
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @empty
            <tr><td colspan="7" style="padding:40px;text-align:center;color:var(--muted)"><i class="bi bi-inbox"></i> Aucune publication</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>

    <div class="pager">
        <div class="pager-info">
            @if($publications->total() > 0)
                Affichage {{ $publications->firstItem() }}–{{ $publications->lastItem() }} sur {{ number_format($publications->total(), 0, ',', ' ') }} publications
            @endif
        </div>
        {{ $publications->withQueryString()->onEachSide(1)->links() }}
    </div>
</div>

@endsection
