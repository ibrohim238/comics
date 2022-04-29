<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Filter;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Services\FilterableService;
use App\Versions\V1\Traits\IdentifiesModels;

class FilterableController extends Controller
{
    use IdentifiesModels;

    public function attach(Filter $filter, string $model, int $id)
    {
        $model = $this->identifyModel($model, $id);

        app(FilterableService::class, [$filter, $model])->attach();
    }

    public function detach(Filter $filter, string $model, int $id)
    {
        $model = $this->identifyModel($model, $id);

        app(FilterableService::class, [$filter, $model])->detach();
    }
}
