<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $proposalId;

    public function __construct(Message $message)
    {
        $this->message = $message;
        $this->proposalId = $message->proposal_id;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('proposal.' . $this->proposalId),
        ];
    }

    public function broadcastAs(): string
    {
        return 'MessageSent';
    }
}
