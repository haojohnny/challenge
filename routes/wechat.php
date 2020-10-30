<?php
// +--
// | https://github.com/haojohnny
// | @Author: Johnny
// | Date: 2020/10/29 13:59
// | Remark:
// |

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeChat\ServeController;

Route::prefix('wechat')->group(function () {
    Route::any('/entry', [ServeController::class, 'entry']);
});
