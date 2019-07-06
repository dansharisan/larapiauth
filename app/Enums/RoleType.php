<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class RoleType extends Enum
{
  const Administrator = 'admin';
  const Moderator = 'mod';
  const Member = 'member';
}
