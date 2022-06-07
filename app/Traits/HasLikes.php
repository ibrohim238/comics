<?php

namespace App\Traits;

use App\Enums\RatesTypeEnum;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasLikes
{
    public function likes(): MorphMany
    {
        return $this->rates()->where('type', RatesTypeEnum::LIKE_TYPE->value);
    }

    public function likesCount(): int
    {
        return
            $this->likes()->where('value', true)->count()
            - $this->likes()->where('value', false)->count();
    }
}
