<?php

namespace App\Enums;

enum VotableTypeEnum: string
{
    use EnumTrait;

    case chapter = 'chapter';
}
