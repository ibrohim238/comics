<?php

namespace App\Versions\V1\Services;

use App\Models\Filter;
use App\Models\Filterable;
use App\Models\Manga;

class FilterableService
{
    public function __construct(
        public Filter $filter,
        public Filterable $filterable,
    ) {
    }

    public function attach(): void
    {
        $this->filterable->filters()->attach($this->filter);
    }

    public function detach(): void
    {
        $this->filterable->filters()->detach($this->filter);
    }
}
