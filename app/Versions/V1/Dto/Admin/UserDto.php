<?php

namespace App\Versions\V1\Dto\Admin;

use App\Enums\RolePermissionEnum;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class UserDto extends DataTransferObject
{
    public string $password;
    #[CastWith(RolePermissionEnum::class)]
    public RolePermissionEnum $role;

    public static function fromRequest(\App\Versions\V1\Http\Requests\Admin\UserRequest $request): UserDto
    {
        return new self($request->validated());
    }
}
