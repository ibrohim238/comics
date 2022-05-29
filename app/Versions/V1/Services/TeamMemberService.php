<?php

namespace App\Versions\V1\Services;

use App\Models\Team;
use App\Models\User;

class TeamMemberService
{
    public function __construct(
        public Team $team,
        public User $user,
    ) {
    }

    public function add(string $role): void
    {
        $this->team
            ->users()
            ->attach(
                $this->user->id,
                ['role' => $role]
            );
    }

    public function update(string $role): void
    {
        $this->team
            ->users()
            ->updateExistingPivot(
                $this->user->id,
                ['role' => $role]
            );
    }

    public function  remove(): void
    {
        $this->team
            ->users()
            ->detach($this->user);
    }
}
