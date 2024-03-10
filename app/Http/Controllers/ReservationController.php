<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\Client;
use App\Models\ClientEvent;
use Illuminate\Http\Request;
use App\Events\ReservationVerified;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreReservationRequest;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $now = Carbon::now()->toDateTimeString();
        $client = Client::where('user_id', Auth::id())->first();
        $events = $client->events()->where('date', '>', $now)->wherePivot('verified', true)->withPivot('created_at', 'group')->get();
        return view('dashboard.client.reservations.index', compact('events'));
    }

    public function history()
    {
        $now = Carbon::now()->toDateTimeString();
        $client = Client::where('user_id', Auth::id())->first();
        $events = $client->events()->where('date', '<', $now)->wherePivot('verified', true)->withPivot('created_at')->get();
        return view('dashboard.client.reservations.history', compact('events'));
    }

    public function pending()
    {
        $now = Carbon::now()->toDateTimeString();
        $client = Client::where('user_id', Auth::id())->first();
        $events = $client->events()->where('date', '>', $now)->wherePivot('verified', null)->withPivot('created_at')->get();
        return view('dashboard.client.reservations.pending', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReservationRequest $request)
    {
        $validated = $request->validated();
        $event = Event::find($validated['event_id']);

        if ($validated['tickets'] > $event->capacity) {
            return back()->with([
                'message' => 'The number of tickets you\'re trying to reserve exceeds the available capacity.',
                'operationSuccessful' => false,
            ]);
        }

        $client = Client::where('user_id', Auth::id())->first();
        $ticket_group = 'group_' . uniqid() . '_' . bin2hex(random_bytes(8));
        if ($event->auto) {
            for ($i = 0; $i < $validated['tickets']; $i++) {
                $event->clients()->attach($client->id, ['group' => $ticket_group, 'created_at' => now(), 'updated_at' => now(), 'verified' => true]);
            }

            return back()->with([
                'message' => 'Ticket(s) reserved successfully! You can view your tickets in your dashboard.',
                'operationSuccessful' => true,
            ]);
        } else {
            for ($i = 0; $i < $validated['tickets']; $i++) {
                $event->clients()->attach($client->id, ['group' => $ticket_group, 'created_at' => now(), 'updated_at' => now()]);
            }

            return back()->with([
                'message' => 'Ticket(s) reserved successfully! Awaiting organizer verification.',
                'operationSuccessful' => true,
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($group)
    {
        $client = Client::where('user_id', Auth::id())->first();
        $event = $client->events()->wherePivot('group', $group)->withPivot('group')->first();
        return view('ticket.view', compact('event'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function verify($group)
    {
        $reservations = ClientEvent::where('group', $group)->get();
        $event = Event::find($reservations->first()->event_id);

        $counter = 0;
        $rejected = 0;
        $accepted = 0;

        $places = $event->capacity - ($event->clients ? $event->clients()->wherePivot('verified', true)->count() : 0);


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
            event(new ReservationVerified($group, $rejected, false, $reservations->first()->client_id));
        }
        if ($accepted > 0) {
            event(new ReservationVerified($group, $accepted, true, $reservations->first()->client_id));
        }

        if ($accepted == 0) {
            return back()->with([
                'message' => 'Event capacity reached its limit. Rservations got rejected.',
                'operationSuccessful' => false,
            ]);
        }
        if ($rejected == 0) {
            return back()->with([
                'message' => 'Reservations approved successfully. The client will be notified of this change.',
                'operationSuccessful' => true,
            ]);
        }
        if ($accepted > 0 && $rejected > 0) {
            return back()->with([
                'message' => 'Event capacity reached its limit. Only ' . $accepted . ' reservation(s) got verified.',
                'operationSuccessful' => false,
            ]);
        }
    }

    public function reject($group)
    {
        $reservations = ClientEvent::where('group', $group)->get();

        foreach ($reservations as $reservation) {
            $reservation->update([
                'verified' => false,
            ]);
        }
        event(new ReservationVerified($group, $reservations->count(), false, $reservations->first()->client_id));
        return back()->with([
            'message' => 'Reservations rejected successfully. The client will be notified of this change.',
            'operationSuccessful' => true,
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}
