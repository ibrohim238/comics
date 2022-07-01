<?php

namespace App\Versions\V1\Http\Resources;

use App\Models\Coupon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Coupon
 */
class CouponResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'code' => $this->code,
            'data' => $this->data,
            'used' => $this->countActivated(),
            'limit' => $this->limit,
            'users' => new UserCollection($this->whenLoaded('eventUsers')),
        ];
    }
}
