<?php

namespace App\Versions\V1\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
*/
class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'verified' => $this->hasVerifiedEmail(),
            'avatar' => new MediaResource($this->getFirstMedia('avatar')),
            'created_at' => $this->created_at,
        ];
    }
}
