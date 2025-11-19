<?php

namespace App\Mail;

use App\Models\Alteration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Support\Facades\Storage;

class AlterationRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $alteration;

    /**
     * Create a new message instance.
     */
    public function __construct(Alteration $alteration)
    {
        $this->alteration = $alteration;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->alteration->email, $this->alteration->name),
            replyTo: [
                new Address($this->alteration->email, $this->alteration->name),
            ],
            subject: 'New Alteration Request - ' . ucfirst(str_replace('_', ' ', $this->alteration->type)),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.alteration-request',
            with: [
                'alteration' => $this->alteration,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        if ($this->alteration->attachment && Storage::disk('public')->exists($this->alteration->attachment)) {
            $attachments[] = Attachment::fromStorageDisk('public', $this->alteration->attachment)
                ->as('attachment_' . basename($this->alteration->attachment));
        }

        return $attachments;
    }
}
