<?php

namespace App\Versions\V1\Http\Resources;

use App\Models\Invitation;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Invitation
*/
class InvitationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->user),
            'data' => $this->data,
        ];
    }
}
