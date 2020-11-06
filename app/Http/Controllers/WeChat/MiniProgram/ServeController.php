<?php
// +--
// | https://github.com/haojohnny
// | @Author: Johnny
// | Date: 2020/10/29 11:46
// | Remark:小程序回调服务控制器
// |

namespace App\Http\Controllers\WeChat\MiniProgram;

use App\Http\Controllers\Controller;

class ServeController extends Controller
{
    public function entry()
    {
        return 'entry';
    }
}
