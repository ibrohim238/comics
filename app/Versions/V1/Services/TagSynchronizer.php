<?php

namespace App\Versions\V1\Services;

use App\Interfaces\Filterable;
use App\Models\Filter;
use Illuminate\Support\Collection;

class TagSynchronizer
{
    public function __construct(
        public array $tags,
        public Filterable $filterable,
    ) {
    }

    public function sync(): void
    {
        $this->filterable->filters()->sync($this->tags);
    }
}
