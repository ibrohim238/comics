<?php

namespace App\Versions\V1\Http\Resources;

use App\Models\Chapter;
use App\Models\Manga;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 * @mixin Chapter
*/
class ChapterResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'volume' => $this->volume,
            'number' => $this->number,
            'title' => $this->title,
            'order_column' => $this->order_column,
            'media' => new MediaCollection($this->media),
            'likes' => $this->likes()->count(),
            'comments' => new CommentCollection($this->comments()),
        ];
    }
}
