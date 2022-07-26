<?php

namespace App\Caster;

use App\Enums\RateTypeEnum;
use Spatie\DataTransferObject\Caster;

class RateTypeEnumCaster implements Caster
{
    public function cast(mixed $value): RateTypeEnum
    {
        return RateTypeEnum::from($value);
    }
}