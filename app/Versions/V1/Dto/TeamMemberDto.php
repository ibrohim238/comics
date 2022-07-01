<?php

namespace App\Versions\V1\Dto;

use App\Enums\TeamRoleEnum;
use App\Versions\V1\Caster\TeamRoleEnumCaster;
use App\Versions\V1\Http\Requests\Api\TeamMemberRequest;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class TeamMemberDto extends DataTransferObject
{
    #[CastWith(TeamRoleEnumCaster::class)]
    public TeamRoleEnum $role;

    public static function fromArray(TeamMemberRequest $request): TeamMemberDto
    {
        return new self($request->validated());
    }
}
