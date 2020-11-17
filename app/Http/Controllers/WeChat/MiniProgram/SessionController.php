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
    LoginService, LogoutService, RegisterService
};

// 引入请求Requests命名空间
use App\Http\Requests\WeChat\MiniProgram\{
    LoginRequest, RegisterRequest
};

class SessionController extends Controller
{
    /**
     * 登入
     * @param LoginRequest $request
     * @param LoginService $login
     * @return User
     * @throws \App\Exceptions\NotFoundException
     * @throws \App\Exceptions\RpcException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function login(LoginRequest $request, LoginService $loginService)
    {
        $requestData = $request->validated();
        $loginUser = $loginService->execute($requestData['code']);

        return new User($loginUser);
    }

    /**
     * 注册并登入
     * @param RegisterRequest $request
     * @param RegisterService $registerService
     * @param LoginService $loginService
     * @return User
     * @throws \EasyWeChat\Kernel\Exceptions\DecryptException
     */
    public function register(RegisterRequest $request, RegisterService $registerService, LoginService $loginService)
    {
        $requestData = $request->validated();

        // 注册
        $registerUser = $registerService->execute(
            $requestData['encryptedData'],
            $requestData['iv']
        );

        // 登入
        $loginService->login($registerUser);

        return new User($registerUser);
    }

    /**
     * 登出
     * @param LogoutService $logoutService
     * @throws \App\Exceptions\NotFoundException
     */
    public function logout(LogoutService $logoutService)
    {
        $logoutService->execute();
    }
}
