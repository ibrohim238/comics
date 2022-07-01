<?php

namespace App\Versions\V1\Services;

use App\Interfaces\Filterable;
use App\Models\Filter;
use Illuminate\Support\Collection;

class FilterSynchronizer
{
    public function __construct(
        public array $filters,
        public Filterable $filterable,
    ) {
    }

    public function sync(): void
    {
        $this->filterable->filters()->sync($this->filters);
    }
}
