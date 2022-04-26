<?php

namespace App\Versions\V1\Dto;

use App\Versions\V1\Http\Requests\Api\TeamRequest;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class TeamDto extends DataTransferObject
{
    public string $name;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(TeamRequest $request): TeamDto
    {
        return new self($request->validated());
    }
}
