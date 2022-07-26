<?php

namespace App\Versions\V1\Dto;

use App\Versions\V1\Http\Requests\RatingRequest;

class RatingDto extends RateDto
{
    public int $value;

    public static function fromRequest(RatingRequest $request): RatingDto
    {
        return new self($request->validated());
    }
}
