<?php

namespace App\Enums;

enum LikeableTypeEnum: string
{
    use EnumTrait;

    case comment = 'comment';
}
