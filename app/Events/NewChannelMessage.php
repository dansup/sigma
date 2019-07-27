<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Model\{
    Channel as ChannelModel,
    Message
};

class NewChannelMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $channel;
    public $message;
    public $payload;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(ChannelModel $channel, Message $message, $payload)
    {
        $this->channel = $channel;
        $this->message = $message;
        $this->payload = $payload;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('chan.'.$this->channel->id);
    }

    public function broadcastAs()
    {
        return 'message.new';
    }

    public function broadcastWith()
    {
        return $this->payload;
    }
}
