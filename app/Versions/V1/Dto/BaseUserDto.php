<?php

namespace App\Versions\V1\Dto;

use App\Enums\RolePermissionEnum;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\EnumCaster;

abstract class BaseUserDto extends BaseDto implements UserDtoContract
{
    #[CastWith(EnumCaster::class, RolePermissionEnum::class)]
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