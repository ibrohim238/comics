<?php

namespace App\Versions\V1\Services;

use App\Enums\RolePermissionEnum;
use App\Models\User;
use App\Versions\V1\Dto\UserDto;
use App\Versions\V1\Repository\UserRepository;
use Illuminate\Database\Eloquent\Model;

class UserService
{
    public UserRepository $repository;

    public function __construct(
      public User $user
    ) {
        $this->repository = app(UserRepository::class, [
            'user' => $this->user
        ]);
    }

    public function store(UserDto $dto): User
    {
        $this->repository
            ->fill($dto)
            ->save()
            ->assignRole(RolePermissionEnum::USER);

        return $this->user;
    }
}
