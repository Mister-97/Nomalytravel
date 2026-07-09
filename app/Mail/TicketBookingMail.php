<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketBookingMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $booking;
    public string $buyerName;
    public bool $isAdmin;

    public function __construct(array $booking, string $buyerName, bool $isAdmin = false)
    {
        $this->booking   = $booking;
        $this->buyerName = $buyerName;
        $this->isAdmin   = $isAdmin;
    }

    public function build()
    {
        return $this->subject($this->isAdmin
                ? 'New Ticket Order - ' . ($this->booking['event']['name'] ?? 'Event')
                : 'Your Ticket Order Confirmation - Nomaly Travel')
            ->view('emails.ticket-booking')
            ->with([
                'booking'   => $this->booking,
                'buyerName' => $this->buyerName,
                'isAdmin'   => $this->isAdmin,
            ]);
    }
}
