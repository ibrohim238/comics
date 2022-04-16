<?php

namespace App\Versions\V1\Http\Resources;

use App\Models\Comment;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Comment
*/
class CommentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'content' => $this->content,
            'user' => new UserResource($this->user()),
        ];
    }
}
