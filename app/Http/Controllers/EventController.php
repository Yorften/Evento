<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::paginate(6);
        return view('events.index', compact('events'));
    }

    /*
    **
    ** Organizer functions
    */


    public function clients()
    {
        return view('dashboard.organizer.events.show');
    }


    public function accepted()
    {
        $events = Event::all();
        return view('dashboard.organizer.events.index', compact('events'));
    }

    public function pending()
    {
        $events = Event::where('verified', false)->get();
        return view('dashboard.organizer.events.pending', compact('events'));
    }

    public function history()
    {
        $events = Event::paginate(6);
        return view('dashboard.organizer.events.history');
    }

    /*
    **
    ** Admin functions
    */

    public function stats()
    {
        return view('dashboard.admin.index');
    }


    public function adminIndex()
    {
        $events = Event::all();
        return view('dashboard.admin.events.index', compact('events'));
    }

    /*
    **
    ** 
    */

    public function latest()
    {
        $events = Event::where('date', '>', now()->toDateTimeString())->orderBy('date')->get();
        return view('welcome', compact('events'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event->load('category', 'organizer.user', 'clients');
        return view('events.show', compact('event'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}
