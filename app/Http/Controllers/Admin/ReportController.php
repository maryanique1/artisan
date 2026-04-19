<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArtisanProfile;
use App\Models\Publication;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::with('reporter');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('target_type')) {
            $query->where('target_type', $request->target_type);
        }

        $reports = $query->latest()->paginate(20);

        // Charger les cibles
        $reports->each(function ($report) {
            $report->target = match ($report->target_type) {
                'publication' => Publication::with('artisanProfile.user')->find($report->target_id),
                'profile' => ArtisanProfile::with('user')->find($report->target_id),
                default => null,
            };
        });

        $countPending = Report::where('status', 'pending')->count();
        $countHandled = Report::whereIn('status', ['reviewed', 'resolved', 'dismissed'])->count();

        return view('admin.reports.index', compact('reports', 'countPending', 'countHandled'));
    }

    public function update(Request $request, Report $report)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:reviewed,resolved,dismissed'],
            'admin_notes' => ['nullable', 'string'],
            'delete_target' => ['sometimes', 'boolean'],
        ]);

        // Supprimer la cible si demandé
        if ($request->boolean('delete_target') && $validated['status'] === 'resolved') {
            if ($report->target_type === 'publication') {
                Publication::where('id', $report->target_id)->delete();
            }
        }

        $report->update([
            'status' => $validated['status'],
            'admin_notes' => $validated['admin_notes'] ?? null,
        ]);

        return back()->with('success', 'Signalement traité.');
    }
}
