<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Kreait\Laravel\Firebase\Facades\Firebase as FacadesFirebase;
use App\Models\Booking; // Assuming you have a Booking model
use Carbon\Carbon;

class SendTimeSlotReminder extends Command
{
    protected $signature = 'send:timeslot-reminder';
    protected $description = 'Send reminder notification 1 hour before time slot';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Fetch bookings with time slot 1 hour ahead of current time
        $bookings = Booking::whereRaw('TIMESTAMPDIFF(MINUTE, NOW(), CONCAT(date, " ", time_slot)) = 60')
            ->where('status', 'scheduled') // Make sure the booking is scheduled
            ->get();

        foreach ($bookings as $booking) {
            // You need to retrieve the user to send the notification
            $user = $booking->user; // Assuming your Booking model has a relation to the User model
            $fcmToken = $user->fcm_token; // Assuming the User model stores Firebase token

            if ($fcmToken) {
                // Send the notification using the Firebase SDK
                FacadesFirebase::sendNotification($fcmToken, [
                    'title' => 'Reminder',
                    'body' => 'Your scheduled time slot is coming up in 1 hour.',
                ]);
            }
        }

        $this->info('Time slot reminder notifications sent!');
    }
}

