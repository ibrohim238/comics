<?php

namespace App\Dto;

use App\Http\Requests\MangaRequest;
use Carbon\Carbon;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class MangaDto extends DataTransferObject
{
    public string $title;
    public string $description;
    public Carbon $publishedAt;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(MangaRequest $request): MangaDto
    {
        return new self($request->validated());
    }
}
