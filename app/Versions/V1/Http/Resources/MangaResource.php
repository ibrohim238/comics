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
            'rating' => new RatingResource($this->ratings()),
            'comments' => new CommentCollection($this->whenLoaded('comments')),
            'chapters' => new CommentCollection($this->whenLoaded('chapters')),
        ];
    }
}
