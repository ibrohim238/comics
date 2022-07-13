<?php

namespace App\Dto;

use App\Caster\TeamRoleEnumCaster;
use App\Enums\TeamRoleEnum;
use App\Versions\V1\Http\Requests\TeamMemberRequest;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class TeamMemberDto extends DataTransferObject
{
    public array $roles;

    public static function fromArray(TeamMemberRequest $request): TeamMemberDto
    {
        return new self($request->validated());
    }
}
