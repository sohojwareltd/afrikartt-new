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

class OnRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $request;

    /**
     * Create a new message instance.
     */
    public function __construct(Alteration $request)
    {
        $this->request = $request;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->request->email, $this->request->name),
            replyTo: [
                new Address($this->request->email, $this->request->name),
            ],
            subject: 'New Custom Request - ' . ucfirst(str_replace('_', ' ', $this->request->type)),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.on-request',
            with: [
                'request' => $this->request,
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

        if ($this->request->attachment && Storage::disk('public')->exists($this->request->attachment)) {
            $attachments[] = Attachment::fromStorageDisk('public', $this->request->attachment)
                ->as('attachment_' . basename($this->request->attachment));
        }

        return $attachments;
    }
}
