<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArtisanProfile;
use App\Models\Category;
use App\Models\Publication;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $startOfMonth = Carbon::now()->startOfMonth();

        $totalClients = User::where('role', 'client')->count();
        $totalArtisans = ArtisanProfile::where('validation_status', 'approved')->count();
        $pendingValidations = ArtisanProfile::where('validation_status', 'pending')->count();
        $pendingReports = Report::where('status', 'pending')->count();

        $stats = [
            'total_clients' => $totalClients,
            'total_artisans_approved' => $totalArtisans,
            'pending_validations' => $pendingValidations,
            'pending_reports' => $pendingReports,
            'total_publications' => Publication::count(),
            'total_categories' => Category::where('is_active', true)->count(),
            'rejected_artisans' => ArtisanProfile::where('validation_status', 'rejected')->count(),

            'clients_this_month' => User::where('role', 'client')->where('created_at', '>=', $startOfMonth)->count(),
            'artisans_this_month' => ArtisanProfile::where('validation_status', 'approved')
                ->where('validated_at', '>=', $startOfMonth)->count(),
        ];

        $pendingArtisans = ArtisanProfile::with(['user', 'category'])
            ->where('validation_status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        $recentReports = Report::with('reporter')
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        // Répartition artisans par catégorie (top 3 + autres)
        $categoryDistribution = Category::withCount(['artisanProfiles as total' => function ($q) {
                $q->where('validation_status', 'approved');
            }])
            ->having('total', '>', 0)
            ->orderByDesc('total')
            ->get();

        $topCategories = $categoryDistribution->take(3);
        $othersTotal = $categoryDistribution->skip(3)->sum('total');
        $distribution = $topCategories->map(fn($c) => [
            'name' => $c->name,
            'total' => $c->total,
        ])->values()->toArray();
        if ($othersTotal > 0) {
            $distribution[] = ['name' => 'Autres', 'total' => $othersTotal];
        }

        // Activité récente : derniers artisans inscrits + derniers signalements
        $recentActivity = collect();
        User::where('role', 'artisan')->with('artisanProfile.category')->latest()->take(4)->get()->each(function ($u) use ($recentActivity) {
            $recentActivity->push([
                'icon' => 'bi-person-plus',
                'title' => 'Nouvel artisan inscrit',
                'body' => $u->name . ($u->artisanProfile?->category?->name ? ' ('.$u->artisanProfile->category->name.')' : ''),
                'at' => $u->created_at,
            ]);
        });
        Report::latest()->take(3)->get()->each(function ($r) use ($recentActivity) {
            $recentActivity->push([
                'icon' => 'bi-flag',
                'title' => 'Nouveau signalement',
                'body' => $r->reason,
                'at' => $r->created_at,
            ]);
        });
        $recentActivity = $recentActivity->sortByDesc('at')->take(5)->values();

        return view('admin.dashboard', compact(
            'stats', 'pendingArtisans', 'recentReports', 'distribution', 'recentActivity'
        ));
    }
}
