<?php

namespace App\Http\Controllers\Api;

use App\Events\NewNotification;
use App\Events\PublicationLiked;
use App\Http\Controllers\Controller;
use App\Models\Publication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublicationController extends Controller
{
    /**
     * Feed — fil de publications pour l'accueil client
     * GET /api/publications
     */
    public function index(Request $request): JsonResponse
    {
        $userId = $request->user()?->id;

        $query = Publication::with([
                'artisanProfile.user:id,first_name,last_name,avatar,ville,quartier',
                'artisanProfile.category:id,name',
            ])
            ->where('is_active', true)
            ->whereHas('artisanProfile', fn($q) => $q->where('validation_status', 'approved'))
            ->withCount('topLevelComments')
            ->latest();

        $publications = $query->paginate(15);

        // Ajouter liked_by_me
        if ($userId) {
            $ids = $publications->pluck('id');
            $likedIds = \App\Models\PublicationLike::where('user_id', $userId)
                ->whereIn('publication_id', $ids)
                ->pluck('publication_id')
                ->toArray();
            $publications->getCollection()->each(function ($pub) use ($likedIds) {
                $pub->liked_by_me = in_array($pub->id, $likedIds);
            });
        }

        return response()->json($publications);
    }

    public function show(Publication $publication, Request $request): JsonResponse
    {
        $publication->load([
            'artisanProfile.user:id,first_name,last_name,avatar,ville,quartier',
            'artisanProfile.category:id,name',
        ]);

        if ($userId = $request->user()?->id) {
            $publication->liked_by_me = $publication->isLikedBy($userId);
        }

        return response()->json(['publication' => $publication]);
    }

    /**
     * Création d'une publication par l'artisan
     * POST /api/artisan/publications
     */
    public function store(Request $request): JsonResponse
    {
        $profile = $request->user()->artisanProfile;

        if (!$profile || !$profile->isApproved()) {
            return response()->json(['message' => 'Votre compte doit être validé pour publier.'], 403);
        }

        $validated = $request->validate([
            'type' => ['required', 'in:text,image,video'],
            'content' => ['required_if:type,text', 'nullable', 'string', 'max:2000'],
            'media' => ['required_if:type,image,video', 'nullable', 'file', 'max:20480'],
        ]);

        $mediaUrl = null;
        if ($request->hasFile('media')) {
            $mediaUrl = $request->file('media')->store('publications', 'public');
        }

        $publication = $profile->publications()->create([
            'type' => $validated['type'],
            'content' => $validated['content'] ?? null,
            'media_url' => $mediaUrl,
            'is_active' => true,
        ]);

        return response()->json([
            'message' => 'Publication créée.',
            'publication' => $publication,
        ], 201);
    }

    public function update(Publication $publication, Request $request): JsonResponse
    {
        $profile = $request->user()->artisanProfile;
        if (!$profile || $publication->artisan_profile_id !== $profile->id) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $validated = $request->validate([
            'content' => ['sometimes', 'nullable', 'string', 'max:2000'],
            'media' => ['sometimes', 'nullable', 'file', 'max:20480'],
        ]);

        if ($request->hasFile('media')) {
            $validated['media_url'] = $request->file('media')->store('publications', 'public');
        }

        $publication->update($validated);

        return response()->json([
            'message' => 'Publication mise à jour.',
            'publication' => $publication->fresh(),
        ]);
    }

    public function destroy(Publication $publication, Request $request): JsonResponse
    {
        $profile = $request->user()->artisanProfile;
        if (!$profile || $publication->artisan_profile_id !== $profile->id) {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $publication->delete();

        return response()->json(['message' => 'Publication supprimée.']);
    }

    /**
     * Toggle like sur une publication
     * POST /api/publications/{id}/like
     */
    public function toggleLike(Publication $publication, Request $request): JsonResponse
    {
        $userId = $request->user()->id;

        $existing = \App\Models\PublicationLike::where('user_id', $userId)
            ->where('publication_id', $publication->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $liked = false;
        } else {
            \App\Models\PublicationLike::create([
                'user_id' => $userId,
                'publication_id' => $publication->id,
            ]);
            $liked = true;
        }

        $publication->refresh();
        $publication->load('artisanProfile');

        broadcast(new PublicationLiked($publication, $request->user(), $liked))->toOthers();

        return response()->json([
            'liked' => $liked,
            'likes_count' => $publication->likes_count,
        ]);
    }

    /**
     * Partage (incrémente le compteur)
     * POST /api/publications/{id}/share
     */
    public function share(Publication $publication): JsonResponse
    {
        $publication->increment('shares_count');

        return response()->json([
            'shares_count' => $publication->fresh()->shares_count,
            'share_url' => url("/p/{$publication->id}"),
        ]);
    }

    /**
     * Mes publications (artisan)
     * GET /api/artisan/publications
     */
    public function mine(Request $request): JsonResponse
    {
        $profile = $request->user()->artisanProfile;
        if (!$profile) {
            return response()->json(['message' => 'Profil artisan introuvable.'], 404);
        }

        $publications = $profile->publications()
            ->withCount('topLevelComments')
            ->latest()
            ->paginate(20);

        return response()->json($publications);
    }
}
