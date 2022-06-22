<?php

namespace App\Traits;

use App\Enums\RatesTypeEnum;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasRatings
{
    public function ratings(): MorphMany
    {
        return $this->rates()->where('type', RatesTypeEnum::RATING_TYPE->value);
    }
}
