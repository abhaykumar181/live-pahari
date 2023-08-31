<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;
use App\Models\Packages;
use App\Models\BookingOrder;
use App\Models\BookingsMeta;

class BookingNotification extends Mailable
{
    use Queueable, SerializesModels;
    protected $booking;

    /**
     * Create a new message instance.
     */
    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Booking Notification',
            from: new Address('agd.abhaykumar@gmail.com', 'Abhay Kumar'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.bookings.bookingNotification',
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
        // booking Details
        $data['bookingUsername'] = $this->booking->name;
        $tourName = Packages::find($this->booking->packageId);
        $data['bookingCode'] = $this->booking->bookingCode;
        $data['checkInDate'] = $this->booking->checkInDate;
        $data['checkOutDate'] = $this->booking->checkOutDate;
        $data['tourName'] = Packages::find($this->booking->packageId);
        $data['guests'] = $this->booking->guests;
        $data['packagePerUnitRate'] = Packages::find($this->booking->packageId)->price;
        $data['orderTotalPrice'] = BookingOrder::find($this->booking->id);
        $data['bookingStatus'] = $this->booking->status;
        // Order Summary Details
        $data['bookingItems'] = BookingsMeta::where(['bookingId' => $this->booking->id , 'objectType' => 'addon'])->get();
        
        return $this
        ->subject("Booking Confirmation for Your .'$tourName'. Tour")
        ->markdown('emails.bookings.bookingNotification', $data);
    }
}
