<?php

namespace App\Versions\V1\Dto;

use App\Versions\V1\Http\Requests\Api\Admin\CouponRequest;
use Carbon\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

class CouponDto extends DataTransferObject
{
    public string $code;
    public ?string $data;
    public ?int $limit;
    public ?Carbon $ends_at;

    public static function fromRequest(CouponRequest $request): CouponDto
    {
        return new self($request->validated());
    }
}
