<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Yes()
 * @method static static No()
 */
final class Status extends Enum
{
    const Yes = 1;
    const No  = 0;
}
