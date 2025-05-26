<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DisputeNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $disputeDetail;
    public $booking;
    public $user;
    
    public function __construct($disputeDetail, $booking, $user)
    {
        $this->disputeDetail = $disputeDetail;
        $this->booking = $booking;
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Booking Dispute Notification')
                    ->view('emails.disputeNotification')
                    ->with([
                        'disputeDetail' => $this->disputeDetail,
                        'booking' => $this->booking,
                        'user' => $this->user,
                    ]);
    }
}
