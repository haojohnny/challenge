<?php
// +--
// | https://github.com/haojohnny
// | @Author: Johnny
// | Date: 2020/11/3 15:20
// | Remark:小程序会话管理控制器
// |

namespace App\Http\Controllers\WeChat\MiniProgram;

use App\Http\Controllers\Controller;

// 引入会话管理Services命名空间
use App\Http\Resources\WeChat\User;
use App\Services\WeChat\MiniProgram\Session\{
    LoginService, RegisterService
};

// 引入请求Requests命名空间
use App\Http\Requests\WeChat\MiniProgram\{
    LoginRequest, RegisterRequest
};

class SessionController extends Controller
{
    /**
     * @param LoginRequest $request
     * @param LoginService $login
     * @return User
     * @throws \App\Exceptions\NotFoundException
     * @throws \App\Exceptions\WeChatRpcException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function login(LoginRequest $request, LoginService $login)
    {
        $requestData = $request->validated();
        $loginUser = $login->execute($requestData['code']);

        return new User($loginUser);
    }


    /**
     * @param RegisterRequest $request
     * @param RegisterService $register
     * @return User
     * @throws \EasyWeChat\Kernel\Exceptions\DecryptException
     */
    public function register(RegisterRequest $request, RegisterService $register)
    {
        $requestData = $request->validated();

        $register = $register->execute(
            $requestData['encryptedData'],
            $requestData['rawData'],
            $requestData['iv'],
            $requestData['signature']
        );

        return new User($register);
    }
}
