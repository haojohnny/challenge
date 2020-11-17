<?php
// +--
// | https://github.com/haojohnny
// | @Author: Johnny
// | Date: 2020/11/3 15:20
// | Remark:微信小程序用户登入服务
// |

namespace App\Services\WeChat\MiniProgram\Session;

use App\Enums\ErrorCode;
use App\Events\WeChat\MiniProgram\UserLoginSuccess;
use App\Exceptions\NotFoundException;
use App\Exceptions\RpcException;
use App\Repositories\SessionRepository;
use App\Repositories\WeChatUserRepository;
use Overtrue\LaravelWeChat\Facade;

class LoginService
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
     * @param $code
     * @return \App\Models\WeChatUser|mixed|null
     * @throws NotFoundException
     * @throws RpcException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function execute(string $code)
    {
        // 根据code请求微信服务器获取session_key和openid
        $response = Facade::miniProgram()->auth->session($code);
        if (isset($response['errcode'])) {
            throw new RpcException($response['errmsg'], ErrorCode::WeChatRpcError);
        }

        // 保存session_key
        $this->sessionRepository->putSessionKey($response['session_key']);

        // 根据openid从数据库中获取用户信息
        $userInfo = $this->weChatUserRepository->getByOpenId($response['openid']);
        if (empty($userInfo)) {
            throw new NotFoundException(sprintf('user not found:[openid:%s]', $response['openid']), ErrorCode::UserNotFound);
        }

        // 保存用户id到会话
        $this->sessionRepository->putUserId($userInfo->id);

        // 向监听器派发登录成功事件
        event(new UserLoginSuccess($userInfo));

        // 返回登录用户
        return $userInfo;
    }
}
