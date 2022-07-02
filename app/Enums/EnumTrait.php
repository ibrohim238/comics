<?php

namespace App\Enums;

use Illuminate\Database\Eloquent\Model;

trait EnumTrait
{
    public static function values(): array
    {
        return collect(self::cases())
            ->pluck('value')
            ->toArray();
    }

    public function identify(int $id): ?Model
    {
        return identifyModel($this->value, $id);
    }
}
