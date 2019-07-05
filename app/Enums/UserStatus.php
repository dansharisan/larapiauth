<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserStatus extends Enum
{
    const Unactivated = 0;
    const Activated = 1;
    const Banned = 2;
}
