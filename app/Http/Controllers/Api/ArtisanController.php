<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ArtisanProfile;
use App\Models\SearchHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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
            ->whereHas('user', fn($q) => $q->where('is_active', true)->where('profile_visible', true));

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
                'user_id'     => $request->user()->id,
                'query'       => $request->q,
                'category_id' => $request->category_id,
                'ville'       => $request->ville,
                'quartier'    => $request->quartier,
            ]);
        }

        return response()->json($artisans);
    }

    public function show(ArtisanProfile $artisanProfile, Request $request): JsonResponse
    {
        // Respecter la préférence de confidentialité
        if (!$artisanProfile->user?->profile_visible) {
            return response()->json(['message' => 'Profil non disponible.'], 404);
        }

        $artisanProfile->load([
            'user:id,first_name,last_name,avatar,phone',
            'category:id,name',
            'reviews.client:id,first_name,last_name,avatar',
            'publications' => fn($q) => $q->where('is_active', true)->latest()->limit(10),
        ]);

        // Throttle views_count : 1 vue par IP et par profil toutes les heures
        $cacheKey = 'view_' . $request->ip() . '_' . $artisanProfile->id;
        if (!Cache::has($cacheKey)) {
            $artisanProfile->increment('views_count');
            Cache::put($cacheKey, true, now()->addHour());
        }

        $isFavorited = false;
        if ($user = $request->user()) {
            $isFavorited = \App\Models\Favorite::where('user_id', $user->id)
                ->where('artisan_profile_id', $artisanProfile->id)
                ->exists();
        }

        return response()->json([
            'artisan'        => $artisanProfile,
            'is_favorited'   => $isFavorited,
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

        $now = now();
        $weekAgo = $now->copy()->subDays(7);
        $twoWeeksAgo = $now->copy()->subDays(14);

        $reviewsThisWeek = $profile->reviews()->where('created_at', '>=', $weekAgo)->count();
        $reviewsLastWeek = $profile->reviews()->whereBetween('created_at', [$twoWeeksAgo, $weekAgo])->count();

        $pubsThisWeek = $profile->publications()->where('created_at', '>=', $weekAgo)->count();
        $pubsLastWeek = $profile->publications()->whereBetween('created_at', [$twoWeeksAgo, $weekAgo])->count();

        return response()->json([
            'profile' => $profile->load('category'),
            'stats' => [
                'views'             => $profile->views_count,
                'likes_received'    => $profile->totalLikesReceived(),
                'messages_unread'   => $user->artisanConversations()
                    ->withCount(['messages as u' => fn($q) => $q->where('is_read', false)->where('sender_id', '!=', $user->id)])
                    ->get()->sum('u'),
                'reviews_count'     => $profile->rating_count,
                'rating_avg'        => $profile->rating_avg,
                'publications_count' => $profile->publications()->count(),
            ],
            'deltas' => [
                'reviews_this_week'    => $reviewsThisWeek,
                'reviews_delta'        => $reviewsThisWeek - $reviewsLastWeek,
                'publications_this_week' => $pubsThisWeek,
                'publications_delta'   => $pubsThisWeek - $pubsLastWeek,
            ],
        ]);
    }
}
