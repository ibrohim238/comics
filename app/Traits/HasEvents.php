<?php

namespace App\Traits;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\Relation;

trait HasEvents
{
    public function events(): MorphMany
    {
        return $this->morphMany(Event::class, 'eventable');
    }

    public function eventUsers(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, Event::class, 'events.user_id', 'id', 'id', 'events.eventable_id')
            ->where('eventable_type', array_search(static::class, Relation::morphMap()) ?: static::class);
    }
}
