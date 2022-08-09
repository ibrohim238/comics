<?php

namespace App\Versions\V1\Http\Resources;

use App\Models\Event;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Event
*/
class ChapterEventResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'model_type' => $this->eventable_type,
            'chapter' => new ChapterResource($this->whenLoaded('eventable'))
        ];
    }
}
