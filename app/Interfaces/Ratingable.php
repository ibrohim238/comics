<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Ratingable
{
    public function rates(): MorphMany;

    public function ratings(): MorphMany;
}
