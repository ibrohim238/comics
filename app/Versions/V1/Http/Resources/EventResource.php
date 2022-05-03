<?php

namespace App\Versions\V1\Http\Resources;

use App\Models\Chapter;
use App\Models\Event;
use App\Models\Manga;
use App\Versions\V1\Traits\WhenMorphToLoaded;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Event
*/
class EventResource extends JsonResource
{
    use WhenMorphToLoaded;

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'eventable' => $this->whenMorphToLoaded('eventable', [
                Chapter::class => ChapterResource::class,
                Manga::class => MangaResource::class,
            ])
        ];
    }
}
