<?php

namespace App\Dto;

use App\Models\User;
use App\Versions\V1\Http\Requests\TeamRequest;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class TeamDto extends DataTransferObject
{
    public string $name;
    public ?string $description;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(TeamRequest $request): TeamDto
    {
        return new self($request->validated());
    }
}
