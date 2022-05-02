<?php

namespace App\Versions\V1\Services;

use App\Enums\RolePermissionEnum;
use App\Models\User;
use App\Versions\V1\Dto\UserDto;
use Illuminate\Database\Eloquent\Model;

class UserService
{
    public function __construct(
      public User $user
    ) {
    }

    public function create(UserDto $dto): Model|User
    {
        $user = $this->user->create($dto->toArray());
        $user->assignRole(RolePermissionEnum::USER->value);

        return $user;
    }
}
