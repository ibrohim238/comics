<?php

namespace App\Versions\V1\Http\Resources;

use App\Models\Like;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Like
*/
class LikeResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'count' => $this->count()
        ];
    }
}
