<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ArtisanProfile;
use App\Models\SearchHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArtisanController extends Controller
{
    /**
     * Recherche d'artisans (catégorie + ville/quartier)
     * GET /api/artisans
     */
    public function index(Request $request): JsonResponse
    {
        $query = ArtisanProfile::with(['user:id,first_name,last_name,avatar,phone', 'category:id,name'])
            ->where('validation_status', 'approved')
            ->whereHas('user', fn($q) => $q->where('is_active', true));

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('ville')) {
            $query->where('ville', 'like', "%{$request->ville}%");
        }

        if ($request->filled('quartier')) {
            $query->where('quartier', 'like', "%{$request->quartier}%");
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('metier', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhereHas('user', function ($u) use ($q) {
                        $u->where('first_name', 'like', "%{$q}%")
                          ->orWhere('last_name', 'like', "%{$q}%");
                    });
            });
        }

        $artisans = $query->latest()->paginate(20);

        // Enregistrer dans l'historique si utilisateur connecté + filtre
        if ($request->user() && ($request->filled('q') || $request->filled('category_id') || $request->filled('ville'))) {
            SearchHistory::create([
                'user_id' => $request->user()->id,
                'query' => $request->q,
                'category_id' => $request->category_id,
                'ville' => $request->ville,
                'quartier' => $request->quartier,
            ]);
        }

        return response()->json($artisans);
    }

    public function show(ArtisanProfile $artisanProfile, Request $request): JsonResponse
    {
        $artisanProfile->load([
            'user:id,first_name,last_name,avatar,phone,email',
            'category:id,name',
            'reviews.client:id,first_name,last_name,avatar',
            'publications' => fn($q) => $q->where('is_active', true)->latest()->limit(10),
        ]);

        $artisanProfile->increment('views_count');

        $isFavorited = false;
        if ($user = $request->user()) {
            $isFavorited = \App\Models\Favorite::where('user_id', $user->id)
                ->where('artisan_profile_id', $artisanProfile->id)
                ->exists();
        }

        return response()->json([
            'artisan' => $artisanProfile,
            'is_favorited' => $isFavorited,
            'likes_received' => $artisanProfile->totalLikesReceived(),
        ]);
    }

    /**
     * Historique de recherche
     * GET /api/search-history
     */
    public function searchHistory(Request $request): JsonResponse
    {
        $history = $request->user()
            ->searchHistory()
            ->with('category:id,name')
            ->latest()
            ->limit(20)
            ->get()
            ->unique(fn($h) => $h->query . '|' . $h->category_id . '|' . $h->ville)
            ->values();

        return response()->json(['history' => $history]);
    }

    /**
     * Dashboard stats artisan
     * GET /api/artisan/dashboard
     */
    public function dashboard(Request $request): JsonResponse
    {
        $user = $request->user();
        $profile = $user->artisanProfile;

        if (!$profile) {
            return response()->json(['message' => 'Profil artisan introuvable.'], 404);
        }

        return response()->json([
            'profile' => $profile->load('category'),
            'stats' => [
                'views' => $profile->views_count,
                'likes_received' => $profile->totalLikesReceived(),
                'messages_unread' => $user->artisanConversations()
                    ->withCount(['messages as u' => fn($q) => $q->where('is_read', false)->where('sender_id', '!=', $user->id)])
                    ->get()->sum('u'),
                'reviews_count' => $profile->rating_count,
                'rating_avg' => $profile->rating_avg,
                'publications_count' => $profile->publications()->count(),
            ],
        ]);
    }
}
