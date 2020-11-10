<?php
// +--
// | https://github.com/haojohnny
// | @Author: Johnny
// | Date: 2020/11/3 15:20
// | Remark:
// |

namespace App\Services\WeChat\MiniProgram\Session;

use App\Enums\ErrorCode;
use App\Enums\SessionKey;
use App\Events\WeChat\MiniProgram\LoginSuccess;
use App\Exceptions\NotFoundException;
use App\Exceptions\RpcException;
use App\Repositories\WeChatUserRepository;
use Overtrue\LaravelWeChat\Facade;

class LoginService
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
     * @param $code
     * @return \App\Models\WeChatUser|mixed|null
     * @throws NotFoundException
     * @throws RpcException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function execute($code)
    {
        // 根据code请求微信服务器获取session_key和openid
        $response = Facade::miniProgram()->auth->session($code);
        if (isset($response['errcode'])) {
            throw new RpcException($response['errmsg'], ErrorCode::WeChatRpcError);
        }

        // 保存session_key和openid到会话
        request()->session()->put(SessionKey::WeChatMiniProgramSessionKey, $response);

        // 根据openid从数据库中获取用户信息
        $userInfo = $this->weChatUserRepository->getByOpenId($response['openid']);
        if (empty($userInfo)) {
            throw new NotFoundException(sprintf('user not found:[openid:%s]', $response['openid']), ErrorCode::UserNotFound);
        }

        // 保存到会话
        request()->session()->put(SessionKey::WeChatMiniProgramUserInfo, $userInfo);

        // 向监听器派发登录成功事件
        event(new LoginSuccess($userInfo));

        // 返回登录用户
        return $userInfo;
    }
}
