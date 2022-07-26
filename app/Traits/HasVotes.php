<?php

namespace App\Traits;

use App\Enums\RateTypeEnum;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasVotes
{
    public function votes(): MorphMany
    {
        return $this->rates()->where('type', RateTypeEnum::VOTE_TYPE->value);
    }
}
