<?php

namespace App\Versions\V1\Repository;

use App\Enums\RolePermissionEnum;
use App\Models\User;
use App\Versions\V1\Dto\UserDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserRepository
{
    public function __construct(
        private User $user
    ) {
    }

    public function paginateInvitation(?int $perPage): LengthAwarePaginator
    {
        return $this->user->invitations()->paginate($perPage);
    }

    public function paginateManga(?int $perPage): LengthAwarePaginator
    {
        return QueryBuilder::for($this->user->mangas())
            ->allowedFilters(
                AllowedFilter::exact('teams', 'teams.id'),
                AllowedFilter::exact('genres', 'genres.name'),
                AllowedFilter::exact('categories', 'categories.name'),
                AllowedFilter::exact('tags', 'tags.name')
            )->paginate($perPage);
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
