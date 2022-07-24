<?php

namespace App\Versions\V1\Dto;

use App\Caster\BookmarkTypeEnumCaster;
use App\Enums\BookmarkTypeEnum;
use App\Versions\V1\Http\Requests\BookmarkRequest;
use Spatie\DataTransferObject\Attributes\CastWith;

class BookmarkDto extends BaseDto
{
    #[CastWith(BookmarkTypeEnumCaster::class)]
    public BookmarkTypeEnum $type;

    public static function fromRequest(BookmarkRequest $request): BookmarkDto
    {
        return new self($request->validated());
    }
}