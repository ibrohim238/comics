<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasBookmarks
{
    public static function bootHasBookmarks()
    {
        static::deleting(function (Model $model) {
            if (method_exists($model, 'isForceDeleting') && ! $model->isForceDeleting()) {
                return;
            }

            $model->bookmarkUsers()->detach();
        });
    }

    public function bookmarkUsers(): MorphToMany
    {
        return $this->morphToMany(User::class, 'bookmarkable', 'bookmarks')
            ->withPivot(['type']);
    }
}
