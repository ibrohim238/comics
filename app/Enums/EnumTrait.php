<?php

namespace App\Enums;

trait EnumTrait
{
    public static function values(): array
    {
        return collect(self::cases())
            ->pluck('value')
            ->toArray();
    }
}
