<?php

namespace App\Enums;

enum RatesTypeEnum: string
{
    use EnumTrait;

    case RATING_TYPE = 'rating';
    case LIKE_TYPE = 'like';
}
