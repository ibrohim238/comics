<?php

namespace App\Versions\V1\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

trait GroupedLastScope
{
    public function scopeLastPerGroup(Builder $query, string $column, string $columnMax) : Builder
    {
         return $query->whereIn($columnMax, function (QueryBuilder $query) use ($column, $columnMax) {
            return $query->from(static::getTable())
                ->selectRaw("max($columnMax)")
                ->groupBy($column);
        });
    }
}
