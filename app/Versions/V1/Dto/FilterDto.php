<?php

namespace App\Versions\V1\Dto;

use App\Versions\V1\Http\Requests\Api\FilterRequest;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class FilterDto extends DataTransferObject
{
    public string $name;
    public ?string $description;
    public string $type;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(FilterRequest $request): FilterDto
    {
        return new self($request->validated());
    }
}
