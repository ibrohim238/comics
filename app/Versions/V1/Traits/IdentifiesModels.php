<?php

namespace App\Versions\V1\Traits;

use App\Models\Chapter;
use App\Models\Commentable;
use App\Models\Manga;
use Illuminate\Database\Eloquent\Relations\Relation;

trait IdentifiesModels
{
    protected function identifyModel(string $type, int $id): ?Commentable
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
