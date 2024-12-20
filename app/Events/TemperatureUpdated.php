<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TemperatureUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $temperatureHistory;

    public function __construct($temperatureHistory)
    {
        $this->temperatureHistory = $temperatureHistory;
    }

    public function broadcastOn()
    {
        return new Channel('temperature-updates');
    }

    public function broadcastAs()
    {
        return 'temperature.updated';
    }
}
