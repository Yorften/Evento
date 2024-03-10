<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReservationVerified
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $number;
    public $group;
    public $verified;
    public $client_id;
    /**
     * Create a new event instance.
     */
    public function __construct($group, $number, $verified, $client_id)
    {
        $this->group = $group;
        $this->number = $number;
        $this->verified = $verified;
        $this->client_id = $client_id;
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
