<?php

namespace App\Traits;

use App\Models\Team;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasTeams
{
    public static function bootHasTeams()
    {
        static::deleting(function ($model) {
            if (method_exists($model, 'isForceDeleting') && ! $model->isForceDeleting()) {
                return;
            }

            $model->teams()->detach();
        });
    }

    public function teams(): MorphToMany
    {
        return $this->morphToMany(Team::class, 'teamable');
    }
}
