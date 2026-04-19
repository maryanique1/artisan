<?php

namespace App\Events;

use App\Models\Publication;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PublicationLiked implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Publication $publication,
        public User $liker,
        public bool $liked
    ) {}

    public function broadcastOn(): array
    {
        // Canal public du feed + canal privé de l'artisan
        return [
            new Channel("publication.{$this->publication->id}"),
            new PrivateChannel("user.{$this->publication->artisanProfile->user_id}"),
        ];
    }

    public function broadcastAs(): string
    {
        return 'publication.liked';
    }

    public function broadcastWith(): array
    {
        return [
            'publication_id' => $this->publication->id,
            'likes_count' => $this->publication->likes_count,
            'liked' => $this->liked,
            'liker' => [
                'id' => $this->liker->id,
                'name' => $this->liker->name,
                'avatar' => $this->liker->avatar,
            ],
        ];
    }
}
