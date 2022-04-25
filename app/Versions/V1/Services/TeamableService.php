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
        $this->team->teamable()->attach($this->teamable);
    }

    public function delete(): void
    {
        $this->team->teamable()->detach($this->teamable);
    }
}
