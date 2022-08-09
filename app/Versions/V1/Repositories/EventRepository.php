<?php

namespace App\Versions\V1\Repositories;

use App\Enums\EventTypeEnum;
use App\Models\Chapter;
use App\Models\Event;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EventRepository
{
    public function chapterPaginate(?int $perPage): LengthAwarePaginator
    {
        return Event::query()
            ->with('eventable.manga.media')
            ->whereMorphRelation(
                'eventable',
                Chapter::class,
                'type',
                '!=',
                EventTypeEnum::DELETE_TYPE->value
            )
            ->paginate($perPage);
    }
}