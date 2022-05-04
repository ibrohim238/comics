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
            'limit' => $this->limit,
            'count' => $this->countActivated(),
            'users' => new UserCollection($this->whenLoaded('users')),
        ];
    }
}
