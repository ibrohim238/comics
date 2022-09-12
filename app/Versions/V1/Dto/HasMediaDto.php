<?php

namespace App\Versions\V1\Dto;

use App\Versions\V1\Http\Requests\HasMediaRequest;

class HasMediaDto extends BaseDto
{
    public ?array $media;

    public static function fromRequest(HasMediaRequest $request): HasMediaDto
    {
        return new self([
            'media' => $request->file('media'),
            'media_urls' => $request->media_urls,
            'xml' => $request->xml
        ]);
    }
}
