<?php

namespace App\Versions\V1\Dto;

use App\Caster\HashMakeCaster;
use App\Caster\RolePermissionEnumCaster;
use App\Enums\RolePermissionEnum;
use App\Versions\V1\Http\Requests\RegisterRequest;
use Spatie\DataTransferObject\Attributes\CastWith;

class UserDto extends BaseUserDto
{
    public string $name;
    public string $username;
    public string $email;
    #[CastWith(HashMakeCaster::class)]
    public string $password;
    #[CastWith(RolePermissionEnumCaster::class)]
    public RolePermissionEnum $role;

    public static function fromRequest(RegisterRequest $request): UserDto
    {
        return new self($request->validated() + [
            'name' => $request->username,
            'role' => 'user',
        ]);
    }
}
