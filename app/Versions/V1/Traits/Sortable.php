<?php

namespace App\Versions\V1\Traits;

use Illuminate\Database\Eloquent\Model;

trait Sortable
{
    protected static string $orderType = "";

    public static function bootSortable()
    {
        static::creating(function (Model $model) {
            if (static::$orderType) {
                $model->order = $model->newQuery()
                        ->where(static::$orderType, $model->{static::$orderType})
                        ->max('order') + 1;
                return;
            }

            $model->order = $model->newQuery()
                    ->max('order') + 1;
        });
    }
}
