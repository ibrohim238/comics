<?php

namespace App\Versions\V1\Dto;

use App\Versions\V1\Http\Requests\Api\InvitationRequest;
use Carbon\Carbon;

class InvitationDto extends BaseDto
{
    public int $userId;
    public ?Carbon $ends_at;
    public string $data;

    public static function fromRequest(InvitationRequest $request): InvitationDto
    {
        return new self($request->validated());
    }
}
