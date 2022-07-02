<?php

namespace App\Versions\V1\Dto;

use App\Versions\V1\Http\Requests\Api\RateRequest;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class RateDto extends DataTransferObject
{
    public ?int $value;
    public string $type;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(RateRequest $request): RateDto
    {
        return new self([
            'type' => $request->segment(3),
        ] + $request->validated());
    }
}
