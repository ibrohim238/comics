<?php

namespace App\Traits;

use App\Models\Team;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasTeams
{
    public function teams(): MorphToMany
    {
        return $this->morphToMany(Team::class, 'teamable');
    }
}
