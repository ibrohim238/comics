<?php

namespace App\Versions\V1\Repository;

use App\Enums\TeamRoleEnum;
use App\Models\Team;
use App\Models\User;
use App\Versions\V1\Dto\TeamMemberDto;

class TeamMemberRepository
{
    public function __construct(
        private Team $team,
        private User $user,
    )
    {
    }

    public function add(TeamRoleEnum $roleEnum)
    {
        $this->team->users()->attach($this->user, ['role' => $roleEnum->value]);
    }

    public function update(TeamRoleEnum $roleEnum): void
    {
        $this->team
            ->users()
            ->updateExistingPivot(
                $this->user->id,
                ['role' => $roleEnum->value]
            );
    }

    public function remove(): void
    {
        $this->team
            ->users()
            ->detach($this->user);
    }
}
