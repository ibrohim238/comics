<?php

namespace App\Versions\V1\Services;

use App\Interfaces\Teamable;
use App\Models\Team;

class TeamableService
{
    public function __construct(
        public Team $team,
        public Teamable $teamable,
    ) {
    }

    public function attach(): void
    {
        $this->teamable->teams()->attach($this->team);
    }

    public function detach(): void
    {
        $this->teamable->teams()->attach($this->team);
    }
}
