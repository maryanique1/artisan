<?php

namespace App\Http\Controllers\Admin;

use App\Events\ArtisanValidationUpdated;
use App\Events\NewNotification;
use App\Http\Controllers\Controller;
use App\Mail\ArtisanApprovedMail;
use App\Mail\ArtisanRejectedMail;
use App\Models\ArtisanProfile;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->input('role');
        $validation = $request->input('validation');

        $query = User::query();

        if ($role) {
            $query->where('role', $role);
        }

        if ($validation) {
            $query->whereHas('artisanProfile', fn($q) => $q->where('validation_status', $validation));
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->filled('city')) {
            $city = $request->city;
            $query->where(function ($q) use ($city) {
                $q->where('ville', 'like', "%{$city}%")
                    ->orWhereHas('artisanProfile', fn($p) => $p->where('ville', 'like', "%{$city}%"));
            });
        }

        if ($request->filled('category')) {
            $catId = $request->category;
            $query->whereHas('artisanProfile', fn($p) => $p->where('category_id', $catId));
        }

        if ($request->filled('period') && $validation === 'pending') {
            if ($request->period === 'today') {
                $query->whereHas('artisanProfile', fn($p) => $p->whereDate('created_at', today()));
            } elseif ($request->period === 'week') {
                $query->whereHas('artisanProfile', fn($p) => $p->where('created_at', '>=', Carbon::now()->startOfWeek()));
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $users = $query->with('artisanProfile.category')->latest()->paginate(20);

        // Compteurs d'entête (scope = role/validation actifs, indépendant du filtre status)
        $countBase = User::query();
        if ($role) $countBase->where('role', $role);
        if ($validation) $countBase->whereHas('artisanProfile', fn($q) => $q->where('validation_status', $validation));
        $activeCount = (clone $countBase)->where('is_active', true)->count();
        $suspendedCount = (clone $countBase)->where('is_active', false)->count();

        // Mode pending : compteurs aujourd'hui / semaine
        $countToday = $countWeek = 0;
        if ($validation === 'pending') {
            $countToday = ArtisanProfile::where('validation_status', 'pending')->whereDate('created_at', today())->count();
            $countWeek = ArtisanProfile::where('validation_status', 'pending')->where('created_at', '>=', Carbon::now()->startOfWeek())->count();
        }

        $categories = ($role === 'artisan' || $validation === 'pending')
            ? Category::where('is_active', true)->orderBy('name')->get()
            : collect();

        return view('admin.users.index', compact(
            'users', 'activeCount', 'suspendedCount', 'countToday', 'countWeek', 'categories'
        ));
    }

    public function show(User $user)
    {
        $user->load(['artisanProfile.category', 'artisanProfile.publications', 'artisanProfile.reviews.client']);

        return view('admin.users.show', compact('user'));
    }

    public function toggleActive(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);

        if (!$user->is_active) {
            $user->tokens()->delete();
            broadcast(new NewNotification(
                userId: $user->id,
                type: 'account_suspended',
                title: 'Compte suspendu',
                body: 'Votre compte a été suspendu par un administrateur.',
            ));
        } else {
            broadcast(new NewNotification(
                userId: $user->id,
                type: 'account_reactivated',
                title: 'Compte réactivé',
                body: 'Votre compte a été réactivé. Vous pouvez de nouveau vous connecter.',
            ));
        }

        return back()->with('success', $user->is_active ? 'Compte activé.' : 'Compte suspendu.');
    }

    /**
     * Valider le dossier d'un artisan
     */
    public function verifyArtisan(User $user)
    {
        if (!$user->artisanProfile) {
            return back()->with('error', 'Aucun dossier artisan à valider.');
        }

        $user->artisanProfile->update([
            'validation_status' => 'approved',
            'validated_at' => now(),
            'rejection_reason' => null,
        ]);

        broadcast(new ArtisanValidationUpdated($user->artisanProfile->fresh()));
        broadcast(new NewNotification(
            userId: $user->id,
            type: 'artisan_approved',
            title: 'Compte validé ✓',
            body: 'Votre compte artisan a été validé. Vous pouvez maintenant publier.',
        ));

        Mail::to($user->email)->send(new ArtisanApprovedMail($user));

        return back()->with('success', 'Artisan validé avec succès. Email de confirmation envoyé.');
    }

    /**
     * Refuser le dossier d'un artisan
     */
    public function rejectArtisan(Request $request, User $user)
    {
        if (!$user->artisanProfile) {
            return back()->with('error', 'Aucun dossier artisan à refuser.');
        }

        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:500'],
        ]);

        $user->artisanProfile->update([
            'validation_status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        broadcast(new ArtisanValidationUpdated($user->artisanProfile->fresh()));
        broadcast(new NewNotification(
            userId: $user->id,
            type: 'artisan_rejected',
            title: 'Dossier refusé',
            body: $validated['rejection_reason'],
        ));

        Mail::to($user->email)->send(new ArtisanRejectedMail($user, $validated['rejection_reason']));

        return back()->with('success', 'Dossier refusé. Email explicatif envoyé.');
    }

    public function destroy(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Impossible de supprimer un administrateur.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur supprimé.');
    }
}
