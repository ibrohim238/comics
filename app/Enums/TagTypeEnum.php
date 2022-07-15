<?php

namespace App\Enums;

enum TagTypeEnum: string
{
    use EnumTrait;

    case GENRE_TYPE = 'genre';
    case CATEGORY_TYPE = 'category';
    case TAG_TYPE = 'tag';
}
