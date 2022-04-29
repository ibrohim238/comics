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

    public function create(): void
    {
        $this->teamable->teams()->attach($this->team);
    }

    public function delete(): void
    {
        $this->teamable->teams()->attach($this->team);
    }
}
