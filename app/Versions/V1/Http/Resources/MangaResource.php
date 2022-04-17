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
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'media' => new MediaResource($this->getFirstMedia()),
            'rating' => round($this->ratings_avg_rating ?? 0, 3),
            'comments' => new CommentCollection($this->whenLoaded('comments')),
            'chapters' => new ChapterCollection($this->whenLoaded('chapters')),
        ];
    }
}
