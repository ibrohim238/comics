<?php

namespace App\Versions\V1\Http\Resources;

use App\Models\Manga;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Manga
*/
class MangaResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'media' => new MediaResource($this->getFirstMedia()),
            'tags' => new TagCollection($this->whenLoaded('tags')),
            'rating' => round($this->ratings()->avg('value'), 3),
            'ratings_count' => $this->ratings()->count(),
            'votes' => $this->chapterVotes()->count(),
        ];
    }
}
