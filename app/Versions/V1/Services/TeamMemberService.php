<?php

namespace App\Versions\V1\Services;

use App\Enums\TeamRoleEnum;
use App\Models\Team;
use App\Models\User;
use App\Versions\V1\Dto\TeamMemberDto;
use App\Versions\V1\Repositories\TeamMemberRepository;
use function app;

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

    public function assignRole(TeamMemberDto $dto)
    {
        $this->repository->assignRole($dto->role->value);
    }

    public function updateRole(TeamMemberDto $dto)
    {
        $this->repository->updateRole($dto->role->value);
    }

    public function removeRole()
    {
        $this->repository->removeRole();
    }
}
