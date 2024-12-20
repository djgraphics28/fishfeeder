<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TemperatureUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $temp1;
    public $temp2;

    public function __construct($temp1, $temp2)
    {
        $this->temp1 = $temp1;
        $this->temp2 = $temp2;
    }

    public function broadcastOn()
    {
        return new Channel('temperature-channel');
    }
}
