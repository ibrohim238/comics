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
            ->select('events.*', 'chapters.team_id')
            ->whereMorphRelation('eventable', Chapter::class,'type', '!=', EventTypeEnum::DELETE_TYPE->value)
            ->leftJoin('chapters', 'eventable_id' , '=', 'chapters.id')
            ->groupBy('team_id')
            ->get();

        return new EventCollection($events->load('eventable'));
    }
}
