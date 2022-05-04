<?php

namespace App\Versions\V1\Services;

use App\Models\Filter;
use App\Versions\V1\Dto\FilterDto;

class FilterService
{
    public function __construct(
        public Filter $filter
    ) {
    }

    public function create(FilterDto $dto): Filter
    {
        $this->fill($dto)->save();

        return $this->filter;
    }

    public function update(FilterDto $dto): Filter
    {
        $this->fill($dto)->save();

        return $this->filter;
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
