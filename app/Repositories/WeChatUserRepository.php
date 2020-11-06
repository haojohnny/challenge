<?php
// +--
// | https://github.com/haojohnny
// | @Author: Johnny
// | Date: 2020/10/23 17:46
// | Remark:
// |

namespace App\Repositories;

use App\Models\WeChatUser;

/**
 * Class WeChatUserRepository
 * @package App\Repositories
 */
class WeChatUserRepository
{
    protected $weChatUser;

    public function __construct(WeChatUser $user)
    {
        $this->weChatUser = $user;
    }

    /**
     * @param $openId
     * @return mixed | WeChatUser| null
     */
    public function getByOpenId($openId = 'test')
    {
        return $this->weChatUser->where('openid', $openId)->first();
    }

    /**
     * @return WeChatUser
     */
    public function create()
    {
        return ;
    }
}
