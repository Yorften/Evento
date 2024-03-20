<?php

namespace App\Listeners;

use App\Events\EventModeUpdated;
use Illuminate\Support\Facades\DB;
use App\Events\ReservationRejected;
use App\Events\ReservationVerified;
use App\Models\ClientEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyReservations
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
    public function handle(EventModeUpdated $eventModeUpdated): void
    {
        $event = $eventModeUpdated->event;

        $counter = 0;
        $places = $event->capacity - ($event->clients ? $event->clients()->wherePivot('verified', true)->count() : 0);

        $reservations = ClientEvent::where('event_id', $event->id)->where('verified', null)->get();

        $reservationsByGroup = $reservations->groupBy(function ($reservation) {
            return $reservation->group;
        });
        foreach ($reservationsByGroup as $group => $reservations) {
            $rejected = 0;
            $accepted = 0;
            foreach ($reservations as $reservation) {
                if ($counter >= $places) {
                    $reservation->update([
                        'verified' => false,
                    ]);
                    $rejected++;
                } else {
                    $reservation->update([
                        'verified' => true,
                    ]);
                    $accepted++;
                }
                $counter++;
            }
            if ($rejected > 0) {
                event(new ReservationVerified($group, $rejected, false, $reservation->client_id));
            }
            if ($accepted > 0) {
                event(new ReservationVerified($group, $accepted, true, $reservation->client_id));
            }
        }
    }
}
