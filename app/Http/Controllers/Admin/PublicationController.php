<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Publication;
use App\Models\Report;
use Illuminate\Http\Request;

class PublicationController extends Controller
{
    public function index(Request $request)
    {
        $query = Publication::with(['artisanProfile.user', 'artisanProfile.category'])
            ->withCount(['likes', 'comments']);

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('category')) {
            $query->whereHas('artisanProfile', fn($q) => $q->where('category_id', $request->category));
        }

        if ($request->filled('search')) {
            $query->where('content', 'like', "%{$request->search}%");
        }

        // Filtre "signalées" / "récentes"
        if ($request->filled('filter')) {
            if ($request->filter === 'reported') {
                $reportedIds = Report::where('target_type', 'publication')->pluck('target_id')->unique();
                $query->whereIn('id', $reportedIds);
            } elseif ($request->filter === 'recent') {
                $query->latest()->limit(50);
            }
        }

        $publications = $query->latest()->paginate(20);

        // Compte de signalements pour chaque publication chargée
        $pubIds = $publications->pluck('id');
        $reportsByPub = Report::where('target_type', 'publication')
            ->whereIn('target_id', $pubIds)
            ->selectRaw('target_id, count(*) as c')
            ->groupBy('target_id')
            ->pluck('c', 'target_id');

        $publications->getCollection()->transform(function ($p) use ($reportsByPub) {
            $p->reports_count = $reportsByPub[$p->id] ?? 0;
            return $p;
        });

        $totalNormal = Publication::query()->whereNotIn('id',
            Report::where('target_type', 'publication')->pluck('target_id')
        )->count();
        $totalReported = Report::where('target_type', 'publication')->distinct('target_id')->count('target_id');

        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('admin.publications.index', compact(
            'publications', 'totalNormal', 'totalReported', 'categories'
        ));
    }

    public function destroy(Publication $publication)
    {
        $publication->delete();

        return back()->with('success', 'Publication supprimée.');
    }
}
