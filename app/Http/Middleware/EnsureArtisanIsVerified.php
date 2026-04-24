<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureArtisanIsVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->isArtisan() && $user->artisanProfile && $user->artisanProfile->validation_status !== 'approved') {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Votre compte est en attente de validation par l\'administration.',
                ], 403);
            }
            return redirect()->route('artisan.dashboard')
                ->with('error', 'Votre compte doit être validé par l\'administration pour effectuer cette action.');
        }

        return $next($request);
    }
}
