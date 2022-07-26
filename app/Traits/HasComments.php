<?php

namespace App\Traits;

use App\Interfaces\Commentable;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasComments
{
    public static function bootHasComments()
    {
        static::deleting(function (Commentable $model) {
            if (method_exists($model, 'isForceDeleting') && ! $model->isForceDeleting()) {
                return;
            }

            $model->comments()->forceDelete();
        });
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable')
            ->whereNull('parent_id');
    }
}
