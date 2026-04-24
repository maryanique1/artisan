<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ArtisanProfile;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password as PasswordBroker;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Inscription client (étape unique)
     * POST /api/register/client
     */
    public function registerClient(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'ville' => ['required', 'string', 'max:255'],
            'quartier' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => 'client',
            'ville' => $validated['ville'],
            'quartier' => $validated['quartier'] ?? null,
        ]);

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'message' => 'Inscription réussie.',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    /**
     * Inscription artisan - Étape 1 (infos de base)
     * POST /api/register/artisan
     */
    public function registerArtisanStep1(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'ville' => ['required', 'string', 'max:255'],
            'quartier' => ['required', 'string', 'max:255'],
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => $validated['password'],
            'role' => 'artisan',
            'ville' => $validated['ville'],
            'quartier' => $validated['quartier'],
        ]);

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'message' => 'Étape 1 validée. Complétez votre vérification professionnelle.',
            'user' => $user,
            'token' => $token,
            'next_step' => 'verification',
        ], 201);
    }

    /**
     * Inscription artisan - Étape 2 (vérification pro)
     * POST /api/register/artisan/verification
     */
    public function registerArtisanStep2(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user->isArtisan()) {
            return response()->json(['message' => 'Accès réservé aux artisans.'], 403);
        }

        if ($user->artisanProfile) {
            return response()->json(['message' => 'Vérification déjà soumise.'], 422);
        }

        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'proof_document' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'proof_type' => ['required', 'in:diplome,certificat,preuve_experience'],
        ]);

        $documentPath = $request->file('proof_document')->store('proofs', 'public');

        $profile = ArtisanProfile::create([
            'user_id' => $user->id,
            'category_id' => $validated['category_id'],
            'metier' => \App\Models\Category::find($validated['category_id'])->name,
            'description' => $validated['description'] ?? null,
            'ville' => $user->ville,
            'quartier' => $user->quartier,
            'proof_document' => $documentPath,
            'proof_type' => $validated['proof_type'],
            'validation_status' => 'pending',
            'is_available' => true,
        ]);

        return response()->json([
            'message' => 'Dossier soumis. En attente de validation par l\'administration.',
            'artisan_profile' => $profile->load('category'),
        ], 201);
    }

    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($validated)) {
            return response()->json(['message' => 'Identifiants incorrects.'], 401);
        }

        $user = Auth::user();

        if (!$user->is_active) {
            Auth::logout();
            return response()->json(['message' => 'Compte désactivé.'], 403);
        }

        if ($user->isAdmin()) {
            Auth::logout();
            return response()->json(['message' => 'Les administrateurs se connectent via l\'interface web.'], 403);
        }

        $token = $user->createToken('auth-token')->plainTextToken;
        $user->load('artisanProfile.category');

        return response()->json([
            'message' => 'Connexion réussie.',
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Déconnexion réussie.']);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'user' => $request->user()->load('artisanProfile.category'),
        ]);
    }

    public function updateProfile(Request $request): JsonResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'first_name' => ['sometimes', 'string', 'max:255'],
            'last_name' => ['sometimes', 'string', 'max:255'],
            'phone' => ['sometimes', 'nullable', 'string', 'max:20', "unique:users,phone,{$user->id}"],
            'avatar' => ['sometimes', 'nullable', 'image', 'max:2048'],
            'ville' => ['sometimes', 'string', 'max:255'],
            'quartier' => ['sometimes', 'nullable', 'string', 'max:255'],
        ]);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($validated);

        return response()->json([
            'message' => 'Profil mis à jour.',
            'user' => $user->fresh()->load('artisanProfile.category'),
        ]);
    }

    public function forgotPassword(Request $request): JsonResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        PasswordBroker::sendResetLink($request->only('email'));

        return response()->json([
            'message' => 'Si cet email existe, un lien de réinitialisation a été envoyé.',
        ]);
    }

    public function resetPassword(Request $request): JsonResponse
    {
        $request->validate([
            'token'    => ['required'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $status = PasswordBroker::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->update(['password' => $password]);
                $user->tokens()->delete();
            }
        );

        if ($status === PasswordBroker::PASSWORD_RESET) {
            return response()->json(['message' => 'Mot de passe réinitialisé avec succès.']);
        }

        return response()->json(['message' => 'Lien invalide ou expiré.'], 422);
    }

    public function saveFcmToken(Request $request): JsonResponse
    {
        // Accepte les 2 conventions : { token, platform } (Flutter) ou { fcm_token, fcm_platform }
        $token = $request->input('token') ?? $request->input('fcm_token');
        $platform = $request->input('platform') ?? $request->input('fcm_platform');

        $validator = validator(
            ['token' => $token, 'platform' => $platform],
            [
                'token' => ['required', 'string', 'max:512'],
                'platform' => ['nullable', 'string', 'in:android,ios,web'],
            ]
        );
        $validator->validate();

        $request->user()->forceFill([
            'fcm_token' => $token,
            'fcm_platform' => $platform,
            'fcm_token_updated_at' => now(),
        ])->save();

        return response()->json(['message' => 'Token enregistré.']);
    }

    public function deleteFcmToken(Request $request): JsonResponse
    {
        $request->user()->forceFill([
            'fcm_token' => null,
            'fcm_platform' => null,
            'fcm_token_updated_at' => null,
        ])->save();

        return response()->json(['message' => 'Token supprimé.']);
    }
}
