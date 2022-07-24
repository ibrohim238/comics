<?php

namespace App\Versions\V1\Dto;

use App\Caster\RolePermissionEnumCaster;
use App\Enums\RolePermissionEnum;
use Illuminate\Support\Facades\Hash;
use Spatie\DataTransferObject\Attributes\CastWith;

class UserDto extends BaseUserDto
{
    public string $name;
    public string $username;
    public string $email;
    public string $password;
    #[CastWith(RolePermissionEnumCaster::class)]
    public RolePermissionEnum $role;

    public static function fromArray(array $data): UserDto
    {
        return new self([
            'name' => $data['username'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role']
        ]);
    }
}
