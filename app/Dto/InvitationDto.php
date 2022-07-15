<?php

namespace App\Dto;

use App\Versions\V1\Http\Requests\InvitationRequest;
use Carbon\Carbon;

class InvitationDto extends BaseDto
{
    public int $user_id;
    public ?Carbon $ends_at;
    public string $data;

    public static function fromRequest(InvitationRequest $request): InvitationDto
    {
        return new self($request->validated());
    }
}
