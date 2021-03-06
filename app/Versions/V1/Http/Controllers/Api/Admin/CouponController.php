<?php

namespace App\Versions\V1\Http\Controllers\Api\Admin;

use App\Models\Coupon;
use App\Versions\V1\Dto\CouponDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\Admin\CouponRequest;
use App\Versions\V1\Http\Resources\CouponCollection;
use App\Versions\V1\Http\Resources\CouponResource;
use App\Versions\V1\Repositories\CouponRepository;
use App\Versions\V1\Services\Admin\CouponService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use function app;
use function response;

class CouponController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Coupon::class);
    }

    public function index(Request $request): CouponCollection
    {
        $coupons = app(CouponRepository::class)
            ->paginate($request->get('count'));

        return new CouponCollection($coupons);
    }

    public function store(\App\Versions\V1\Http\Requests\Admin\CouponRequest $request): CouponResource
    {
        $coupon = app(CouponService::class)
            ->create(CouponDto::fromRequest($request));

        return new CouponResource($coupon);
    }

    public function show(Coupon $coupon): CouponResource
    {
        return new CouponResource($coupon->load('eventUsers'));
    }

    public function update(\App\Versions\V1\Http\Requests\Admin\CouponRequest $request, Coupon $coupon): CouponResource
    {
        app(\App\Versions\V1\Services\Admin\CouponService::class, [
            'coupon' => $coupon
        ])->update(CouponDto::fromRequest($request));

        return new CouponResource($coupon);
    }

    public function destroy(Coupon $coupon): Response
    {
        app(CouponService::class, [
            'coupon' => $coupon
        ])->delete();

        return response()->noContent();
    }
}
