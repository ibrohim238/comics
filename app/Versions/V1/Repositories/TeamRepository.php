<?php

namespace App\Versions\V1\Repositories;

use App\Enums\TeamRoleEnum;
use App\Models\Team;
use App\Models\User;
use App\Versions\V1\Dto\TeamDto;
use App\Versions\V1\Services\TeamMemberService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\QueryBuilder\QueryBuilder;
use function app;

class TeamRepository
{
    public function __construct(
        private Team $team
    ) {
    }

    public function paginate(?int $perPage): LengthAwarePaginator
    {
        return QueryBuilder::for($this->team)
            ->allowedFilters([

            ])->paginate($perPage);
    }

    public function memberPaginate(?int $perPage): LengthAwarePaginator
    {
        return QueryBuilder::for($this->team->users())
            ->allowedFilters([

            ])
            ->paginate($perPage);
    }

    public function invitationPaginate(?int $perPage): LengthAwarePaginator
    {
        return QueryBuilder::for($this->team->invitations())
            ->allowedFilters([

            ])
            ->paginate($perPage);
    }

    public function fill(TeamDto $dto): static
    {
        $this->team->fill($dto->toArray());

        return $this;
    }

    public function save(): static
    {
        $this->team->save();

        return $this;
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function addImage(): static
    {
        $this->team->addMediaFromRequest('image')->toMediaCollection();

        return $this;
    }

    public function addMemberOwner(User $user): static
    {
        app(TeamMemberService::class, [
            'team' => $this->team,
            'user' => $user
        ])->assignRole(TeamRoleEnum::owner);

        return $this;
    }

    public function deleteMedia(): static
    {
        $this->team->clearMediaCollection();

        return $this;
    }

    public function delete(): static
    {
        $this->team->delete();

        return $this;
    }
}
