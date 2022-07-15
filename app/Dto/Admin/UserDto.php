<?php

namespace App\Dto\Admin;

use App\Enums\RolePermissionEnum;
use App\Versions\V1\Http\Requests\Admin\UserRequest;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class UserDto extends DataTransferObject
{
    public string $password;
    #[CastWith(RolePermissionEnum::class)]
    public RolePermissionEnum $role;

    public static function fromRequest(UserRequest $request): UserDto
    {
        return new self($request->validated());
    }
}
