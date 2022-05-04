<?php

namespace App\Versions\V1\Services;

use App\Models\Coupon;
use App\Versions\V1\Dto\CouponDto;

class CouponService
{
    public function __construct(
      public Coupon $coupon
    ) {
    }

    public function create(CouponDto $dto): Coupon
    {
        $this->fill($dto)->save();

        return $this->coupon;
    }

    public function update(CouponDto $dto): Coupon
    {
        $this->fill($dto)->save();

        return $this->coupon;
    }

    public function fill(CouponDto $dto): static
    {
        $this->coupon->fill($dto->toArray());

        return $this;
    }

    public function save(): static
    {
        $this->coupon->save();

        return $this;
    }

    public function delete(): static
    {
        $this->coupon->delete();

        return $this;
    }
}
