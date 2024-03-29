<?php

namespace App\Versions\V1\Dto;

use App\Versions\V1\Http\Requests\MangaRequest;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class MangaDto extends DataTransferObject
{
    public string $name;
    public string $description;
    public ?Carbon $published_at;
    public ?array $tags;
    public ?UploadedFile $media;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(MangaRequest $request): MangaDto
    {
        return new self($request->validated());
    }
}
