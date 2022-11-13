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
    public ?int $manga_id;
    public ?int $team_id;
    public float $price;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(ChapterRequest $request): ChapterDto
    {
        return new self([
            'volume' => $request->volume,
            'number' => $request->number,
            'name' => $request->name,
            'free_at' => $request->free_at,
            'media' =>$request->media,
            'manga_id' => $request->manga_id,
            'team_id' => $request->team_id,
            'price' => $request->price,
        ]);
    }
}
