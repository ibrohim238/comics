<?php

namespace App\Versions\V1\Repositories;

use App\Models\Coupon;
use App\Versions\V1\Dto\CouponDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;

class CouponRepository
{
    public function __construct(
      public Coupon $coupon
    ) {
    }

    public function paginate(?int $perPage): LengthAwarePaginator
    {
        return QueryBuilder::for($this->coupon)
            ->paginate($perPage);
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
