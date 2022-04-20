<?php

namespace App\Versions\V1\Dto;

use App\Http\Requests\TeamRequest;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class TeamDto extends DataTransferObject
{
    public string $title;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(TeamRequest $request): TeamDto
    {
        return new self($request->validated());
    }
}
