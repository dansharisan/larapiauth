<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ActiveStatus extends Enum
{
    const Inactive = 0;
    const Active = 1;
    const Banned = 2;
}
