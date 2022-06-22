<?php

namespace App\Traits;

use App\Models\Rate;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasRates
{
    public function rates(): MorphMany
    {
        return $this->morphMany(Rate::class, 'rateable');
    }
}
