<?php
// +--
// | https://github.com/haojohnny
// | @Author: Johnny
// | Date: 2020/11/3 15:20
// | Remark:微信小程序用户登录成功事件
// |

namespace App\Events\WeChat\MiniProgram;

use App\Http\Requests\WeChat\MiniProgram\LoginRequest;
use App\Models\WeChatUser;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LoginSuccess
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $loginUser;

    /**
     * LoginSuccess constructor.
     * @param WeChatUser $weChatUser
     */
    public function __construct(WeChatUser $loginUser)
    {
        $this->loginUser = $loginUser;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('WeChat/MiniProgram/LoginSuccess');
    }
}
