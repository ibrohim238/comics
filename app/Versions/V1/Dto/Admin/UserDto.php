<?php

namespace App\Versions\V1\Dto\Admin;

use App\Caster\HashMakeCaster;
use App\Enums\RolePermissionEnum;
use App\Versions\V1\Dto\BaseUserDto;
use App\Versions\V1\Http\Requests\Admin\UserRequest;
use Spatie\DataTransferObject\Attributes\CastWith;

class UserDto extends BaseUserDto
{
    #[CastWith(HashMakeCaster::class)]
    public string $password;
    public RolePermissionEnum $role;

    public static function fromRequest(UserRequest $request): UserDto
    {
        return new self($request->validated());
    }
}
