<?php

namespace App\Enums;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

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
        $model = Relation::getMorphedModel($this->value);

        /* @var Model $model*/
        return $model::findOrFail($id);
    }
}
