<?php

namespace App\Enums;

use Illuminate\Database\Eloquent\Model;

enum CommentableTypeEnum: string
{
    use EnumTrait;

    case manga = 'manga';
    case chapter = 'chapter';
}
