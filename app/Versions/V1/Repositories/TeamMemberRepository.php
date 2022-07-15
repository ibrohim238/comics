<?php

namespace App\Versions\V1\Repositories;

use App\Models\Team;
use App\Models\User;

class TeamMemberRepository
{
    public function __construct(
        private Team $team,
        private User $user,
    )
    {
    }

    public function syncRole(string $role)
    {
        $this->user->syncTeam($this->team, $role);
    }

    public function assignRole(string $role): void
    {
        $this->user->addToTeam($this->team, $role);
    }

    public function removeRole(): void
    {
        $this->user->removeToTeam($this->team);
    }
}
