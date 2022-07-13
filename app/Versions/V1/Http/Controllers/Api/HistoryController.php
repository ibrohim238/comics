<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Enums\EventTypeEnum;
use App\Models\Chapter;
use App\Models\Event;
use App\Versions\V1\Http\Resources\EventCollection;
use Illuminate\Http\Request;

class HistoryController
{
    public function __invoke(Request $request): EventCollection
    {
        $events = Event::query()
            ->with('eventable.manga.media')
            ->whereMorphRelation(
                'eventable',
                Chapter::class,
                'type',
                '!=',
                EventTypeEnum::DELETE_TYPE->value
            )
            ->paginate($request->get('count'));

        return new EventCollection($events);
    }
}
