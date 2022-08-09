<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Versions\V1\Http\Resources\ChapterEventCollection;
use App\Versions\V1\Repositories\EventRepository;
use Illuminate\Http\Request;

class NewsController
{
    public function __invoke(Request $request): ChapterEventCollection
    {
        $events = app(EventRepository::class)
            ->chapterPaginate($request->get('count'));

        return new ChapterEventCollection($events);
    }
}
