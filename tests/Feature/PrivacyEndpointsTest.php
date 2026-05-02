<?php

use App\Models\ArtisanProfile;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

it('returns and updates the authenticated user privacy setting', function () {
    $user = User::create([
        'first_name'      => 'Marie',
        'last_name'       => 'Agbodjan',
        'email'           => 'marie@example.com',
        'password'        => 'password',
        'role'            => 'artisan',
        'is_active'       => true,
        'profile_visible' => true,
    ]);

    Sanctum::actingAs($user);

    $this->getJson('/api/me/privacy')
        ->assertOk()
        ->assertExactJson(['profile_visible' => true]);

    $this->putJson('/api/me/privacy', ['profile_visible' => false])
        ->assertOk()
        ->assertExactJson([
            'message'         => 'Parametres de confidentialite mis a jour.',
            'profile_visible' => false,
        ]);

    $this->assertDatabaseHas('users', ['id' => $user->id, 'profile_visible' => false]);
});

it('hides artisan profiles from listing when profile_visible is false', function () {
    $category = Category::create(['name' => 'Couture', 'slug' => 'couture']);

    $visibleUser = User::create([
        'first_name' => 'Visible', 'last_name' => 'Artisan',
        'email' => 'visible@example.com', 'password' => 'password',
        'role' => 'artisan', 'is_active' => true, 'profile_visible' => true,
    ]);

    $hiddenUser = User::create([
        'first_name' => 'Hidden', 'last_name' => 'Artisan',
        'email' => 'hidden@example.com', 'password' => 'password',
        'role' => 'artisan', 'is_active' => true, 'profile_visible' => false,
    ]);

    ArtisanProfile::create([
        'user_id' => $visibleUser->id, 'category_id' => $category->id,
        'metier' => 'Couturiere', 'ville' => 'Cotonou', 'quartier' => 'Fidjrosse',
        'validation_status' => 'approved', 'is_available' => true,
    ]);

    $hiddenProfile = ArtisanProfile::create([
        'user_id' => $hiddenUser->id, 'category_id' => $category->id,
        'metier' => 'Couturiere', 'ville' => 'Cotonou', 'quartier' => 'Akpakpa',
        'validation_status' => 'approved', 'is_available' => true,
    ]);

    // Seul l'artisan visible apparaît dans la liste
    $this->getJson('/api/artisans')
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.user.first_name', 'Visible');

    // Le profil caché retourne 404
    $this->getJson("/api/artisans/{$hiddenProfile->id}")
        ->assertNotFound();
});
