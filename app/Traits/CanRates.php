<?php

namespace App\Traits;

use App\Enums\RatesTypeEnum;
use App\Models\Rate;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait CanRates
{
    public function rates(): HasMany
    {
        return $this->hasMany(Rate::class);
    }

    public function ratings(): HasMany
    {
        return $this->rates()->where('type', RatesTypeEnum::RATING_TYPE);
    }

    public function likes(): HasMany
    {
        return $this->rates()->where('type', RatesTypeEnum::LIKE_TYPE);
    }
}
