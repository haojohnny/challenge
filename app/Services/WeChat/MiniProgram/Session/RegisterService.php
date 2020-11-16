<?php
// +--
// | https://github.com/haojohnny
// | @Author: Johnny
// | Date: 2020/11/3 15:20
// | Remark:
// |

namespace app\Services\WeChat\MiniProgram\Session;

use App\Events\WeChat\MiniProgram\UserRegisterSuccess;
use App\Repositories\SessionRepository;
use App\Repositories\WeChatUserRepository;
use Overtrue\LaravelWeChat\Facade;

class RegisterService
{
    /**
     * 微信用户仓库
     * @var WeChatUserRepository
     */
    protected $weChatUserRepository;

    /**
     * 会话数据仓库
     * @var SessionRepository
     */
    protected $sessionRepository;

    public function __construct(WeChatUserRepository $userRepository, SessionRepository $sessionRepository)
    {
        $this->weChatUserRepository = $userRepository;
        $this->sessionRepository = $sessionRepository;
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
        $sessionKey = $this->sessionRepository->getSessionKey();

        // 解密数据
        $decryptedData = $encrypt->decryptData($sessionKey, $iv, $encryptedData);

        // 已注册时，返回已注册用户
        if ($registeredUser = $this->weChatUserRepository->getByOpenId($decryptedData['openId'])) {
            return $registeredUser;
        }

        // 未注册时，注册该用户
        $newRegisterUser = $this->weChatUserRepository->create(
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
        event(new UserRegisterSuccess($newRegisterUser));

        return $newRegisterUser;
    }
}
