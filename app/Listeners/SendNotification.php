<?php

namespace App\Listeners;

use App\Models\Client;
use App\Models\Notification;
use App\Events\ReservationVerified;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ReservationVerified $reservationVerified): void
    {
        if ($reservationVerified->verified) {
            Notification::create([
                'client_id' => $reservationVerified->client_id,
                'group' => $reservationVerified->group,
                'ticket_numbers' => $reservationVerified->number,
                'accepted' => $reservationVerified->verified,
                'read_at' => null,
            ]);
        } else {
            Notification::create([
                'client_id' => $reservationVerified->client_id,
                'group' => $reservationVerified->group,
                'reason' => 'Event reached its maximum capacity.',
                'ticket_numbers' => $reservationVerified->number,
                'accepted' => $reservationVerified->verified,
                'read_at' => null,
            ]);
        }
    }
}
