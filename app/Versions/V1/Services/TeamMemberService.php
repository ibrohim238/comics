<?php

namespace App\Versions\V1\Services;

use App\Enums\TeamRoleEnum;
use App\Models\Team;
use App\Models\User;
use App\Versions\V1\Dto\TeamMemberDto;
use App\Versions\V1\Repository\TeamMemberRepository;

class TeamMemberService
{
    private TeamMemberRepository $repository;

    public function __construct(
        private Team $team,
        private User $user,
    )
    {
        $this->repository = app(TeamMemberRepository::class, [
            'team' => $this->team,
            'user' => $this->user,
        ]);
    }

    public function add(TeamRoleEnum $enum)
    {
        $this->repository->add($enum);
    }

    public function update(TeamMemberDto $dto): void
    {
        $this->repository->update($dto->role);
    }

    public function remove(): void
    {
        $this->repository->remove();
    }
}
