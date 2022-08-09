<?php

namespace App\Versions\V1\Dto;

use App\Caster\MangaSlugCaster;
use App\Models\Manga;
use App\Versions\V1\Http\Requests\ChapterRequest;
use Carbon\Carbon;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ChapterDto extends DataTransferObject
{
    public int $volume;
    public int $number;
    public string $name;
    public ?Carbon $free_at;
    public ?array $media;
    #[CastWith(MangaSlugCaster::class)]
    public ?Manga $manga;
    public ?int $team_id;
    public float $price;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(ChapterRequest $request): ChapterDto
    {
        return new self($request->validated());
    }
}
