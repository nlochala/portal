<?php

namespace App\Events;

use App\ParentMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ParentMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public $broadcastQueue = 'broadcast-queue';

    /**
     * Create a new event instance.
     *
     * @param ParentMessage $message
     */
    public function __construct(ParentMessage $message)
    {
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('user.'.$this->message->to->person->user->uuid);
    }

    /**
     * What to send.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'icon' => 'info',
            'title' => 'New Message: ',
            'text' => $this->message->subject,
        ];

    }
}
