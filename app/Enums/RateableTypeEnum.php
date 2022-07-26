<?php

namespace App\Enums;

enum RateableTypeEnum: string
{
    use EnumTrait;

    case manga = 'manga';
    case chapter = 'chapter';
    case comment = 'comment';
}
