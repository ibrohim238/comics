<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasRatings
{
    public function ratings(): MorphMany
    {
        return $this->morphMany(Rating::class, 'rateable');
    }
}
