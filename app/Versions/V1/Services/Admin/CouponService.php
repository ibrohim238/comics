<?php

namespace App\Versions\V1\Services\Admin;

use App\Models\Coupon;
use App\Versions\V1\Dto\CouponDto;
use App\Versions\V1\Repositories\CouponRepository;
use function app;

class CouponService
{
    private CouponRepository $repository;

    public function __construct(
      private Coupon $coupon
    ) {
        $this->repository = app(CouponRepository::class, [
            'coupon'  => $this->coupon
        ]);
    }

    public function create(CouponDto $dto): Coupon
    {
        $this->repository
            ->fill($dto)
            ->save();

        return $this->coupon;
    }

    public function update(CouponDto $dto): Coupon
    {
        $this->repository
            ->fill($dto)
            ->save();

        return $this->coupon;
    }

    public function delete(): static
    {
        $this->repository
            ->delete();

        return $this;
    }
}
