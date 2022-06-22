<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Votable
{
    public function rates():MorphMany;

    public function votes(): MorphMany;
}
