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
     * @return \App\Models\WeChatUser|mixed
     * @throws \EasyWeChat\Kernel\Exceptions\DecryptException
     */
    public function execute($encryptedData, $iv)
    {
        $encrypt = Facade::miniProgram()->encryptor;
        $sessionInfo = request()->session()->get(SessionKey::WeChatMiniProgramUserInfo);
        // 解密数据
        $decryptedData = $encrypt->decryptData($sessionInfo['session_key'], $iv, $encryptedData);
        // 注册用户
        $userInfo = $this->weChatUserRepository->create(
            $decryptedData['openId'],
            $decryptedData['nickName'],
            $decryptedData['avatarUrl'],
            $decryptedData['country'],
            $decryptedData['city'],
            $decryptedData['language'],
            $decryptedData['gender'],
            $decryptedData['unionId'] ?? null
        );

        // 向监听器派发注册成功事件
        event(new RegisterSuccess($userInfo));

        return $userInfo;
    }
}
