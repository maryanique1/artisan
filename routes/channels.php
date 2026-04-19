<?php

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
| Définit qui peut s'abonner aux canaux privés WebSocket (Reverb)
*/

// Canal privé d'un utilisateur (notifications personnelles)
Broadcast::channel('user.{userId}', function (User $user, int $userId) {
    return $user->id === $userId;
});

// Canal privé d'une conversation (accessible aux 2 participants uniquement)
Broadcast::channel('conversation.{conversationId}', function (User $user, int $conversationId) {
    $conversation = Conversation::find($conversationId);
    if (!$conversation) return false;

    return $conversation->client_id === $user->id || $conversation->artisan_id === $user->id;
});

// Les canaux publics (publication.{id}) ne nécessitent pas d'authentification
