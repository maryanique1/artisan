<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ArtisanProfile;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(ArtisanProfile $artisanProfile): JsonResponse
    {
        $reviews = $artisanProfile->reviews()
            ->with('client:id,first_name,last_name,avatar')
            ->latest()
            ->paginate(20);

        return response()->json($reviews);
    }

    public function store(ArtisanProfile $artisanProfile, Request $request): JsonResponse
    {
        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $existing = Review::where('client_id', $request->user()->id)
            ->where('artisan_profile_id', $artisanProfile->id)
            ->first();

        if ($existing) {
            $existing->update($validated);
            return response()->json([
                'message' => 'Avis mis à jour.',
                'review' => $existing->fresh()->load('client:id,first_name,last_name,avatar'),
            ]);
        }

        $review = Review::create([
            'client_id' => $request->user()->id,
            'artisan_profile_id' => $artisanProfile->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        return response()->json([
            'message' => 'Avis ajouté.',
            'review' => $review->load('client:id,first_name,last_name,avatar'),
        ], 201);
    }
}
