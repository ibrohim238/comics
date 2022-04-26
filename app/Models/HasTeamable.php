<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasTeamable
{
    public function teams(): MorphToMany
    {
        return $this->morphedByMany(Team::class, 'teamable');
    }
}
