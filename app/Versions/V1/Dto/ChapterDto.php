<?php

namespace App\Versions\V1\Dto;

use App\Versions\V1\Http\Requests\ChapterRequest;
use Carbon\Carbon;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ChapterDto extends DataTransferObject
{
    public int $volume;
    public int $number;
    public string $name;
    public ?Carbon $free_at;
    public ?array $images;
    public ?int $manga_id;
    public ?int $team_id;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(ChapterRequest $request): ChapterDto
    {
        return new self($request->validated());
    }
}
