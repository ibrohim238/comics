<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasEvents
{
    public function events(): MorphMany
    {
        return $this->morphMany(Event::class, 'eventable');
    }
}
