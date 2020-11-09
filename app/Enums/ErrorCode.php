<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ErrorCode extends Enum
{
    const Success = 0;

    const RpcError = 10002;

    const UserNotFound = 20001;
}
