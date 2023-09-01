<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use App\Models\Bookings;
use App\Models\Properties;

class ConfirmationRejected extends Mailable
{
    use Queueable, SerializesModels;
    protected $bookingConfirmation;
    /**
     * Create a new message instance.
     */
    public function __construct($bookingConfirmation)
    {
        $this->bookingConfirmation = $bookingConfirmation;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmation Rejected',
            from: new Address('agd.abhaykumar@gmail.com', 'Abhay Kumar'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.bookings.confirmation-rejected',
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

    public function build(){

        $data['booking'] = Bookings::find($this->bookingConfirmation->bookingId);
        $data['property'] = Properties::find($this->bookingConfirmation->propertyId);

        return $this
        ->subject("Confirmation Accepted")
        ->markdown("emails.bookings.confirmation-accepted", $data);
    }


}
