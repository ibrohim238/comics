<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

if (! function_exists('remove_api_segment')) {
    function remove_api_segment($route)
    {
        $swapDomain = str_replace(config('app.api_url'), config('app.url'), $route);

        return preg_replace('/api\/v[0-9]+\//', '', $swapDomain);
    }
}

function getMorphedType(string $class): string
{
    return array_search($class, Relation::morphMap()) ?: $class;
}

function identifyModel(string $type, int $id): ?Model
{
    $model = Relation::getMorphedModel($type);

    /* @var Model $model*/
    return $model::findOrFail($id);
}
