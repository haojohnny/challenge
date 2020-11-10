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
        $sessionInfo = request()->session()->get(SessionKey::WeChatMiniProgramSessionKey);
        // 解密数据
        $decryptedData = $encrypt->decryptData($sessionInfo['session_key'], $iv, $encryptedData);
        // 从数据库中获取该用户信息
        $userInfo = $this->weChatUserRepository->getByOpenId($decryptedData['openId']);
        if (!$userInfo) {
            // 未注册时，保存该用户
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
        } else {
            // 已注册时，头像和昵称有变化时将会更新
            $userInfo->avatar = $decryptedData['avatarUrl'];
            $userInfo->nickname = $decryptedData['nickName'];
            // 更新事件由模型定义的观察者处理
            $userInfo->save();
        }

        return $userInfo;
    }
}
