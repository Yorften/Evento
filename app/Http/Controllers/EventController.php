<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Event;
use App\Models\Category;
use App\Models\Organizer;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;
use App\Events\EventModeUpdated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\ClientEvent;
use Illuminate\Support\Facades\Gate;


class EventController extends Controller
{

    use ImageUpload;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $now = Carbon::now()->toDateTimeString();
        // change back to true later;
        $events = Event::with('organizer.user', 'category')->where('verified', true)->where('date', '>', $now)->orderBy('date')->filter(request(['category', 'title']))->paginate(6);
        $category_filter = request()->input('category');
        $categories = Category::all();
        return view('events.index', compact('events', 'categories', 'category_filter'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        // $response = Gate::inspect('update', $event);
        // dd($response);

        if ($event->verified) {
            $event->load('category', 'organizer.user', 'clients');
            return view('events.show', compact('event'));
        }
        return abort('404');
    }


    /*
    **
    ** Organizer functions
    */

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $validated = $request->validated();
        if (count($validated) == 1) {
            $event->update($validated);
            if ($validated['auto'] == 1) {
                event(new EventModeUpdated($event));
                return back()->with([
                    'message' => 'Mode updated successfully to automatic. Any previous pending reservations will be accepted by date.',
                    'operationSuccessful' => true,
                ]);
            }
            return back()->with([
                'message' => 'Mode updated successfully to manual.',
                'operationSuccessful' => true,
            ]);
        }

        $validated['read_at'] = null;
        $validated['verified'] = null;

        $event->update($validated);

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
        if ($event->image) {
            Storage::delete('public/' . $event->image->path);
            $event->image->delete();
        }

        $event->delete();

        return back()->with([
            'message' => 'Event deleted successfully!',
            'operationSuccessful' => true,
        ]);
    }

    public function clients(Event $event)
    {

        $event->load('clients.user');
        $clients = $event->clients()->with('user')->wherePivot('verified', true)->orWherePivotNull('verified')->withPivot('verified', 'group')->wherePivot('event_id', $event->id)->get();
        return view('dashboard.organizer.events.clients', compact('clients', 'event'));
    }


    public function accepted()
    {
        $organizer = Organizer::where('user_id', Auth::id())->first();
        $now = Carbon::now()->toDateTimeString();
        $events = Event::where('organizer_id', $organizer->id)->where('verified', true)->where('date', '>', $now)->orderBy('date')->get();
        $categories = Category::all();
        return view('dashboard.organizer.events.index', compact('events', 'categories'));
    }

    public function pending()
    {
        $organizer = Organizer::where('user_id', Auth::id())->first();
        $now = Carbon::now()->toDateTimeString();
        $events = Event::where('organizer_id', $organizer->id)->where('verified', null)->where('date', '>', $now)->orderBy('date')->with('category')->get();
        $categories = Category::all();
        return view('dashboard.organizer.events.pending', compact('events', 'categories'));
    }

    public function rejected()
    {
        $organizer = Organizer::where('user_id', Auth::id())->first();
        $now = Carbon::now()->toDateTimeString();
        $events = Event::where('organizer_id', $organizer->id)->where('verified', false)->where('date', '>', $now)->orderBy('date')->with('category')->get();
        $categories = Category::all();
        return view('dashboard.organizer.events.rejected', compact('events', 'categories'));
    }

    public function history()
    {
        $now = Carbon::now()->toDateTimeString();
        $organizer = Organizer::where('user_id', Auth::id())->first();
        $events = Event::where('organizer_id', $organizer->id)->where('verified', true)->where('date', '<', $now)->orderBy('date')->get();
        return view('dashboard.organizer.events.history', compact('events'));
    }

    /*
    **
    ** Admin functions
    */

    public function stats()
    {
        $today = Carbon::today();
        $new_users = User::whereDate('created_at', $today)->count();
        $reservations = ClientEvent::where('verified', true)->count();
        return view('dashboard.admin.index', compact('new_users', 'reservations'));
    }


    public function adminIndex()
    {
        $now = Carbon::now()->toDateTimeString();
        $events = Event::where('verified', null)->where('date', '>', $now)->orderBy('date')->get();
        return view('dashboard.admin.events.index', compact('events'));
    }

    public function verify(Event $event)
    {
        $event->update([
            'verified' => true,
            'read_at' => null,
        ]);
        return back()->with([
            'message' => 'Event approved succsessfully!',
            'operationSuccessful' => true,
        ]);
    }


    public function reject(Request $request, Event $event)
    {
        $validated = $request->validate([
            'reason' => 'required',
        ]);
        $event->update([
            'verified' => false,
            'reason' => $validated['reason'],
            'read_at' => null,
        ]);
        return back()->with([
            'message' => 'Event rejected succsessfully! The orgnizer will be notified with this change.',
            'operationSuccessful' => true,
        ]);
    }


    public function preview(Event $event)
    {
        if ($event->verified == null) {
            $event->load('category', 'organizer.user', 'clients');
            return view('events.show', compact('event'));
        }
        return abort('404');
    }

    /*
    **
    ** 
    */

    public function latest()
    {
        // change to true
        $events = Event::where('verified', true)->where('date', '>', now()->toDateTimeString())->orderBy('date')->get();
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
        $week = Carbon::now()->addDays(15)->toDateTimeString();
        if ($week > $validated['date']) {
            return back()->with([
                'message' => 'The start date of the event must be at least 15 days from today\'s date. Please choose a later date.',
                'operationSuccessful' => false,
            ]);
        }
        $event = Event::create($validated);

        if ($request->hasFile('image')) {
            $this->storeImg($request->file('image'), $event);
        }

        return back()->with([
            'message' => 'Event created successfully. You can check your event status in your pending events in the dashboard',
            'operationSuccessful' => true,
        ]);
    }
}
