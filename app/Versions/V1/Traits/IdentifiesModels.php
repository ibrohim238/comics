<?php

namespace App\Versions\V1\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

trait IdentifiesModels
{
    protected function identifyModel(string $type, int $id): ?Model
    {
//        $model = match ($type) {
//            'manga' => Manga::class,
//            'chapter' => Chapter::class,
//            default => throw new \Exception('Not supported type'),
//        };
        $model = Relation::getMorphedModel($type);

        return $model::findOrFail($id);
    }
}
