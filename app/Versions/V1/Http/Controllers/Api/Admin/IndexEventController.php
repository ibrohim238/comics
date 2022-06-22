<?php

namespace App\Versions\V1\Http\Controllers\Api\Admin;

use App\Models\Event;
use App\Versions\V1\Http\Resources\EventCollection;
use Illuminate\Http\Request;

class IndexEventController
{
    public function __invoke(Request $request)
    {
        $events = Event::with('eventable')
            ->paginate($request->get('count'));

        return new EventCollection($events);
    }
}
