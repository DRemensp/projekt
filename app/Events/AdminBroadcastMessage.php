<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdminBroadcastMessage implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public string $message;

    /** @var array<int, string> */
    protected array $targets;

    /**
     * @param array<int, string> $targets
     */
    public function __construct(string $message, array $targets)
    {
        $this->message = $message;
        $this->targets = $targets;
    }

    public function broadcastOn(): array
    {
        $channels = [];

        if (in_array('guests', $this->targets, true)) {
            $channels[] = new Channel('admin-message.guests');
        }

        if (in_array('teachers', $this->targets, true)) {
            $channels[] = new PrivateChannel('admin-message.teachers');
        }

        if (in_array('klasses', $this->targets, true)) {
            $channels[] = new PrivateChannel('admin-message.klasses');
        }

        return $channels;
    }

    public function broadcastAs(): string
    {
        return 'admin.message';
    }
}
