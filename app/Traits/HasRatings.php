<?php

namespace App\Traits;

use App\Enums\RateTypeEnum;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasRatings
{
    public function ratings(): MorphMany
    {
        return $this->rates()->where('type', RateTypeEnum::RATING_TYPE->value);
    }
}
