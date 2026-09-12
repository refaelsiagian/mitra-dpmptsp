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
        $channels = [
            new PrivateChannel('proposal.' . $this->proposalId),
        ];

        // Determine recipient user ID for global notification
        $proposal = $this->message->proposal()->with(['company', 'project.company'])->first();
        if ($proposal) {
            $senderCompanyId = $this->message->company_id;
            $recipientCompany = $senderCompanyId === $proposal->company_id 
                ? $proposal->project->company 
                : $proposal->company;
                
            if ($recipientCompany && $recipientCompany->user_id) {
                $channels[] = new PrivateChannel('users.' . $recipientCompany->user_id);
            }
        }

        return $channels;
    }

    public function broadcastAs(): string
    {
        return 'MessageSent';
    }
}
