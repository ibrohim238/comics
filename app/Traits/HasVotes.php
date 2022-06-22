<?php

namespace App\Traits;

use App\Enums\RatesTypeEnum;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasVotes
{
    public function votes(): MorphMany
    {
        return $this->rates()->where('type', RatesTypeEnum::VOTE_TYPE->value);
    }
}
