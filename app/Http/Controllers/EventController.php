<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Event;
use App\Models\Category;
use App\Models\Organizer;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreEventRequest;

class EventController extends Controller
{

    use ImageUpload;
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


    public function clients(Event $event)
    {
        $event->load('clients.user');
        return view('dashboard.organizer.events.show', compact('event'));
    }


    public function accepted()
    {
        $now = Carbon::now()->toDateTimeString();
        $events = Event::where('verified', true)->where('date', '>', $now)->orderBy('date')->get();
        return view('dashboard.organizer.events.index', compact('events'));
    }

    public function pending()
    {
        $now = Carbon::now()->toDateTimeString();
        $events = Event::where('verified', false)->where('date', '>', $now)->orderBy('date')->get();
        $categories = Category::all();
        return view('dashboard.organizer.events.pending', compact('events', 'categories'));
    }

    public function history()
    {
        $events = Event::where('verified', true)->orderBy('date')->get();
        return view('dashboard.organizer.events.history', compact('events'));
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
    public function store(StoreEventRequest $request)
    {
        $validated = $request->validated();
        $organizer = Organizer::where('user_id', Auth::id())->first();
        $validated['organizer_id'] = $organizer->id;
        $validated['date'] = date('Y-m-d H:i:s', strtotime($validated['date']));
        $event = Event::create($validated);

        if ($request->hasFile('image')) {
            $this->storeImg($request->file('image'), $event);
        }

        return back()->with([
            'message' => 'Event created successfully!',
            'operationSuccessful' => true,
        ]);
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
        if ($request->hasFile('image')) {
            $this->storeImg($request->file('image'), $event);
            $this->upadateImg($request->file('image'), $event);
        }

        return back()->with([
            'message' => 'Event updated successfully!',
            'operationSuccessful' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return back()->with([
            'message' => 'Event deleted successfully!',
            'operationSuccessful' => true,
        ]);
    }
}
