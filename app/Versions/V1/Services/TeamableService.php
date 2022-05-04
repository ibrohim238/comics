<?php

namespace App\Versions\V1\Services;

use App\Models\Team;
use App\Models\Teamable;

class TeamableService
{
    public function __construct(
        public Teamable $teamable,
        public Team $team
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
