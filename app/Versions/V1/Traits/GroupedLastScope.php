<?php

namespace App\Versions\V1\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

trait GroupedLastScope
{
    public function scopeLastPerGroup(Builder $query, string $column, string $maxColumn = 'id'): Builder
    {
        return $query->whereIn($maxColumn, function (QueryBuilder $query) use ($column, $maxColumn) {
            return $query->from(static::getTable())
                ->selectRaw("max($maxColumn)")
                ->groupBy($column);
        });
    }
}
