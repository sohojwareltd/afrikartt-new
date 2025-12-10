<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $oldStatus;
    public $newStatus;
    public $statusNote;
    public $customerName;
    public $customerEmail;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, $oldStatus, $newStatus, $statusNote = null)
    {
        $this->order = $order;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
        $this->statusNote = $statusNote;

        // Get customer info from shipping or user
        $shipping = json_decode($order->shipping);
        $this->customerName = $shipping->first_name ?? $order->user->name ?? 'Valued Customer';
        $this->customerEmail = $shipping->email ?? $order->user->email ?? '';
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $statusNames = [
            0 => 'Pending',
            1 => 'Paid',
            2 => 'On Its Way',
            3 => 'Cancelled',
            4 => 'Delivered',
        ];

        return new Envelope(
            subject: 'Order #' . $this->order->id . ' Status Updated - ' . $statusNames[$this->newStatus],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order-status-updated',
            with: [
                'order' => $this->order,
                'oldStatus' => $this->oldStatus,
                'newStatus' => $this->newStatus,
                'statusNote' => $this->statusNote,
                'customerName' => $this->customerName,
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
