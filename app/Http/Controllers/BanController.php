<?php

namespace App\Http\Controllers;

use App\Models\Ban;
use App\Models\User;
use Illuminate\Http\Request;

class BanController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user)
    {
        $validated = $request->validate([
            'reason' => 'required',
        ]);
        $validated['user_id'] = $user->id;
        $ban = Ban::create($validated);
        return back()->with([
            'message' => 'User banned successfully!',
            'operationSuccessful' => true,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ban $ban)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->bans()->delete();
        return back()->with([
            'message' => 'User unbanned successfully!',
            'operationSuccessful' => true,
        ]);
    }
}
