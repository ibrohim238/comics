<?php

namespace App\Versions\V1\Services;

use App\Models\Filter;
use App\Versions\V1\Dto\FilterDto;
use App\Versions\V1\Repository\FilterRepository;

class FilterService
{
    public FilterRepository $repository;

    public function __construct(
        public Filter $filter
    ) {
        $this->repository = app(FilterRepository::class, [
           'filter' => $this->filter
        ]);
    }

    public function store(FilterDto $dto): Filter
    {
        $this->repository
            ->fill($dto)
            ->save();

        return $this->filter;
    }

    public function update(FilterDto $dto): Filter
    {
        $this->repository
            ->fill($dto)
            ->save();

        return $this->filter;
    }

    public function delete(): void
    {
        $this->repository
            ->delete();
    }
}
