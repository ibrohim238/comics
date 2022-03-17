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
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'volume' => $this->volume,
            'number' => $this->number,
            'title' => $this->title,
            'order_column' => $this->order_column,
            'media' => new MediaCollection($this->media)
        ];
    }
}
