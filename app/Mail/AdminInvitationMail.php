<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $admin,
        public string $plainPassword,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invitation administrateur — FeGArtisan',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-invitation',
            with: [
                'admin'         => $this->admin,
                'plainPassword' => $this->plainPassword,
                'loginUrl'      => url(route('admin.login', [], false)),
            ],
        );
    }
}
