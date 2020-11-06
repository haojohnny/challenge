<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ErrorCode extends Enum
{
    const Success = 0;
    const SystemError = 10001;
    const RpcError = 10002;

    const NotFound = 20001;
    const NotLogin = 20002;
}
