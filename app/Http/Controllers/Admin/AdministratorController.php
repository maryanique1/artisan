<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminInvitationMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdministratorController extends Controller
{
    public function index()
    {
        $this->authorizeAccess();

        $admins = User::where('role', 'admin')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.administrators.index', compact('admins'));
    }

    public function store(Request $request)
    {
        $this->authorizeAccess();

        $validated = $request->validate([
            'email'            => ['required', 'email', 'unique:users,email'],
            'first_name'       => ['required', 'string', 'max:80'],
            'last_name'        => ['required', 'string', 'max:80'],
            'can_manage_admins' => ['boolean'],
        ]);

        $plainPassword = Str::random(10);

        $admin = User::create([
            'first_name'       => $validated['first_name'],
            'last_name'        => $validated['last_name'],
            'email'            => $validated['email'],
            'role'             => 'admin',
            'password'         => $plainPassword,
            'is_active'        => true,
            'can_manage_admins' => $request->boolean('can_manage_admins'),
        ]);

        Mail::to($admin->email)->send(new AdminInvitationMail($admin, $plainPassword));

        return back()->with('success', "Invitation envoyée à {$admin->email}.");
    }

    public function toggleActive(User $admin)
    {
        $this->authorizeAccess();
        abort_if($admin->id === auth()->id(), 403, 'Vous ne pouvez pas vous suspendre vous-même.');

        $admin->update(['is_active' => !$admin->is_active]);

        if (!$admin->is_active) {
            $admin->tokens()->delete();
        }

        return back()->with('success', $admin->is_active ? 'Compte activé.' : 'Compte suspendu.');
    }

    public function toggleManageAdmins(User $admin)
    {
        $this->authorizeAccess();
        abort_if($admin->id === auth()->id(), 403, 'Vous ne pouvez pas modifier vos propres permissions.');

        $admin->update(['can_manage_admins' => !$admin->can_manage_admins]);

        return back()->with('success', 'Permission mise à jour.');
    }

    private function authorizeAccess(): void
    {
        abort_unless(auth()->user()->can_manage_admins, 403);
    }
}
