<?php

namespace App\Models\Team;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Teamable
{
    public function teams(): MorphMany;
}
