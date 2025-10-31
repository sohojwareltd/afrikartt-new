<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderPlaced extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;
    public $childOrder;

    /**
     * Create a new message instance.
     *
     * @return void
     */
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
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Your Order Has Been Successfully Placed - Thank You for Shopping with Us!',
            from: config('mail.from.address'),
            replyTo: config('mail.reply_to.address', 'support@yourdomain.com'),
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.placed',
            with: [
                'order' => $this->order,
                'childOrder' => $this->childOrder,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
