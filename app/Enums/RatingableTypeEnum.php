<?php

namespace App\Enums;

enum RatingableTypeEnum: string
{
    use EnumTrait;

    case manga = 'manga';
}
