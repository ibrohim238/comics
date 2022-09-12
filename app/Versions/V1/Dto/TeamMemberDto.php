<?php

namespace App\Versions\V1\Dto;

use App\Enums\TeamRoleEnum;
use App\Versions\V1\Http\Requests\TeamMemberRequest;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\EnumCaster;
use Spatie\DataTransferObject\DataTransferObject;

class TeamMemberDto extends DataTransferObject
{
    #[CastWith(EnumCaster::class, TeamRoleEnum::class)]
    public TeamRoleEnum $role;

    public static function fromArray(TeamMemberRequest $request): TeamMemberDto
    {
        return new self($request->validated());
    }
}
