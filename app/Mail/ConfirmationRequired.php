<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Properties;
use App\Models\Bookings;

class ConfirmationRequired extends Mailable
{
    use Queueable, SerializesModels;

    protected $confirmationItem;
    /**
     * Create a new message instance.
     */
    public function __construct($confirmationItem)
    {
        $this->confirmationItem = $confirmationItem;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmation Required',
            from: new Address('agd.abhaykumar@gmail.com', 'Abhay Kumar'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.bookings.confirmationRequest',
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

    public function build()
    {
        $data['property'] = Properties::find($this->confirmationItem->propertyId);
        $data['booking'] = Bookings::find($this->confirmationItem->bookingId);
        $data['confirmationItem'] = $this->confirmationItem;

        return $this
            ->subject('Thank you for subscribing to our newsletter')
            ->markdown('emails.bookings.confirmationRequest', $data);
    }


}
