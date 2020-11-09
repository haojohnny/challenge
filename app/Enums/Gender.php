<?php
// +--
// | https://github.com/haojohnny
// | @Author: Johnny
// | Date: 2020/11/9 14:12
// | Remark:
// |

namespace App\Enums;

use BenSampo\Enum\Enum;

final class Gender extends Enum
{
    const Male = 1;
    const Female = 2;
    const Unknown = 0;
}
