<?php

namespace App\Events;

use App\Models\ArtisanProfile;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ArtisanValidationUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public ArtisanProfile $profile) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("user.{$this->profile->user_id}"),
        ];
    }

    public function broadcastAs(): string
    {
        return 'artisan.validation';
    }

    public function broadcastWith(): array
    {
        return [
            'validation_status' => $this->profile->validation_status,
            'rejection_reason' => $this->profile->rejection_reason,
            'validated_at' => $this->profile->validated_at?->toIso8601String(),
            'message' => match ($this->profile->validation_status) {
                'approved' => 'Votre compte artisan a été validé ! Vous pouvez maintenant publier.',
                'rejected' => 'Votre dossier a été refusé : ' . $this->profile->rejection_reason,
                'suspended' => 'Votre compte a été suspendu.',
                default => 'Statut mis à jour.',
            },
        ];
    }
}
