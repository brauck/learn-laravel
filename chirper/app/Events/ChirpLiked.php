<?php

namespace App\Events;

use App\Models\Chirp;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow; // Важно: отправка сразу
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChirpLiked implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // Данные, которые полетят по WebSocket (ID чирпа)
    public $chirpId;

    public function __construct($chirpId)
    {
        $this->chirpId = $chirpId;
    }

    // Определяем имя канала. Сделаем его публичным.
    public function broadcastOn(): array
    {
        return [
            new Channel('chirps-activity'),
        ];
    }
}
