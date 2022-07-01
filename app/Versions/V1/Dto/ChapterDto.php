<?php

namespace App\Versions\V1\Dto;

use App\Versions\V1\Http\Requests\Api\ChapterRequest;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ChapterDto extends DataTransferObject
{
    public int $volume;
    public int $number;
    public string $name;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(ChapterRequest $request): ChapterDto
    {
        return new self([
            'volume' => $request->volume,
            'number' => $request->number,
            'name' => $request->number,
        ]);
    }
}
