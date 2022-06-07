<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Eventable
{
    public function events(): MorphMany;
}
