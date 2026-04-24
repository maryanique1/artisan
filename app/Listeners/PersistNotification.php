<?php

namespace App\Listeners;

use App\Events\NewNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PersistNotification
{
    public function handle(NewNotification $event): void
    {
        DB::table('notifications')->insert([
            'id'               => Str::uuid()->toString(),
            'type'             => $event->type,
            'notifiable_type'  => 'App\\Models\\User',
            'notifiable_id'    => $event->userId,
            'data'             => json_encode([
                'title' => $event->title,
                'body'  => $event->body,
                'extra' => $event->data,
            ]),
            'read_at'          => null,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);
    }
}
