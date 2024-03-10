<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreReservationRequest;
use Carbon\Carbon;

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
    public function update(Request $request,)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}
