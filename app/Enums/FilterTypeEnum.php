<?php

namespace App\Enums;

enum FilterTypeEnum: string
{
    use EnumTrait;

    case GENRE_TYPE = 'genre';
    case CATEGORY_TYPE = 'category';
    case TAG_TYPE = 'tag';
}
