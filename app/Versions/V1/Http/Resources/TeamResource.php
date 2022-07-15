<?php

namespace App\Versions\V1\Http\Resources;

use App\Models\Team;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Team
*/
class TeamResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'media' => new MediaResource($this->getFirstMedia())
        ];
    }
}
