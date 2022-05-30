<?php

namespace App\Traits;

use App\Versions\V1\Reporters\RateReporter;

trait HasLikes
{
    public function likesDislikesCount(): int
    {
        return RateReporter::fromRateable($this)->count();
    }

    public function likesCount(): int
    {
        return RateReporter::fromRateable($this)->likesCount();
    }

    public function dislikesCount(): int
    {
        return RateReporter::fromRateable($this)->dislikesCount();
    }
}
