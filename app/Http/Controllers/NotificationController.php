<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Notification $notification)
    {
        $event = $notification->client()->first()->events()->wherePivot('group', $notification->group)->first();
        $notification->update([
            'read_at' => now(),
        ]);
        return view('notifications.show', compact('notification', 'event'));
    }
}
