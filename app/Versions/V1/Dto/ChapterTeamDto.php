<?php

namespace App\Versions\V1\Dto;

use App\Versions\V1\Http\Requests\Api\ChapterTeamRequest;
use Carbon\Carbon;

class ChapterTeamDto extends BaseDto
{
    public ?Carbon $free_at;
    public int $teamId;
    public ?array $images;

    public static function fromRequest(ChapterTeamRequest $request): ChapterTeamDto
    {
        return new self($request->validated());
    }
}
