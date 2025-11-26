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

class WholesaleRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $wholesale;

    /**
     * Create a new message instance.
     */
    public function __construct(Alteration $wholesale)
    {
        $this->wholesale = $wholesale;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->wholesale->email, $this->wholesale->name),
            replyTo: [
                new Address($this->wholesale->email, $this->wholesale->name),
            ],
            subject: 'New Wholesale Inquiry - ' . ucfirst($this->wholesale->type),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.wholesale-request',
            with: [
                'wholesale' => $this->wholesale,
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

        if ($this->wholesale->attachment && Storage::disk('public')->exists($this->wholesale->attachment)) {
            $attachments[] = Attachment::fromStorageDisk('public', $this->wholesale->attachment)
                ->as('attachment_' . basename($this->wholesale->attachment));
        }

        return $attachments;
    }
}
