<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\PublicationController as AdminPublicationController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// ── Landing ────────────────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
});

Route::get('/documentation', function () {
    return view('docs.index');
})->name('documentation');

// ── Admin Dashboard (seul espace web) ──────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {

    // Auth admin
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Mot de passe oublié
    Route::get('/forgot-password', [AdminAuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AdminAuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AdminAuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AdminAuthController::class, 'resetPassword'])->name('password.update');

    Route::middleware(['auth', 'admin'])->group(function () {

        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Profil admin
        Route::get('/profile', [AdminProfileController::class, 'show'])->name('profile');
        Route::post('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.password');

        // Gestion utilisateurs
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::patch('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');
        Route::patch('/users/{user}/verify-artisan', [UserController::class, 'verifyArtisan'])->name('users.verify-artisan');
        Route::patch('/users/{user}/reject-artisan', [UserController::class, 'rejectArtisan'])->name('users.reject-artisan');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        // Gestion catégories
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::patch('/categories/{category}/toggle', [CategoryController::class, 'toggle'])->name('categories.toggle');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        // Modération publications
        Route::get('/publications', [AdminPublicationController::class, 'index'])->name('publications.index');
        Route::delete('/publications/{publication}', [AdminPublicationController::class, 'destroy'])->name('publications.destroy');

        // Signalements
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::put('/reports/{report}', [ReportController::class, 'update'])->name('reports.update');
    });
});
