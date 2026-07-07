<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StayBookingMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $reservation;
    public string $guestName;
    public bool $isAdmin;

    public function __construct(array $reservation, string $guestName, bool $isAdmin = false)
    {
        $this->reservation = $reservation;
        $this->guestName   = $guestName;
        $this->isAdmin     = $isAdmin;
    }

    public function build()
    {
        return $this->subject($this->isAdmin
                ? 'New Hotel Booking - ' . ($this->reservation['accommodation']['name'] ?? 'Stay')
                : 'Your Hotel Booking Confirmation - Nomaly Travel')
            ->view('emails.stay-booking')
            ->with([
                'reservation' => $this->reservation,
                'guestName'   => $this->guestName,
                'isAdmin'     => $this->isAdmin,
            ]);
    }
}
