<?php
// +--
// | https://github.com/haojohnny
// | @Author: Johnny
// | Date: 2020/10/29 13:59
// | Remark:
// |

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeChat\MiniProgram\ServeController;
use App\Http\Controllers\WeChat\MiniProgram\SessionController;

Route::prefix('wechat')->group(function () {
    Route::any('/entry', [ServeController::class, 'entry']);      // 微信回调入口
    Route::any('/login', [SessionController::class, 'login']);    // 登录接口
    Route::any('/register', [SessionController::class, 'register']);   // 注册接口
});
