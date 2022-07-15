<?php

namespace App\Versions\V1\Repositories;

use App\Dto\TeamDto;
use App\Enums\RolePermissionEnum;
use App\Enums\TeamRoleEnum;
use App\Models\Team;
use App\Models\User;
use App\Versions\V1\Services\TeamMemberService;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class TeamRepository
{
    public function __construct(
        private Team $team
    ) {
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
