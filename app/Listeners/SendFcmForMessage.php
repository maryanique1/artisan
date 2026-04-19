<?php

namespace App\Listeners;

use App\Events\NewMessageSent;
use App\Models\Conversation;
use App\Services\FirebasePushService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;

class SendFcmForMessage implements ShouldQueue
{
    public function __construct(private FirebasePushService $push) {}

    public function handle(NewMessageSent $event): void
    {
        $message = $event->message;
        $conversation = Conversation::find($message->conversation_id);
        if (!$conversation) {
            return;
        }

        // Destinataire = l'autre participant
        $recipientId = $message->sender_id === $conversation->client_id
            ? $conversation->artisan_id
            : $conversation->client_id;

        $senderName = trim(($message->sender->first_name ?? '').' '.($message->sender->last_name ?? ''));

        $preview = $message->type === 'text'
            ? Str::limit($message->content ?? '', 120)
            : ($message->type === 'image' ? '📷 Image' : '📎 Pièce jointe');

        $this->push->sendToUser(
            $recipientId,
            $senderName ?: 'Nouveau message',
            $preview,
            [
                'type' => 'new_message',
                'conversation_id' => $message->conversation_id,
                'message_id' => $message->id,
            ],
        );
    }
}
