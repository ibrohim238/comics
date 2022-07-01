<?php

namespace App\Versions\V1\Repository;

use App\Models\Filter;
use App\Versions\V1\Dto\FilterDto;

class FilterRepository
{
    public function __construct(
        private Filter $filter
    ) {
    }

    public function fill(FilterDto $dto): static
    {
        $this->filter->fill($dto->toArray());

        return $this;
    }

    public function save(): static
    {
        $this->filter->save();

        return $this;
    }

    public function delete(): static
    {
        $this->filter->delete();

        return $this;
    }
}
