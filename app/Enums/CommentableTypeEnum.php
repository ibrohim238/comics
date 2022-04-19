<?php

namespace App\Enums;

enum CommentableTypeEnum: string
{
    use EnumTrait;

    case manga = 'manga';
    case chapter = 'chapter';
}
