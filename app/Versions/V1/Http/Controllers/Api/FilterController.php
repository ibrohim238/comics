<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Filter;
use App\Versions\V1\Dto\FilterDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\Api\FilterRequest;
use App\Versions\V1\Http\Resources\FilterCollection;
use App\Versions\V1\Http\Resources\FilterResource;
use App\Versions\V1\Services\FilterService;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Spatie\QueryBuilder\QueryBuilder;

class FilterController extends Controller
{
    public function index(): FilterCollection
    {
        $filters = QueryBuilder::for(Filter::class)
            ->allowedFilters(['type'])
            ->get();

        return new FilterCollection($filters);
    }

    public function show(Filter $filter): FilterResource
    {
        return new FilterResource($filter);
    }

    /**
     * @throws UnknownProperties
     */
    public function store(FilterRequest $request): FilterResource
    {
        $filter = app(FilterService::class)->create(FilterDto::fromRequest($request));

        return new FilterResource($filter);
    }

    /**
     * @throws UnknownProperties
     */
    public function update(Filter $filter, FilterRequest $request): FilterResource
    {
        app(FilterService::class, [
            'filter' => $filter
        ])->update(FilterDto::fromRequest($request));

        return new FilterResource($filter);
    }

    public function destroy(Filter $filter)
    {
        app(FilterService::class, [
            'filter' => $filter
        ])->delete();

        return response()->noContent();
    }
}
