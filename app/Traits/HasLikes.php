<?php

namespace App\Traits;

use App\Enums\RateTypeEnum;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasLikes
{
    public function likes(): MorphMany
    {
        return $this->rates()->where('type', RateTypeEnum::LIKE_TYPE->value);
    }

    public function likesCount(): int
    {
        return
            $this->likes()->where('value', true)->count()
            - $this->likes()->where('value', false)->count();
    }
}
