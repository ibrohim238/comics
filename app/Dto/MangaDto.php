<?php

namespace App\Dto;

use App\Http\Requests\MangaRequest;
use Carbon\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

class MangaDto extends DataTransferObject
{
    public string $title;
    public string $description;
    public Carbon $publishedAt;

    public static function fromRequest(MangaRequest $request): MangaDto
    {
        return new self([
            'name' => $request->title,
            'description' => $request->description,
            'published_at' => $request->publishedAt
        ]);
    }
}
