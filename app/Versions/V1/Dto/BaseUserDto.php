<?php

namespace App\Versions\V1\Dto;

use App\Caster\RolePermissionEnumCaster;
use App\Enums\RolePermissionEnum;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

abstract class BaseUserDto extends DataTransferObject implements UserDtoContract
{
    #[CastWith(RolePermissionEnumCaster::class)]
    public RolePermissionEnum $role;

    public function forFillArray(): array
    {
        return $this->except('role')->toArray();
    }


    public function getRole(): RolePermissionEnum
    {
        return $this->role;
    }
}