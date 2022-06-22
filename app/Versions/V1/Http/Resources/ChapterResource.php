<?php

namespace App\Versions\V1\Http\Resources;

use App\Models\Chapter;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Chapter
*/
class ChapterResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'volume' => $this->volume,
            'number' => $this->number,
            'title' => $this->name,
            'order' => $this->order,
            'votes' => $this->votes()->count(),
            'manga' => new MangaResource($this->whenLoaded('manga')),
            'media' => new MediaCollection($this->whenLoaded('media')),
        ];
    }
}
