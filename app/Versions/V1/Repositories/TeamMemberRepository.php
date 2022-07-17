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

    public function assignRole(string $role): static
    {
        $this->user->addToTeam($this->team, $role);

        return $this;
    }

    public function updateRole(string $role): static
    {
        $this->user->updateToTeam($this->team, $role);

        return $this;
    }

    public function removeRole(): static
    {
        $this->user->removeToTeam($this->team);

        return $this;
    }
}
