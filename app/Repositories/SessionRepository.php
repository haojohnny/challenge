<?php
// +--
// | https://github.com/haojohnny
// | @Author: Johnny
// | Date: 2020/11/10 11:18
// | Remark: 会话数据仓库
// |

namespace App\Repositories;

use App\Enums\SessionKey;
use App\Models\WeChatUser;

class SessionRepository
{
    /**
     * 获取小程序会话数据加密key
     * @return string | null
     */
    public function getSessionKey()
    {
        return request()->session()->get(SessionKey::WeChatMiniProgramSessionKey);
    }

    /**
     * 保存小程序会话数据加密key
     * @param string $sessionKey
     */
    public function putSessionKey(string $sessionKey)
    {
        request()->session()->put(SessionKey::WeChatMiniProgramSessionKey, $sessionKey);
    }

    /**
     * 保存小程序用户信息
     * @param WeChatUser $userInfo
     */
    public function putUserInfo(WeChatUser $userInfo)
    {
        request()->session()->put(SessionKey::WeChatMiniProgramUserInfo, $userInfo);
    }
}
