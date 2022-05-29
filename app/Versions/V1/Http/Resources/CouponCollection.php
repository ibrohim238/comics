<?php

namespace App\Versions\V1\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CouponCollection extends ResourceCollection
{
    public $collects = CouponResource::class;
}
