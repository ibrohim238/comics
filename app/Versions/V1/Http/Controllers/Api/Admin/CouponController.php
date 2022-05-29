<?php

namespace App\Versions\V1\Http\Controllers\Api\Admin;

use App\Models\Coupon;
use App\Versions\V1\Dto\CouponDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\Api\Admin\CouponRequest;
use App\Versions\V1\Http\Resources\CouponCollection;
use App\Versions\V1\Http\Resources\CouponResource;
use App\Versions\V1\Services\CouponService;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $coupons = Coupon::query()->paginate($request->get('count'));

        return new CouponCollection($coupons);
    }

    public function store(CouponRequest $request)
    {
        app(CouponService::class)->create(CouponDto::fromRequest($request));
    }

    public function show(Coupon $coupon)
    {
        return new CouponResource($coupon->load('users'));
    }

    public function update(CouponRequest $request, Coupon $coupon)
    {
        app(CouponService::class, [$coupon])->update(CouponDto::fromRequest($request));
    }

    public function destroy(Coupon $coupon)
    {
        app(CouponService::class, [$coupon])->delete();
    }
}
