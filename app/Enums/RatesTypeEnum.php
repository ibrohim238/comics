<?php

namespace App\Enums;

enum RatesTypeEnum: string
{
    use EnumTrait;

    case RATING_TYPE = 'rating';
    case LIKE_TYPE = 'like';

    public function rateable(): array
    {
        return match ($this) {
            self::RATING_TYPE => RatingableTypeEnum::values(),
            self::LIKE_TYPE => LikeableTypeEnum::values(),
        };
    }
}
