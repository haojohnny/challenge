<?php
// +--
// | https://github.com/haojohnny
// | @Author: Johnny
// | Date: 2020/11/3 15:20
// | Remark:微信小程序用户登出成功事件
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

class UserLogoutSuccess
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $user;

    /**
     * LoginSuccess constructor.
     * @param WeChatUser $logoutUser
     */
    public function __construct(WeChatUser $logoutUser)
    {
        $this->user = $logoutUser;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('WeChat/MiniProgram/UserLogoutSuccess');
    }
}
