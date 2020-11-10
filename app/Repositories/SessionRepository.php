<?php
// +--
// | https://github.com/haojohnny
// | @Author: Johnny
// | Date: 2020/11/10 11:18
// | Remark:
// |

namespace App\Repositories;

use App\Enums\SessionKey;

class SessionRepository
{
    /**
     * @return mixed
     */
    public function getSessionKey()
    {
        $session = request()->session()->get(SessionKey::WeChatMiniProgramSessionKey);

        return $session['session_key'];
    }

    /**
     * @param $response
     */
    public function putSessionKey($response)
    {
        request()->session()->put(SessionKey::WeChatMiniProgramSessionKey, $response);
    }

    /**
     * @param $userInfo
     */
    public function putUserInfo($userInfo)
    {
        request()->session()->put(SessionKey::WeChatMiniProgramUserInfo, $userInfo);
    }
}
