@extends('admin.layouts.app')
@section('title', 'Catégories')

@push('head')
<style>
    .page-head{display:flex;justify-content:space-between;align-items:flex-start;gap:16px;margin-bottom:18px;flex-wrap:wrap}
    .page-head h1{font-size:22px;font-weight:800;color:var(--ink);margin:0;letter-spacing:-.01em}
    .page-head .sub{color:var(--muted);font-size:13px;margin-top:3px}
    .page-head-right{display:flex;gap:10px;align-items:center;flex-wrap:wrap}

    .search-pill{
        display:flex;align-items:center;gap:8px;background:#fff;
        border:1px solid var(--line);border-radius:10px;padding:9px 14px;min-width:240px;
    }
    .search-pill i{color:var(--muted)}
    .search-pill input{border:none;outline:none;background:transparent;font-size:13px;flex:1;font-family:inherit;color:var(--ink)}

    .filters{display:flex;gap:8px;padding:14px 18px;border-bottom:1px solid var(--line);flex-wrap:wrap;align-items:center}
    .seg{display:flex;gap:6px;flex-wrap:wrap}
    .seg .seg-btn{border:1px solid var(--line);background:#fff;color:var(--text);padding:7px 16px;border-radius:9px;font-size:12.5px;font-weight:600;cursor:pointer;font-family:inherit;transition:all .2s;text-decoration:none}
    .seg .seg-btn:hover{border-color:var(--accent);color:var(--primary)}
    .seg .seg-btn.active{background:var(--primary);color:#fff;border-color:var(--primary)}

    .btn-add{
        background:linear-gradient(135deg,var(--primary),var(--secondary));color:#fff;
        border:none;padding:11px 18px;border-radius:10px;font-weight:600;font-size:13.5px;
        display:inline-flex;align-items:center;gap:8px;cursor:pointer;font-family:inherit;
        transition:all .2s;
    }
    .btn-add:hover{transform:translateY(-1px);box-shadow:0 6px 18px rgba(107,45,14,.25);color:#fff}

    .cat-list{display:flex;flex-direction:column}
    .cat-row{
        display:grid;grid-template-columns:72px 2fr 1.5fr 160px 110px auto;gap:18px;align-items:center;
        padding:14px 22px;border-bottom:1px solid rgba(232,213,192,.5);transition:background .15s;
    }
    .cat-row:last-child{border-bottom:none}
    .cat-row:hover{background:#FCF7EE}
    .cat-row.inactive{opacity:.55}

    .cat-thumb{
        width:60px;height:60px;border-radius:12px;overflow:hidden;flex-shrink:0;
        background:var(--bg-cream);display:flex;align-items:center;justify-content:center;
        color:var(--accent);font-size:22px;
    }
    .cat-thumb img{width:100%;height:100%;object-fit:cover;display:block}
    .cat-thumb.no-img{border:1px dashed var(--line)}

    .cat-info .nm{font-weight:700;color:var(--ink);font-size:14.5px;margin-bottom:3px}
    .cat-info .dsc{font-size:12.5px;color:var(--muted);line-height:1.4}
    .cat-branch{display:inline-flex;align-items:center;gap:4px;font-size:11px;font-weight:600;color:var(--primary);background:#FDF3E6;border:1px solid #F1E1CD;padding:2px 8px;border-radius:100px;margin-top:4px;width:fit-content}

    .cat-stats{display:flex;flex-direction:column;gap:6px}
    .cat-stats .count{font-weight:700;color:var(--ink);font-size:13px}
    .cat-stats .count small{color:var(--muted);font-weight:500}
    .cat-bar{height:4px;background:rgba(232,213,192,.5);border-radius:100px;overflow:hidden;width:140px}
    .cat-bar span{display:block;height:100%;background:linear-gradient(90deg,var(--primary),var(--accent));border-radius:100px}

    .cat-status{font-size:11.5px;font-weight:600;padding:4px 11px;border-radius:100px;display:inline-flex;align-items:center;gap:5px;width:fit-content}
    .cat-status::before{content:"";width:6px;height:6px;border-radius:50%;background:currentColor}
    .cat-status.ok{background:#E7F5EC;color:#2B6B43}
    .cat-status.off{background:#FEE4E0;color:#A8332A}

    .cat-actions{display:flex;gap:6px;justify-self:end}
    .cat-btn{
        width:32px;height:32px;border-radius:9px;border:none;cursor:pointer;font-family:inherit;
        display:flex;align-items:center;justify-content:center;font-size:13px;transition:all .2s;
    }
    .cat-btn.edit{background:var(--bg-cream);color:var(--primary)}
    .cat-btn.edit:hover{background:var(--primary);color:#fff}
    .cat-btn.toggle{background:#FDF3DD;color:#A77914}
    .cat-btn.toggle:hover{background:#E8A020;color:#fff}
    .cat-btn.del{background:#FEE4E0;color:#C94A3A}
    .cat-btn.del:hover{background:#C94A3A;color:#fff}
    .cat-btn.del:disabled{opacity:.4;cursor:not-allowed}

    /* Upload zone */
    .upload-zone{
        position:relative;border:2px dashed var(--line);border-radius:12px;padding:18px;
        display:flex;align-items:center;gap:14px;background:var(--bg-cream);
        cursor:pointer;transition:all .2s;
    }
    .upload-zone:hover{border-color:var(--accent);background:rgba(193,123,78,.04)}
    .upload-zone input[type=file]{position:absolute;inset:0;width:100%;height:100%;opacity:0;cursor:pointer}
    .upload-zone .up-ico{
        width:48px;height:48px;border-radius:10px;background:#fff;color:var(--accent);
        display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;
    }
    .upload-zone .up-text strong{display:block;color:var(--ink);font-size:13.5px;font-weight:600;margin-bottom:2px}
    .upload-zone .up-text span{font-size:11.5px;color:var(--muted)}
    .upload-preview{width:60px;height:60px;border-radius:10px;object-fit:cover;flex-shrink:0}

    /* Modal */
    .modal-content{border-radius:14px;border:none}
    .modal-header{background:var(--bg-cream);border-radius:14px 14px 0 0;border-bottom:1px solid var(--line)}
    .modal-title{color:var(--primary);font-weight:700}

    @media(max-width:900px){
        .cat-row{grid-template-columns:60px 1fr auto;gap:12px}
        .cat-stats,.cat-status-cell{display:none}
    }
</style>
@endpush

@section('content')

<div class="page-head">
    <div>
        <h1>Métiers</h1>
        <div class="sub">{{ $categories->where('is_active', true)->count() }} métier{{ $categories->where('is_active', true)->count() > 1 ? 's' : '' }} actif{{ $categories->where('is_active', true)->count() > 1 ? 's' : '' }} sur {{ $categories->count() }}</div>
    </div>
    <div class="page-head-right">
        <form method="GET" class="search-pill">
            @if(request('branch'))<input type="hidden" name="branch" value="{{ request('branch') }}">@endif
            @if(request('filter'))<input type="hidden" name="filter" value="{{ request('filter') }}">@endif
            <i class="bi bi-search"></i>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher un métier...">
        </form>
        <button type="button" class="btn-add" data-bs-toggle="modal" data-bs-target="#createModal">
            <i class="bi bi-plus-lg"></i> Nouveau métier
        </button>
    </div>
</div>

<div class="card-feg">
    <div class="card-head">
        <h3>Toutes les catégories</h3>
    </div>

    <div class="filters" style="flex-direction:column;gap:10px;align-items:flex-start">
        {{-- Filtre par branche --}}
        <div class="seg">
            <a class="seg-btn {{ !request('branch') ? 'active' : '' }}"
               href="{{ request()->fullUrlWithQuery(['branch'=>null,'filter'=>request('filter'),'q'=>request('q')]) }}">
               Toutes les branches
            </a>
            @foreach($branches as $b)
                <a class="seg-btn {{ request('branch') == $b->id ? 'active' : '' }}"
                   href="{{ request()->fullUrlWithQuery(['branch'=>$b->id,'filter'=>request('filter'),'q'=>request('q')]) }}">
                   {{ $b->name }}
                </a>
            @endforeach
        </div>
        {{-- Filtre par statut --}}
        <div class="seg">
            @if(request('q'))<input type="hidden" name="q" value="{{ request('q') }}">@endif
            <a class="seg-btn {{ !request('filter') ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['filter'=>null]) }}">Tous</a>
            <a class="seg-btn {{ request('filter') === 'active' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['filter'=>'active']) }}">Actifs</a>
            <a class="seg-btn {{ request('filter') === 'inactive' ? 'active' : '' }}" href="{{ request()->fullUrlWithQuery(['filter'=>'inactive']) }}">Désactivés</a>
        </div>
    </div>

    @php $totalArtisans = max(1, $categories->sum('artisan_profiles_count')); @endphp

    <div class="cat-list">
        @forelse($categories as $c)
            @php $pct = round($c->artisan_profiles_count / $totalArtisans * 100); @endphp
            <div class="cat-row {{ $c->is_active ? '' : 'inactive' }}">
                <div class="cat-thumb {{ $c->image ? '' : 'no-img' }}">
                    @if($c->image)
                        <img src="{{ asset('storage/'.$c->image) }}" alt="{{ $c->name }}">
                    @else
                        <i class="bi bi-tools"></i>
                    @endif
                </div>

                <div class="cat-info">
                    <div class="nm">{{ $c->name }}</div>
                    @if($c->description)
                        <div class="dsc">{{ Str::limit($c->description, 80) }}</div>
                    @endif
                    @if($c->parent)
                        <div class="cat-branch"><i class="bi bi-diagram-2"></i> {{ $c->parent->name }}</div>
                    @endif
                </div>

                <div class="cat-stats">
                    <div class="count">{{ $c->artisan_profiles_count }} <small>artisan{{ $c->artisan_profiles_count > 1 ? 's' : '' }} · {{ $pct }}%</small></div>
                    <div class="cat-bar"><span style="width:{{ min(100, $pct) }}%"></span></div>
                </div>

                <div class="cat-status-cell">
                    @if($c->is_active)
                        <span class="cat-status ok">Active</span>
                    @else
                        <span class="cat-status off">Désactivée</span>
                    @endif
                </div>

                <div style="color:var(--muted);font-size:12px">
                    {{ $c->created_at->translatedFormat('M Y') }}
                </div>

                <div class="cat-actions">
                    <button class="cat-btn edit" data-bs-toggle="modal" data-bs-target="#editModal{{ $c->id }}" title="Modifier">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <form action="{{ route('admin.categories.toggle', $c) }}" method="POST" style="margin:0">
                        @csrf @method('PATCH')
                        <button class="cat-btn toggle" title="{{ $c->is_active ? 'Désactiver' : 'Activer' }}">
                            <i class="bi {{ $c->is_active ? 'bi-eye-slash' : 'bi-eye' }}"></i>
                        </button>
                    </form>
                    <button class="cat-btn del"
                            {{ $c->artisan_profiles_count > 0 ? 'disabled' : '' }}
                            title="{{ $c->artisan_profiles_count > 0 ? 'Utilisée, désactivez plutôt' : 'Supprimer' }}"
                            onclick="confirmDelete('{{ route('admin.categories.destroy', $c) }}', '{{ addslashes($c->name) }}')">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        @empty
            <div style="padding:40px;text-align:center;color:var(--muted)">
                <i class="bi bi-inbox"></i> Aucune catégorie
            </div>
        @endforelse
    </div>
</div>

{{-- Modal création --}}
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Nouvelle catégorie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Branche *</label>
                        <select name="parent_id" class="form-select" required>
                            <option value="">-- Choisir une branche --</option>
                            @foreach($branches as $b)
                                <option value="{{ $b->id }}">{{ $b->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nom du métier *</label>
                        <input type="text" name="name" class="form-control" required placeholder="Ex: Peintre en bâtiment">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Courte description..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Image</label>
                        <label class="upload-zone" data-preview="createPreview">
                            <input type="file" name="image" accept="image/jpeg,image/png,image/webp" onchange="previewImage(this,'createPreview')">
                            <div class="up-ico" id="createUpIco"><i class="bi bi-cloud-arrow-up"></i></div>
                            <div class="up-text" id="createUpText">
                                <strong>Cliquer pour ajouter une image</strong>
                                <span>JPG, PNG ou WEBP · Max 2 Mo</span>
                            </div>
                            <img id="createPreview" class="upload-preview" style="display:none" alt="">
                        </label>
                    </div>
                    @if($errors->any() && !$errors->hasBag())
                        <div class="alert alert-danger py-2 mb-0">{{ $errors->first() }}</div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn-add"><i class="bi bi-plus"></i> Créer</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modals édition --}}
@foreach($categories as $c)
<div class="modal fade" id="editModal{{ $c->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.categories.update', $c) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Modifier : {{ $c->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Branche *</label>
                        <select name="parent_id" class="form-select" required>
                            <option value="">-- Choisir une branche --</option>
                            @foreach($branches as $b)
                                <option value="{{ $b->id }}" {{ $c->parent_id == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nom du métier</label>
                        <input type="text" name="name" class="form-control" value="{{ $c->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control" rows="2">{{ $c->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Image</label>
                        <label class="upload-zone">
                            <input type="file" name="image" accept="image/jpeg,image/png,image/webp" onchange="previewImage(this,'editPreview{{ $c->id }}')">
                            <div class="up-ico"><i class="bi bi-cloud-arrow-up"></i></div>
                            <div class="up-text">
                                <strong>{{ $c->image ? 'Remplacer l\'image' : 'Ajouter une image' }}</strong>
                                <span>JPG, PNG ou WEBP · Max 2 Mo</span>
                            </div>
                            <img id="editPreview{{ $c->id }}" class="upload-preview"
                                 src="{{ $c->image ? asset('storage/'.$c->image) : '' }}"
                                 style="{{ $c->image ? '' : 'display:none' }}" alt="">
                        </label>
                        @if($c->image)
                        <label class="d-flex align-items-center gap-2 mt-2" style="font-size:12.5px;color:var(--muted)">
                            <input type="checkbox" name="remove_image" value="1"> Retirer l'image actuelle
                        </label>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn-add"><i class="bi bi-check"></i> Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection

{{-- Modal suppression --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px">
        <div class="modal-content" style="border-radius:16px;border:none;box-shadow:0 20px 60px rgba(44,26,14,.15)">
            <div class="modal-body" style="padding:32px 28px;text-align:center">
                <div style="width:56px;height:56px;border-radius:14px;background:#FEE4E0;display:flex;align-items:center;justify-content:center;margin:0 auto 18px;font-size:24px;color:#C94A3A">
                    <i class="bi bi-trash3"></i>
                </div>
                <h5 style="font-weight:800;color:var(--ink);margin-bottom:8px;font-size:17px">Supprimer ce métier ?</h5>
                <p style="color:var(--muted);font-size:13.5px;margin-bottom:24px">
                    Vous allez supprimer <strong id="deleteTargetName" style="color:var(--ink)"></strong>. Cette action est irréversible.
                </p>
                <div style="display:flex;gap:10px;justify-content:center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius:10px;font-weight:600;padding:10px 22px">
                        Annuler
                    </button>
                    <form id="deleteForm" method="POST" style="margin:0">
                        @csrf @method('DELETE')
                        <button type="submit" style="background:#C94A3A;color:#fff;border:none;border-radius:10px;font-weight:700;padding:10px 22px;cursor:pointer;font-family:inherit;display:inline-flex;align-items:center;gap:7px">
                            <i class="bi bi-trash3"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function previewImage(input, previewId) {
        const file = input.files?.[0];
        if (!file) return;
        const img = document.getElementById(previewId);
        if (img) {
            img.src = URL.createObjectURL(file);
            img.style.display = 'block';
        }
    }

    function confirmDelete(action, name) {
        document.getElementById('deleteForm').action = action;
        document.getElementById('deleteTargetName').textContent = name;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    }
</script>
@endpush
