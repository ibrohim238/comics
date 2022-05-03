<?php

namespace App\Versions\V1\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'image' => $this->data['image'],
            'message' => $this->data['message'],
            'url' => $this->data['url'],
            'group_id' => $this->data['group_id'] ?? null,
            'read_at' => $this->read_at,
            'created_at' => $this->created_at,
        ];
    }
}
