<?php

namespace App\Versions\V1\Http\Resources;

use IAleroy\Tags\Tag;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Tag
*/
class TagResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type
        ];
    }
}
