<?php

namespace App\Listeners;

use App\Events\NewNotification;
use App\Services\FirebasePushService;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendFcmForNotification implements ShouldQueue
{
    public function __construct(private FirebasePushService $push) {}

    public function handle(NewNotification $event): void
    {
        $this->push->sendToUser(
            $event->userId,
            $event->title,
            $event->body ?? '',
            array_merge(['type' => $event->type], $event->data),
        );
    }
}
