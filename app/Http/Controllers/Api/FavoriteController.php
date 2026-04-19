<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ArtisanProfile;
use App\Models\Favorite;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * Liste des artisans favoris
     * GET /api/favorites
     */
    public function index(Request $request): JsonResponse
    {
        $favorites = $request->user()
            ->favoriteArtisans()
            ->with(['user:id,first_name,last_name,avatar,phone', 'category:id,name'])
            ->where('validation_status', 'approved')
            ->paginate(20);

        return response()->json($favorites);
    }

    /**
     * Toggle favori
     * POST /api/favorites/{artisanProfile}
     */
    public function toggle(ArtisanProfile $artisanProfile, Request $request): JsonResponse
    {
        $userId = $request->user()->id;

        $existing = Favorite::where('user_id', $userId)
            ->where('artisan_profile_id', $artisanProfile->id)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['favorited' => false, 'message' => 'Retiré des favoris.']);
        }

        Favorite::create([
            'user_id' => $userId,
            'artisan_profile_id' => $artisanProfile->id,
        ]);

        return response()->json(['favorited' => true, 'message' => 'Ajouté aux favoris.']);
    }
}
