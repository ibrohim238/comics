<?php

namespace App\Caster;

use App\Enums\TagTypeEnum;
use Spatie\DataTransferObject\Caster;

class TagTypeEnumCaster implements Caster
{
    public function cast(mixed $value): TagTypeEnum
    {
        return TagTypeEnum::from($value);
    }
}
