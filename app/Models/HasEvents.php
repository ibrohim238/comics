<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use phpDocumentor\Reflection\Types\Static_;

trait HasEvents
{
    public function events(): MorphMany
    {
        return $this->morphMany(Event::class, 'eventable');
    }

    public function users(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, Event::class, 'events.user_id', 'id', 'id', 'events.eventable_id')
            ->where('eventable_type', array_search(static::class, Relation::morphMap()) ?: static::class);
    }
}
