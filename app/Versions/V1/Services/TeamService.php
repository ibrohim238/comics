<?php

namespace App\Versions\V1\Services;

use App\Enums\TeamRoleEnum;
use App\Models\Team;
use App\Models\User;
use App\Versions\V1\Dto\TeamDto;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class TeamService
{
    public function __construct(
        public Team $team
    ) {
    }

    public function create(TeamDto $dto, User $user): Team
    {
        $this->fill($dto)->save();
        app(TeamMemberService::class)
            ->add($this->team, $user, TeamRoleEnum::owner->value);

        return $this->team;
    }

    public function update(TeamDto $dto): Team
    {
        $this->fill($dto)->save();

        return $this->team;
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
    public function addMedia()
    {
        $this->team->addMediaFromRequest('image')->toMediaCollection();
    }

    public function delete()
    {
        $this->team->clearMediaCollection();
        $this->team->delete();
    }
}
