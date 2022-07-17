<?php

namespace App\Versions\V1\Repositories;

use App\Enums\RolePermissionEnum;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserRepository
{
    public function __construct(
        private User $user
    ) {
    }

    public function paginate(?int $perPage): LengthAwarePaginator
    {
        return QueryBuilder::for($this->user)
            ->allowedFilters([
                'id',
                'name',
            ])
            ->paginate($perPage);
    }

    public function paginateInvitation(?int $perPage): LengthAwarePaginator
    {
        return QueryBuilder::for($this->user->invitations())
            ->paginate($perPage);
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

    public function getUser(): User
    {
        return $this->user;
    }

    public function fill(array $data): static
    {
        $this->user->fill($data);

        return $this;
    }

    public function save(): static
    {
        $this->user->save();

        return $this;
    }

    public function syncRoles(RolePermissionEnum $enum): static
    {
        $this->user->syncRoles($enum->value);

        return $this;
    }

    public function assignRole(RolePermissionEnum $enum): static
    {
        $this->user->assignRole($enum->value);

        return $this;
    }
}
