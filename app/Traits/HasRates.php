<?php

namespace App\Traits;

use App\Models\Rate;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasRates
{
    public static function bootHasRates()
    {
        static::deleting(function ($model) {
            if (method_exists($model, 'isForceDeleting') && ! $model->isForceDeleting()) {
                return;
            }

            $model->rates()->delete();
        });
    }

    public function rates(): MorphMany
    {
        return $this->morphMany(Rate::class, 'rateable');
    }
}
