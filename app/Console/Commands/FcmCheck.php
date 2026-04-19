<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\FirebasePushService;
use Illuminate\Console\Command;
use Kreait\Firebase\Factory;

class FcmCheck extends Command
{
    protected $signature = 'fcm:check {user? : ID utilisateur pour un test d\'envoi}';
    protected $description = 'Diagnostique la config Firebase Cloud Messaging et envoie optionnellement un push de test';

    public function handle(FirebasePushService $push): int
    {
        $this->line('');
        $this->info('▶ Diagnostic FCM FeGArtisan');
        $this->line('');

        // 1. Config
        $enabled = config('firebase.push_enabled');
        $credPath = config('firebase.credentials');
        $this->line("1. Push activé          : ".($enabled ? '<fg=green>oui</>' : '<fg=red>non (FIREBASE_PUSH_ENABLED=false)</>'));
        $this->line("2. Chemin credentials   : ".($credPath ?: '<fg=red>non défini (.env FIREBASE_CREDENTIALS)</>'));

        if (!$credPath) {
            return self::FAILURE;
        }

        // 2. Fichier
        $abs = base_path($credPath);
        $exists = file_exists($abs);
        $this->line("3. Fichier présent      : ".($exists ? "<fg=green>oui</> ($abs)" : "<fg=red>INTROUVABLE ($abs)</>"));
        if (!$exists) {
            return self::FAILURE;
        }

        // 3. JSON valide
        $json = json_decode(file_get_contents($abs), true);
        $ok = $json && !empty($json['project_id']) && !empty($json['private_key']);
        $this->line("4. JSON valide          : ".($ok ? "<fg=green>oui</> (project: {$json['project_id']})" : '<fg=red>non</>'));
        if (!$ok) {
            return self::FAILURE;
        }

        // 4. Extension sodium
        $hasSodium = extension_loaded('sodium');
        $this->line("5. Extension sodium     : ".($hasSodium ? '<fg=green>chargée</>' : '<fg=red>manquante (activer dans php.ini)</>'));

        // 5. Init Firebase
        try {
            $messaging = (new Factory)->withServiceAccount($abs)->createMessaging();
            $this->line("6. Connexion Firebase   : <fg=green>OK</>");
        } catch (\Throwable $e) {
            $this->line("6. Connexion Firebase   : <fg=red>ÉCHEC</> — ".$e->getMessage());
            return self::FAILURE;
        }

        $this->line('');

        // 6. Test d'envoi si user_id donné
        $userId = $this->argument('user');
        if (!$userId) {
            $this->comment('→ Config OK. Pour tester un envoi : php artisan fcm:check <user_id>');
            return self::SUCCESS;
        }

        $user = User::find($userId);
        if (!$user) {
            $this->error("Utilisateur #{$userId} introuvable.");
            return self::FAILURE;
        }
        if (!$user->fcm_token) {
            $this->error("Utilisateur #{$userId} ({$user->name}) n'a pas de fcm_token. L'appli Flutter doit l'enregistrer via POST /api/me/fcm-token.");
            return self::FAILURE;
        }

        $this->line("▶ Envoi d'un push de test à {$user->name} (token ".substr($user->fcm_token, 0, 12)."…)");
        $sent = $push->sendToUser(
            $user->id,
            'Test FeGArtisan',
            'Si tu vois ce message, FCM fonctionne ! 🎉',
            ['type' => 'test', 'at' => now()->toIso8601String()],
        );

        if ($sent) {
            $this->info('✓ Push envoyé avec succès.');
            return self::SUCCESS;
        }

        $this->error('Échec de l\'envoi (voir storage/logs/laravel.log).');
        return self::FAILURE;
    }
}
