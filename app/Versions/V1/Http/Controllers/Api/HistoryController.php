<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Enums\EventTypeEnum;
use App\Models\Chapter;
use App\Models\Event;
use App\Versions\V1\Http\Resources\EventCollection;

class HistoryController
{
    public function __invoke()
    {
        $events = Event::query()
            ->with('eventable')
            ->whereMorphRelation('eventable', Chapter::class,'type', '!=', EventTypeEnum::DELETE_TYPE->value)
            ->get();

        return new EventCollection($events->load('eventable.manga.media'));
    }
}
