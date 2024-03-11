<?php

namespace App\Http\Controllers;

use App\Models\Organizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\StoreOrganizerRequest;
use App\Http\Requests\UpdateOrganizerRequest;

class OrganizerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $organizers = Organizer::all();
        $organizers->load('user.bans');
        return view('dashboard.admin.organizers.index', compact('organizers'));
    }


    public function stats()
    {
        return view('dashboard.organizer.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.organizer_register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrganizerRequest $request)
    {

        $validated = $request->validated();

        $validated['user_id'] = Auth::id();

        Organizer::create($validated);

        return redirect(RouteServiceProvider::HOME);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrganizerRequest $request, Organizer $organizer)
    {
        $validated = $request->validated();

        $organizer->update($validated);

        return back()->with([
            'message' => 'Organization information updated successfully',
            'operationSuccessful' => true,
        ]);
    }
}
