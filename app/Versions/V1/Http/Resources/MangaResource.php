<?php

namespace App\Versions\V1\Http\Resources;

use App\Models\Manga;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

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
            'rating' => $this->loadAvg('ratings', 'rating'),
            'comments' => new CommentCollection($this->comments),
        ];
    }
}
