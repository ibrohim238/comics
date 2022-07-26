<?php

namespace App\Versions\V1\Dto;

use App\Versions\V1\Http\Requests\LikeRequest;

class LikeDto extends RateDto
{
    public bool $value;

    public static function fromRequest(LikeRequest $request): LikeDto
    {
        return new self($request->validated());
    }
}
