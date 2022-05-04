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
        $this->fill($dto)->save()->assignRole(RolePermissionEnum::USER);

        return $this->user;
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
