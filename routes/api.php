<?php

use App\Http\Controllers\Api\ArtisanController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\ConversationController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\PublicationController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\ReviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes API FeGArtisan V2
|--------------------------------------------------------------------------
| Consommées par l'application mobile Flutter (clients + artisans)
*/

// ══════════ Routes publiques ══════════════════════════════════

// Auth
Route::post('/register/client', [AuthController::class, 'registerClient']);
Route::post('/register/artisan', [AuthController::class, 'registerArtisanStep1']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Catégories (lecture publique — listes de filtres)
Route::get('/categories', [CategoryController::class, 'index']);

// Artisans (recherche publique)
Route::get('/artisans', [ArtisanController::class, 'index']);
Route::get('/artisans/{artisanProfile}', [ArtisanController::class, 'show']);
Route::get('/artisans/{artisanProfile}/reviews', [ReviewController::class, 'index']);

// Publications (feed public — lecture)
Route::get('/publications', [PublicationController::class, 'index']);
Route::get('/publications/{publication}', [PublicationController::class, 'show']);
Route::get('/publications/{publication}/comments', [CommentController::class, 'index']);


// ══════════ Routes authentifiées (Sanctum) ═════════════════════

Route::middleware(['auth:sanctum', \App\Http\Middleware\EnsureUserIsActive::class])->group(function () {

    // Auth / profil
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/me', [AuthController::class, 'updateProfile']);

    // Push notifications (FCM)
    Route::post('/me/fcm-token', [AuthController::class, 'saveFcmToken']);
    Route::delete('/me/fcm-token', [AuthController::class, 'deleteFcmToken']);

    // Étape 2 inscription artisan (preuve légale)
    Route::post('/register/artisan/verification', [AuthController::class, 'registerArtisanStep2']);

    // Feed — interactions
    Route::post('/publications/{publication}/like', [PublicationController::class, 'toggleLike']);
    Route::post('/publications/{publication}/share', [PublicationController::class, 'share']);
    Route::post('/publications/{publication}/comments', [CommentController::class, 'store']);
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);
    Route::post('/comments/{comment}/like', [CommentController::class, 'toggleLike']);

    // Favoris (client)
    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::post('/favorites/{artisanProfile}', [FavoriteController::class, 'toggle']);

    // Historique de recherche
    Route::get('/search-history', [ArtisanController::class, 'searchHistory']);

    // Avis
    Route::post('/artisans/{artisanProfile}/reviews', [ReviewController::class, 'store']);

    // Signalements
    Route::post('/reports', [ReportController::class, 'store']);

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount']);
    Route::patch('/notifications/read-all', [NotificationController::class, 'markAllRead']);
    Route::patch('/notifications/{id}/read', [NotificationController::class, 'markRead']);
    Route::delete('/notifications/all', [NotificationController::class, 'destroyAll']);
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);

    // Conversations & messages
    Route::get('/conversations', [ConversationController::class, 'index']);
    Route::get('/conversations/{conversation}', [ConversationController::class, 'show']);
    Route::post('/conversations', [ConversationController::class, 'startOrGet']);
    Route::post('/conversations/{conversation}/messages', [ConversationController::class, 'sendMessage']);

    // ── Routes artisan uniquement ──────────────────────────────
    Route::middleware('artisan.role')->prefix('artisan')->group(function () {
        Route::get('/dashboard', [ArtisanController::class, 'dashboard']);

        Route::get('/publications', [PublicationController::class, 'mine']);
        Route::post('/publications', [PublicationController::class, 'store']);
        Route::put('/publications/{publication}', [PublicationController::class, 'update']);
        Route::delete('/publications/{publication}', [PublicationController::class, 'destroy']);
    });
});
