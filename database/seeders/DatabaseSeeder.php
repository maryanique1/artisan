<?php

namespace Database\Seeders;

use App\Models\ArtisanProfile;
use App\Models\Category;
use App\Models\Publication;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin ──────────────────────────────────────
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'FeGArtisan',
            'email' => 'admin@fegartisan.com',
            'password' => 'admin1234',
            'role' => 'admin',
            'ville' => 'Cotonou',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // ── Catégories métiers (7 branches + 50 métiers) ──
        $this->call(CategorySeeder::class);

        // ── Client de démo ─────────────────────────────
        User::create([
            'first_name' => 'Jean',
            'last_name' => 'Dupont',
            'email' => 'client@fegartisan.com',
            'password' => 'client1234',
            'role' => 'client',
            'ville' => 'Cotonou',
            'quartier' => 'Akpakpa',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // ── Artisan validé (démo) ──────────────────────
        $artisan = User::create([
            'first_name' => 'Pierre',
            'last_name' => 'Hounsa',
            'email' => 'artisan@fegartisan.com',
            'phone' => '+229 97 00 00 02',
            'password' => 'artisan1234',
            'role' => 'artisan',
            'ville' => 'Cotonou',
            'quartier' => 'Akpakpa',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $profile = ArtisanProfile::create([
            'user_id' => $artisan->id,
            'category_id' => Category::where('name', 'Électricité')->first()->id,
            'metier' => 'Électricité',
            'description' => '10 ans d\'expérience en installation électrique.',
            'ville' => 'Cotonou',
            'quartier' => 'Akpakpa',
            'proof_type' => 'diplome',
            'validation_status' => 'approved',
            'validated_at' => now(),
            'is_available' => true,
        ]);

        // Publications de démo
        Publication::create([
            'artisan_profile_id' => $profile->id,
            'type' => 'text',
            'content' => 'Bonjour à tous ! Je suis disponible cette semaine pour vos installations électriques sur Cotonou. N\'hésitez pas à me contacter.',
        ]);

        // ── Artisan en attente de validation ────────────
        $pending = User::create([
            'first_name' => 'Marie',
            'last_name' => 'Agbodjan',
            'email' => 'marie@fegartisan.com',
            'phone' => '+229 97 00 00 03',
            'password' => 'marie1234',
            'role' => 'artisan',
            'ville' => 'Cotonou',
            'quartier' => 'Fidjrossè',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        ArtisanProfile::create([
            'user_id' => $pending->id,
            'category_id' => Category::where('name', 'Couture')->first()->id,
            'metier' => 'Couture',
            'description' => 'Couturière, spécialisée en pagne africain.',
            'ville' => 'Cotonou',
            'quartier' => 'Fidjrossè',
            'proof_type' => 'preuve_experience',
            'validation_status' => 'pending',
            'is_available' => true,
        ]);
    }
}
