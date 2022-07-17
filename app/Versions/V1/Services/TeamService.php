<?php

namespace App\Versions\V1\Services;

use App\Models\Team;
use App\Versions\V1\Dto\TeamDto;
use App\Versions\V1\Repositories\TeamRepository;
use function app;

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

    public function store(TeamDto $dto): Team
    {
        $this->repository
            ->fill($dto)
            ->save();

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
