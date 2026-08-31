<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChirpUnliked implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chirpId;

    public function __construct($chirpId)
    {
        $this->chirpId = $chirpId;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('chirps-activity'), // Тот же канал, что и для лайков
        ];
    }
}
