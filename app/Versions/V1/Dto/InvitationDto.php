<?php

namespace App\Versions\V1\Dto;

use App\Versions\V1\Http\Requests\TeamInvitationRequest;
use Carbon\Carbon;

class InvitationDto extends BaseDto
{
    public int $user_id;
    public ?Carbon $ends_at;
    public string $data;

    public static function fromRequest(TeamInvitationRequest $request): InvitationDto
    {
        return new self($request->validated());
    }
}
