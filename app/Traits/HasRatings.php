<?php

namespace App\Traits;

use App\Versions\V1\Reporters\RateReporter;

trait HasRatings
{
    public function ratingsAvg(): float
    {
        return RateReporter::fromRateable($this)->avg();
    }

    public function ratingsCount(): int
    {
        return RateReporter::fromRateable($this)->count();
    }
}
