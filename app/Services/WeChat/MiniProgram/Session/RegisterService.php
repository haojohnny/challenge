<?php
// +--
// | https://github.com/haojohnny
// | @Author: Johnny
// | Date: 2020/11/3 15:20
// | Remark:
// |

namespace app\Services\WeChat\MiniProgram\Session;

use App\Enums\SessionKey;
use App\Events\WeChat\MiniProgram\RegisterSuccess;
use App\Repositories\WeChatUserRepository;
use Overtrue\LaravelWeChat\Facade;

class RegisterService
{
    /**
     * @var WeChatUserRepository
     */
    protected $weChatUserRepository;

    public function __construct(WeChatUserRepository $userRepository)
    {
        $this->weChatUserRepository = $userRepository;
    }

    /**
     * @param $encryptedData
     * @param $iv
     * @param $signature
     * @return \App\Models\WeChatUser
     * @throws \EasyWeChat\Kernel\Exceptions\DecryptException
     */
    public function execute($encryptedData, $rawData, $iv, $signature)
    {
        $sessionInfo = request()->session()->get(SessionKey::WeChatMiniProgramUserInfo);
        if (! $sessionInfo['session_key']) {

        }

        // 解密数据
        $decryptedData = Facade::miniProgram()->encryptor->decryptData($sessionInfo['session_key'], $iv, $encryptedData);
        if (!$decryptedData) {

        }

        $userInfo = $this->weChatUserRepository->create();

        // 向监听器派发注册成功事件
        event(new RegisterSuccess($userInfo));

        return $userInfo;
    }
}
