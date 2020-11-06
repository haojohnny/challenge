<?php

namespace App\Events\WeChat\MiniProgram;

use App\Models\WeChatUser;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RegisterSuccess
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $registerUser;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(WeChatUser $registerUser)
    {
        $this->registerUser = $registerUser;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('WeChat/MiniProgram/RegisterSuccess');
    }
}
