<?php

namespace App\Versions\V1\Dto;

use App\Enums\RolePermissionEnum;

interface UserDtoContract
{
    public function forFillArray(): array;

    public function getRole(): RolePermissionEnum;
}