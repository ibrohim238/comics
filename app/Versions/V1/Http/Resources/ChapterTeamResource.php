<?php

namespace App\Versions\V1\Http\Resources;

use App\Models\ChapterTeam;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ChapterTeam
*/
class ChapterTeamResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'team' => new TeamResource($this->whenLoaded('team')),
            'media' => new MediaCollection($this->whenLoaded('media')),
            'free_at' => $this->free_at
        ];
    }
}
