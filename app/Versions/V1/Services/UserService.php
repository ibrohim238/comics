<?php

namespace App\Versions\V1\Services;

use App\Models\User;
use App\Versions\V1\Dto\UserDtoContract;
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

    public function store(UserDtoContract $dto): User
    {
        $this->repository
            ->fill($dto->forFillArray())
            ->save()
            ->assignRole($dto->getRole());

        return $this->user;
    }

    public function update(UserDtoContract $dto): User
    {
        $this->repository
            ->fill($dto->forFillArray())
            ->save()
            ->syncRoles($dto->getRole());

        return $this->user;
    }
}
