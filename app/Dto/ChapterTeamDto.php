<?php

namespace App\Dto;

use App\Versions\V1\Http\Requests\ChapterTeamRequest;
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
