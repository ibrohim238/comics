<?php

namespace App\Caster;

use App\Enums\RolePermissionEnum;
use Spatie\DataTransferObject\Caster;

class RolePermissionEnumCaster implements Caster
{
    public function cast(mixed $value): RolePermissionEnum
    {
        if ($value instanceof RolePermissionEnum) {
            return $value;
        }

        return RolePermissionEnum::from($value);
    }
}
