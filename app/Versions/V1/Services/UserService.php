<?php

namespace App\Versions\V1\Services;

use App\Enums\RolePermissionEnum;
use App\Models\User;
use App\Versions\V1\Dto\Admin\UserDto as AdminUserDto;
use App\Versions\V1\Dto\UserDto;
use App\Versions\V1\Repositories\UserRepository;
use function app;

class UserService
{
    private UserRepository $repository;

    public function __construct(
        private User $user
    )
    {
        $this->repository = app(UserRepository::class, [
            'user' => $this->user
        ]);
    }

    public function store(UserDto $dto): User
    {
        $this->repository
            ->fill($dto->toArray())
            ->save()
            ->assignRole(RolePermissionEnum::USER);

        return $this->user;
    }

    public function update(AdminUserDto $dto): User
    {
        $this->repository
            ->fill($dto->except('role')->toArray())
            ->save()
            ->syncRoles($dto->role);

        return $this->user;
    }
}
