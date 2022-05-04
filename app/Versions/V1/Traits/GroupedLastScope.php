<?php

namespace App\Versions\V1\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

trait GroupedLastScope
{
    public function scopeLastPerGroup(Builder $query, string $column): Builder
    {
        return $query->whereIn('id', function (QueryBuilder $query) use ($column) {
            return $query->from(static::getTable())
                ->selectRaw("max(id)")
                ->groupBy($column);
        });
    }
}
