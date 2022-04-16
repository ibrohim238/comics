<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Rateable
{
    public function ratings(): MorphMany;
}
