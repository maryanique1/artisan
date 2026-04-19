<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsArtisan
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->isArtisan()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Accès réservé aux artisans.'], 403);
            }
            abort(403, 'Accès réservé aux artisans.');
        }

        return $next($request);
    }
}
