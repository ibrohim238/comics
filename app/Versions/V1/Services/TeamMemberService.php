<?php

namespace App\Versions\V1\Services;

use App\Dto\TeamMemberDto;
use App\Enums\TeamRoleEnum;
use App\Models\Team;
use App\Models\User;
use App\Versions\V1\Repositories\TeamMemberRepository;

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

    public function syncRoles(TeamMemberDto $dto)
    {
        $this->repository->syncRoles($dto->roles);
    }

    public function assignRole(TeamRoleEnum $enum)
    {
        $this->repository->assignRole($enum->value);
    }

    public function removeRole(TeamRoleEnum $enum)
    {
        $this->repository->removeRole($enum->value);
    }
}
