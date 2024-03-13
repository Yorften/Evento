<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Event;
use Illuminate\Auth\Access\Response;

class EventPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Event $event): Response
    {
        dd($event);
        return $event->verified
            ? Response::allow()
            : Response::denyWithStatus(404);
    }
}
