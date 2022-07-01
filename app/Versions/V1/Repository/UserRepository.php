<?php

namespace App\Versions\V1\Repository;

use App\Enums\RolePermissionEnum;
use App\Models\User;
use App\Versions\V1\Dto\UserDto;

class UserRepository
{
    public function __construct(
        private User $user
    ) {
    }

    public function fill(UserDto $dto): static
    {
        $this->user->fill($dto->toArray());

        return $this;
    }

    public function save(): static
    {
        $this->user->save();

        return $this;
    }

    public function assignRole(RolePermissionEnum $rolePermissionEnum): static
    {
        $this->user->assignRole($rolePermissionEnum->value);

        return $this;
    }
}
