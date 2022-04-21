<?php

namespace App\Models\Team;

use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasTeamable
{
    public function teams(): MorphMany
    {
        return $this->morphMany(Team::class, 'teamable');
    }
}
