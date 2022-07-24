<?php

namespace App\Versions\V1\Dto\Admin;

use App\Enums\RolePermissionEnum;
use App\Versions\V1\Dto\BaseUserDto;
use App\Versions\V1\Http\Requests\Admin\UserRequest;
use Illuminate\Support\Facades\Hash;
use Spatie\DataTransferObject\Attributes\CastWith;

class UserDto extends BaseUserDto
{
    public string $password;
    #[CastWith(RolePermissionEnum::class)]
    public RolePermissionEnum $role;

    public static function fromRequest(UserRequest $request): UserDto
    {
        return new self([
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
    }
}
