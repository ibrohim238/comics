<?php

namespace App\Versions\V1\Http\Resources;

use App\Versions\V1\Dto\NotificationDto;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Versions\V1\Dto\\App\Versions\V1\Dto\NotificationDto
 */
class NotificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'image' => $this->image,
            'message' => $this->message,
            'url' => $this->url,
            'group_id' => $this->groupId,
            'read_at' => $this->readAt,
            'created_at' => $this->createdAt,
        ];
    }
}
