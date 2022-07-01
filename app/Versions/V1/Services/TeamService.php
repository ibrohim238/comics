<?php

namespace App\Versions\V1\Services;

use App\Enums\TeamRoleEnum;
use App\Models\Team;
use App\Models\User;
use App\Versions\V1\Dto\TeamDto;
use App\Versions\V1\Repository\TeamRepository;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class TeamService
{
    public TeamRepository $repository;

    public function __construct(
        private Team $team
    ) {
        $this->repository = app(TeamRepository::class, [
           'team' => $this->team
        ]);
    }

    public function store(TeamDto $dto, User $user): Team
    {
        $this->repository
            ->fill($dto)
            ->save()
            ->addMemberOwner($user);

        return $this->team;
    }

    public function update(TeamDto $dto): Team
    {
        $this->repository
            ->fill($dto)
            ->save();

        return $this->team;
    }

    public function delete(): void
    {
        $this->repository
            ->deleteMedia()
            ->delete();
    }
}
