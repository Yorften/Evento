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
        $events = $client->events()->where('date', '>', $now)->wherePivot('accepted', true)->withPivot('created_at')->get();
        return view('dashboard.client.reservations.index', compact('events'));
    }

    public function history()
    {
        $now = Carbon::now()->toDateTimeString();
        $client = Client::where('user_id', Auth::id())->first();
        $events = $client->events()->where('date', '<', $now)->wherePivot('accepted', true)->withPivot('created_at')->get();
        return view('dashboard.client.reservations.history', compact('events'));
    }

    public function pending()
    {
        $now = Carbon::now()->toDateTimeString();
        $client = Client::where('user_id', Auth::id())->first();
        $events = $client->events()->where('date', '>', $now)->wherePivot('accepted', false)->withPivot('created_at')->get();
        return view('dashboard.client.reservations.pending', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReservationRequest $request)
    {
        $validated = $request->validated();
        $event = Event::find($validated['event_id']);
        $client = Client::where('user_id', Auth::id())->first();
        for ($i = 0; $i < $validated['tickets']; $i++) {
            $event->clients()->attach($client->id, ['created_at' => now(), 'updated_at' => now()]);
        }

        return back()->with([
            'message' => 'Ticket(s) reserved successfully! Awaiting organizer verification.',
            'operationSuccessful' => true,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
