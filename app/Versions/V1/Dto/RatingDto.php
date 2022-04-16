<?php

namespace App\Versions\V1\Dto;

use App\Versions\V1\Http\Requests\Api\RatingRequest;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class RatingDto extends DataTransferObject
{
    public int $rating;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(RatingRequest $request)
    {
        return new self($request->validated());
    }
}
