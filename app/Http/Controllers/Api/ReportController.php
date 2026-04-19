<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Signaler une publication ou un profil
     * POST /api/reports
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'target_type' => ['required', 'in:publication,profile'],
            'target_id' => ['required', 'integer'],
            'reason' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        // Vérifier que la cible existe
        if ($validated['target_type'] === 'publication') {
            $exists = \App\Models\Publication::where('id', $validated['target_id'])->exists();
        } else {
            $exists = \App\Models\ArtisanProfile::where('id', $validated['target_id'])->exists();
        }

        if (!$exists) {
            return response()->json(['message' => 'Cible introuvable.'], 404);
        }

        $report = Report::create([
            'reporter_id' => $request->user()->id,
            'target_type' => $validated['target_type'],
            'target_id' => $validated['target_id'],
            'reason' => $validated['reason'],
            'description' => $validated['description'] ?? null,
        ]);

        return response()->json([
            'message' => 'Signalement envoyé à l\'administration.',
            'report_id' => $report->id,
        ], 201);
    }
}
