<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ActivityLogUpdated implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public function broadcastOn(): array
    {
        return [new Channel('activity-log')];
    }

    public function broadcastAs(): string
    {
        return 'activity.log.updated';
    }
}
