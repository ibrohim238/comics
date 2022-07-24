<?php

namespace App\Caster;

use App\Enums\BookmarkTypeEnum;
use Spatie\DataTransferObject\Caster;

class BookmarkTypeEnumCaster implements Caster
{
    public function cast(mixed $value): BookmarkTypeEnum
    {
        return BookmarkTypeEnum::from($value);
    }
}