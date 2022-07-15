<?php

namespace App\Caster;

use App\Enums\TeamRoleEnum;
use Spatie\DataTransferObject\Caster;

class TeamRoleEnumCaster implements Caster
{
    public function cast(mixed $value): TeamRoleEnum
    {
        return TeamRoleEnum::tryFrom($value);
    }
}
