<?php

namespace App\Enums;

enum MediaModelTypeEnum: string
{
    use EnumTrait;

    case manga = 'manga';
    case chapter = 'chapter';
}
