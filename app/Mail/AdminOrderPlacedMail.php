<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminOrderPlacedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public $order;
    
    public $childOrder;
    public function __construct($order, $childOrder)
    {
        // Convert order to object
        $order = (object) $order;
        // Decode JSON shipping info safely
        $order->shipping = is_string($order->shipping)
            ? json_decode($order->shipping, true)
            : (array) $order->shipping;

        $this->order = $order;
        $this->childOrder = (object) $childOrder;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Order Received – Please Review Details',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.adminOrder_placed',
            with: [ 
                'order' => $this->order,
                'childOrder' => $this->childOrder,
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
        return [];
    }
}
