<?php

namespace App\Models;

use App\Enums\FilterTypeEnum;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasFilters
{
    public function filters(): MorphToMany
    {
        return $this->morphToMany(Filter::class, 'filterable');
    }

    public function filterType(FilterTypeEnum $filterTypeEnum): MorphToMany
    {
        return $this->filters()->where('type', $filterTypeEnum->value);
    }

    public function genres(): MorphToMany
    {
        return $this->filterType(FilterTypeEnum::GENRE_TYPE);
    }

    public function categories(): MorphToMany
    {
        return $this->filterType(FilterTypeEnum::CATEGORY_TYPE);
    }

    public function tags(): MorphToMany
    {
        return $this->filterType(FilterTypeEnum::TAG_TYPE);
    }
}
