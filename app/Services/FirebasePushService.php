<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Exception\Messaging\NotFound;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FcmNotification;
use Throwable;

class FirebasePushService
{
    private ?Messaging $messaging = null;

    public function __construct()
    {
        if (!config('firebase.push_enabled')) {
            return;
        }

        $credentials = config('firebase.credentials');
        if (!$credentials) {
            return;
        }

        $path = $credentials;
        if (!str_starts_with($path, '/') && $path[1] ?? '' !== ':') {
            $path = base_path($credentials);
        }

        if (!file_exists($path)) {
            Log::warning('Firebase credentials file not found', ['path' => $path]);
            return;
        }

        try {
            $this->messaging = (new Factory)
                ->withServiceAccount($path)
                ->createMessaging();
        } catch (Throwable $e) {
            Log::error('Failed to init Firebase Messaging', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Envoie une notif push à un utilisateur s'il a un fcm_token.
     *
     * @param array<string,string|int> $data  payload supplémentaire (uniquement scalaires, FCM impose string)
     */
    public function sendToUser(int $userId, string $title, string $body, array $data = []): bool
    {
        if (!$this->messaging) {
            return false;
        }

        $user = User::find($userId);
        if (!$user || !$user->fcm_token) {
            return false;
        }

        try {
            $message = CloudMessage::withTarget('token', $user->fcm_token)
                ->withNotification(FcmNotification::create($title, $body))
                ->withData($this->stringifyData($data));

            $this->messaging->send($message);
            return true;
        } catch (NotFound $e) {
            // Token invalide/expiré — on le purge.
            $user->forceFill([
                'fcm_token' => null,
                'fcm_platform' => null,
                'fcm_token_updated_at' => null,
            ])->save();
            Log::info('FCM token invalidé (purgé)', ['user_id' => $userId]);
            return false;
        } catch (Throwable $e) {
            Log::error('FCM send failed', ['user_id' => $userId, 'error' => $e->getMessage()]);
            return false;
        }
    }

    private function stringifyData(array $data): array
    {
        return array_map(fn($v) => is_scalar($v) ? (string) $v : json_encode($v), $data);
    }
}
