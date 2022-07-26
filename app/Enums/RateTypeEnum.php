<?php

namespace App\Enums;

enum RateTypeEnum: string
{
    use EnumTrait;

    case RATING_TYPE = 'rating';
    case LIKE_TYPE = 'like';
    case VOTE_TYPE = 'vote';

    public function rateable(): array
    {
        return match ($this) {
            self::RATING_TYPE => RatingableTypeEnum::values(),
            self::LIKE_TYPE => LikeableTypeEnum::values(),
            self::VOTE_TYPE => VotableTypeEnum::values(),
        };
    }
}
