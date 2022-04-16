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
class MangaChaptersResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'manga' => new MangaResource($this),
            'chapters' => new ChapterCollection($this->chapters),
        ];
    }
}
