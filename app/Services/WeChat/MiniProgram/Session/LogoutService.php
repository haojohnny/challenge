<?php
// +--
// | https://github.com/haojohnny
// | @Author: Johnny
// | Date: 2020/11/3 15:20
// | Remark:微信小程序用户登出服务
// |

namespace App\Services\WeChat\MiniProgram\Session;

use App\Enums\ErrorCode;
use App\Events\WeChat\MiniProgram\UserLogoutSuccess;
use App\Exceptions\NotFoundException;
use App\Models\WeChatUser;
use App\Repositories\SessionRepository;
use App\Repositories\WeChatUserRepository;

class LogoutService
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
     * @return \App\Models\WeChatUser
     * @throws NotFoundException
     */
    public function execute()
    {
        // 当前会话用户登出
        $userId = $this->sessionRepository->getUserId();

        $userInfo = $this->weChatUserRepository->getById($userId);
        if (! $userInfo) {
            throw new NotFoundException(sprintf('user not found:[id:%s]', $userId), ErrorCode::UserNotFound);
        }

        $this->logout($userInfo);

        return $userInfo;
    }

    /**
     * 登出
     * @param WeChatUser $userInfo
     */
    public function logout(WeChatUser $userInfo)
    {
        // 清空会话数据
        request()->session()->flush();

        // 向监听器派发登出成功事件
        event(new UserLogoutSuccess($userInfo));
    }
}
