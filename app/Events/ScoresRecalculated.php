<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class ScoresRecalculated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $teams;

    /**
     * Create a new event instance.
     */
    public function __construct(Collection $teams)
    {
        $this->teams = $teams;
    }
}
