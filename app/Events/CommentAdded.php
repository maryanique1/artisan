<?php

namespace App\Events;

use App\Models\Comment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentAdded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Comment $comment)
    {
        $this->comment->load([
            'user:id,first_name,last_name,avatar',
            'publication.artisanProfile:id,user_id',
        ]);
    }

    public function broadcastOn(): array
    {
        $channels = [
            new Channel("publication.{$this->comment->publication_id}"),
        ];

        // Notifier l'artisan du nouveau commentaire sur sa publication
        if ($artisanUserId = $this->comment->publication?->artisanProfile?->user_id) {
            $channels[] = new PrivateChannel("user.{$artisanUserId}");
        }

        return $channels;
    }

    public function broadcastAs(): string
    {
        return 'comment.added';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->comment->id,
            'publication_id' => $this->comment->publication_id,
            'parent_id' => $this->comment->parent_id,
            'content' => $this->comment->content,
            'created_at' => $this->comment->created_at->toIso8601String(),
            'user' => [
                'id' => $this->comment->user->id,
                'first_name' => $this->comment->user->first_name,
                'last_name' => $this->comment->user->last_name,
                'avatar' => $this->comment->user->avatar,
            ],
        ];
    }
}
