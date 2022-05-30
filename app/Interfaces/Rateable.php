<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Rateable
{
    public function rates(): MorphMany;
}
