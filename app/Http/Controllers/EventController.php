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
        $evets = Event::paginate(6);
        return view('events', compact('events'));
    }

    public function adminIndex()
    {
        $events = Event::all();
        return view('dashboard.admin.events.index', compact('events'));
    }

    public function pending()
    {
        $events = Event::where('verified', false)->get();
        return view('dashboard.admin.events.pending', compact('events'));
    }

    public function latest()
    {
        return view('welcome');
    }


    public function stats()
    {
        return view('dashboard.admin.index');
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
    public function store(Request $request)
    {
        //
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
