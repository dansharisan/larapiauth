<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ActiveStatus extends Enum
{
    const Banned = 0;
    const Active = 1;
    const Inactive = 2;
    const Pending = 3;
}
