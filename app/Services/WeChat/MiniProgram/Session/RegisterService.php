<?php
// +--
// | https://github.com/haojohnny
// | @Author: Johnny
// | Date: 2020/11/3 15:20
// | Remark:微信小程序用户注册服务
// |

namespace app\Services\WeChat\MiniProgram\Session;

use App\Enums\Gender;
use App\Enums\Status;
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
        $newRegisterUser = $this->registerUser(
            $decryptedData['openId'],
            $decryptedData['nickName'],
            $decryptedData['avatarUrl'],
            $decryptedData['country'],
            $decryptedData['city'],
            $decryptedData['language'],
            $decryptedData['gender'],
            $decryptedData['unionId'] ?? null
        );

        return $newRegisterUser;
    }

    /**
     * 注册用户
     * @param string $openid
     * @param string $nickname
     * @param string $avatar
     * @param string $country
     * @param string $city
     * @param string $language
     * @param int $gender
     * @param string|null $unionId
     * @param string|null $nation
     * @param string|null $mobile
     * @param int $isRobot
     * @return \App\Models\WeChatUser|mixed
     */
    public function registerUser(
        string $openid,
        string $nickname,
        string $avatar,
        string $country,
        string $city,
        string $language,
        int $gender = Gender::Unknown,
        string $unionId = null,
        string $nation = null,
        string $mobile = null,
        int $isRobot = Status::No
    ) {
        // 注册
        $newRegisterUser = $this->weChatUserRepository->create(
            $openid, $nickname, $avatar, $country, $city, $language,
            $gender, $unionId, $nation, $mobile, $isRobot
        );

        // 向监听器派发注册成功事件
        event(new UserRegisterSuccess($newRegisterUser));

        return $newRegisterUser;
    }
}
